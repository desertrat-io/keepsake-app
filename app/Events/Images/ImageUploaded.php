<?php

namespace App\Events\Images;

use App\DTO\Images\ImageData;
use App\DTO\Images\ImageMetaData;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * @codeCoverageIgnore
 */
class ImageUploaded
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public ImageData $imageData, public ImageMetaData $imageMetaData)
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @codeCoverageIgnore
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
