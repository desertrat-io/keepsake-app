<?php

namespace App\Lib\Providers;

use App\Lib\Facades\Impl\Keepsake;
use App\Repositories\AccountRepositories\AccountEloquentRepository;
use App\Repositories\AccountRepositories\UserEloquentRepository;
use App\Repositories\DocumentRepositories\DocumentEloquentRepository;
use App\Repositories\ImageRepositories\BookmarkEloquentRepository;
use App\Repositories\ImageRepositories\ImageEloquentRepository;
use App\Repositories\ImageRepositories\ImageMetaEloquentRepository;
use App\Repositories\RepositoryContracts\AccountRepositoryContract;
use App\Repositories\RepositoryContracts\BookmarkRepositoryContract;
use App\Repositories\RepositoryContracts\DocumentRepositoryContract;
use App\Repositories\RepositoryContracts\ImageMetaRepositoryContract;
use App\Repositories\RepositoryContracts\ImageRepositoryContract;
use App\Repositories\RepositoryContracts\UserRepositoryContract;
use App\Services\AccountServices\AccountService;
use App\Services\DocumentServices\DocumentConverterService;
use App\Services\DocumentServices\DocumentService;
use App\Services\ImageServices\ImageService;
use App\Services\ServiceContracts\AccountServiceContract;
use App\Services\ServiceContracts\DocumentConverterServiceContract;
use App\Services\ServiceContracts\DocumentServiceContract;
use App\Services\ServiceContracts\ImageServiceContract;
use Illuminate\Support\ServiceProvider;
use Keepsake\Lib\Protocols\PdfConverter\KeepsakePdfConverterClient;
use PHPUnit\Framework\Attributes\CodeCoverageIgnore;

#[CodeCoverageIgnore]
class KeepsakeServiceProvider extends ServiceProvider
{
    protected array $serviceContracts = [
        AccountServiceContract::class => AccountService::class,
        ImageServiceContract::class => ImageService::class,
        DocumentServiceContract::class => DocumentService::class,
        DocumentConverterServiceContract::class => DocumentConverterService::class,
    ];

    protected array $eloquentContracts = [
        UserRepositoryContract::class => UserEloquentRepository::class,
        AccountRepositoryContract::class => AccountEloquentRepository::class,
        ImageRepositoryContract::class => ImageEloquentRepository::class,
        ImageMetaRepositoryContract::class => ImageMetaEloquentRepository::class,
        DocumentRepositoryContract::class => DocumentEloquentRepository::class,
        BookmarkRepositoryContract::class => BookmarkEloquentRepository::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->bindServiceContracts();
        $this->bindRepositoryContracts();
        $this->bindCustomFacades();
        $this->composedProviders();
    }

    // TODO: fix this, it's crap right now. Organize it properly so that it works
    protected function bindServiceContracts(): void
    {
        array_walk(
            $this->serviceContracts,
            fn(string $concrete, string $abstract) => $this->app->bind($abstract, $concrete)
        );
    }

    protected function bindRepositoryContracts(): void
    {
        if (config('keepsake.model_mode') === 'eloquent') {
            array_walk(
                $this->eloquentContracts,
                fn(string $concrete, string $abstract) => $this->app->bind($abstract, $concrete)
            );
        }
    }

    protected function bindCustomFacades(): void
    {
        $this->app->singleton('keepsake', fn(): Keepsake => new Keepsake());
    }

    protected function composedProviders(): void
    {
        $this->app->bind(KeepsakePdfConverterClient::class, fn() => new KeepsakePdfConverterClient(
            config('keepsake.pdf_converter_url'),
            ['credentials' => config('keepsake.pdf_converter_credentials')]
        ));
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

}
