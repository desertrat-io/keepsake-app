<?php

namespace App\Events\Processing;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Log;
use PHPUnit\Framework\Attributes\CodeCoverageIgnore;

#[CodeCoverageIgnore]
class JpegProcessingComplete implements ShouldBroadcast
{
    use Dispatchable;
    use SerializesModels;
    use InteractsWithSockets;

    /**
     * Create a new event instance.
     */
    public function __construct(public readonly string $userUuid)
    {
        //
        Log::info('Broadcasting with user uuid: ' . $userUuid);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        Log::info('Broadcasting on: keepsake-' . $this->userUuid . '-jpeg-complete');
        return [
            new Channel('keepsake-' . $this->userUuid . '-jpeg-complete')
        ];
    }

    public function broadcastAs(): string
    {
        return 'jpeg.processing.complete';
    }
}
