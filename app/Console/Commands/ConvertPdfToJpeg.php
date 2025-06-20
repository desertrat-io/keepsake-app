<?php

namespace App\Console\Commands;

use Exception;
use Grpc\ChannelCredentials;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use JetBrains\PhpStorm\Deprecated;
use Keepsake\Lib\Protocols\PdfConverter\ConvertPdfToJpegRequest;
use Keepsake\Lib\Protocols\PdfConverter\ConvertPdfToJpegResponse;
use Keepsake\Lib\Protocols\PdfConverter\KeepsakePdfConverterClient;
use Keepsake\Lib\Protocols\S3DataStore;
use PHPUnit\Framework\Attributes\CodeCoverageIgnore;

/**
 * This is just a helper command that will be removed at some point, no need to test
 */
#[CodeCoverageIgnore] #[Deprecated]
class ConvertPdfToJpeg extends Command
{
    public const string KAFKA_IP_VER = 'v4';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'keepsake:convert-jpeg';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tester to publish a message that converts a jpeg to pdf via that microservice';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = new KeepsakePdfConverterClient(
            '127.0.0.1:50001',
            ['credentials' => ChannelCredentials::createInsecure()]
        );
        $converter = new ConvertPdfToJpegRequest();
        $converter->setCorrelationId(uniqid());
        $converter->setFileLocator('media/images/dev/9eb4aacd-6c6e-4276-8fa7-387f98b3755e/017beslutsunderlag1020241104_241141517.pdf');
        $converter->setFileName('017beslutsunderlag1020241104_241141517.pdf');
        $converter->setOriginalMime('application/pdf');
        $dataStore = new S3DataStore();
        $dataStore->setRegion(env('AWS_DEFAULT_REGION', 'eu-north-1'));
        $dataStore->setBucketName(env('AWS_BUCKET'));
        $dataStore->setTenantName(env('DEFAULT_TENANT_NAME'));
        $dataStore->setFileKey('media/images/dev/9eb4aacd-6c6e-4276-8fa7-387f98b3755e/017beslutsunderlag1020241104_241141517.pdf');
        $dataStore->setFilePath('media/images/dev/9eb4aacd-6c6e-4276-8fa7-387f98b3755e');
        $dataStore->setFileName('017beslutsunderlag1020241104_241141517.pdf');
        $converter->setS3DataStore($dataStore);
        try {
            [$result, $status] = $client->ConvertToPdf($converter)->wait();
            if ($result instanceof ConvertPdfToJpegResponse) {
                $this->info('Response received!');
                $this->info(json_encode($result->serializeToJsonString()));
                foreach ($result->getFiles() as $file) {
                    $this->info($file->getFileFinalLocation());
                    $this->info($file->getFileName());
                }
            }
        } catch (Exception $exception) {
            $this->error($exception->getMessage());
            Log::error($exception->getMessage());
        }
    }
}
