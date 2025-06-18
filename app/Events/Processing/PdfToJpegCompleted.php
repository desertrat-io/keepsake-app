<?php

namespace App\Events\Processing;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Keepsake\Lib\Protocols\PdfConverter\ConvertPdfToJpegResponse;
use PHPUnit\Framework\Attributes\CodeCoverageIgnore;

#[CodeCoverageIgnore] class PdfToJpegCompleted implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;
    use InteractsWithBroadcasting;

    /**
     * Create a new event instance.
     */
    public function __construct(protected readonly ConvertPdfToJpegResponse $convertPdfToJpegResponse)
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('convert-pdf-to-jpeg')
        ];
    }

    public function getPdfToJpegResponse(): ConvertPdfToJpegResponse
    {
        return $this->convertPdfToJpegResponse;
    }
}
