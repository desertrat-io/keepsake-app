<?php

namespace App\Listeners;

use App\Events\KeepsakeExceptionThrown;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\EventModels\KeepsakeExceptionEvent as Model;

class KeepsakeExceptionThrownListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(KeepsakeExceptionThrown $event): void
    {
        $model = new Model();
        $model->message = $event->keepsakeException->getMessage();
        $model->response_code = $event->keepsakeException->errorResponseCode();
        $model->http_error_code = $event->keepsakeException->httpCode();
        $model->save();
    }
}
