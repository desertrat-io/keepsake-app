<?php

namespace App\Providers;

use App\Events\ImageUploaded;
use App\Events\ImageViewed;
use App\Events\KeepsakeExceptionThrown;
use App\Events\PdfUploaded;
use App\Listeners\ConvertUploadedPdfListener;
use App\Listeners\ImageUploadedListener;
use App\Listeners\ImageViewedListener;
use App\Listeners\KeepsakeExceptionThrownListener;
use App\Listeners\PdfUploadedListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * @codeCoverageIgnore
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ImageUploaded::class => [
            ImageUploadedListener::class
        ],
        PdfUploaded::class => [
            PdfUploadedListener::class,
            ConvertUploadedPdfListener::class
        ],
        KeepsakeExceptionThrown::class => [
            KeepsakeExceptionThrownListener::class
        ],
        ImageViewed::class => [
            ImageViewedListener::class
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
