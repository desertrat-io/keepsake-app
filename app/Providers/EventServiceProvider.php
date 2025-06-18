<?php

namespace App\Providers;

use App\Events\Errors\KeepsakeExceptionThrown;
use App\Events\Images\ImageUploaded;
use App\Events\Images\ImageViewed;
use App\Events\Images\PdfUploaded;
use App\Events\Processing\PdfToJpegCompleted;
use App\Listeners\Audit\UserLoginListener;
use App\Listeners\Audit\UserLogoutListener;
use App\Listeners\Errors\KeepsakeExceptionThrownListener;
use App\Listeners\Images\ImageUploadedListener;
use App\Listeners\Images\ImageViewedListener;
use App\Listeners\Processing\ConvertUploadedPdfListener;
use App\Listeners\Processing\PdfToJpegCompletedListener;
use App\Listeners\Processing\PdfUploadedListener;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use PHPUnit\Framework\Attributes\CodeCoverageIgnore;

#[CodeCoverageIgnore] class EventServiceProvider extends ServiceProvider
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
        PdfToJpegCompleted::class => [
            PdfToJpegCompletedListener::class,
        ],
        KeepsakeExceptionThrown::class => [
            KeepsakeExceptionThrownListener::class
        ],
        ImageViewed::class => [
            ImageViewedListener::class
        ],
        Login::class => [
            UserLoginListener::class
        ],
        Logout::class => [
            UserLogoutListener::class
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
