<?php

namespace App\Console\Commands;

use Exception;
use Grpc\ChannelCredentials;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Keepsake\Common\S3DataStore;
use Keepsake\Lib\Protocols\PdfConverter\ConvertPdfToJpegRequest;
use Keepsake\Lib\Protocols\PdfConverter\ConvertPdfToJpegResponse;
use Keepsake\Lib\Protocols\PdfConverter\KeepsakePdfConverterClient;

class ConvertJpegToPdf extends Command
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
            '127.0.0.1:50051',
            ['credentials' => ChannelCredentials::createInsecure()]
        );
        $converter = new ConvertPdfToJpegRequest();
        $converter->setCorrelationId(uniqid());
        $converter->setFileLocator('ansökan engelska-complete.pdf');
        $converter->setOriginalMime('image/jpeg');
        $dataStore = new S3DataStore();
        $dataStore->setRegion(env('AWS_DEFAULT_REGION', 'eu-north-1'));
        $dataStore->setBucketName(env('AWS_BUCKET'));
        $dataStore->setTenantName(env('DEFAULT_TENANT_NAME'));
        $converter->setS3DataStore($dataStore);
        try {
            list($result, $status) = $client->ConvertToPdf($converter)->wait();

            if ($result instanceof ConvertPdfToJpegResponse) {
                $this->info('Got a response supposedly');
                $this->info($result->getMeta()->getMessage());
            }
            $this->info(json_encode($result));
        } catch (Exception $exception) {
            $this->error($exception->getMessage());
            Log::error($exception->getMessage());
        }
    }
}
