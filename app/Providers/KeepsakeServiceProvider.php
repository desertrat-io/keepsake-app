<?php

namespace App\Providers;

use App\Lib\Facades\Impl\Keepsake;
use App\Repositories\AccountRepositories\AccountEloquentRepository;
use App\Repositories\AccountRepositories\UserEloquentRepository;
use App\Repositories\ImageRepositories\ImageEloquentRepository;
use App\Repositories\ImageRepositories\ImageMetaEloquentRepository;
use App\Repositories\RepositoryContracts\AccountRepositoryContract;
use App\Repositories\RepositoryContracts\ImageMetaRepositoryContract;
use App\Repositories\RepositoryContracts\ImageRepositoryContract;
use App\Repositories\RepositoryContracts\UserRepositoryContract;
use App\Services\AccountServices\AccountService;
use App\Services\ImageServices\ImageService;
use App\Services\ServiceContracts\AccountServiceContract;
use App\Services\ServiceContracts\ImageServiceContract;
use Illuminate\Support\ServiceProvider;
use Intervention\Image\ImageManager;

class KeepsakeServiceProvider extends ServiceProvider
{
    protected array $serviceContracts = [
        AccountServiceContract::class => AccountService::class,
        ImageServiceContract::class => ImageService::class
    ];

    protected array $repositoryContracts = [
        UserRepositoryContract::class => UserEloquentRepository::class,
        AccountRepositoryContract::class => AccountEloquentRepository::class,
        ImageRepositoryContract::class => ImageEloquentRepository::class,
        ImageMetaRepositoryContract::class => ImageMetaEloquentRepository::class
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->bindServiceContracts();
        $this->bindRepositoryContracts();
        $this->bindCustomFacades();
    }

    // TODO: fix this, it's crap right now. Organize it properly so that it works
    protected function bindServiceContracts(): void
    {
        array_walk(
            $this->serviceContracts,
            fn (string $concrete, string $abstract) => $this->app->bind($abstract, $concrete)
        );
    }

    protected function bindRepositoryContracts(): void
    {
        if (config('keepsake.model_mode') === 'eloquent') {
            $this->app->when($this->serviceContracts[AccountServiceContract::class])->needs(
                UserRepositoryContract::class
            )->give($this->repositoryContracts[UserRepositoryContract::class]);

            $this->app->when($this->serviceContracts[AccountServiceContract::class])->needs(
                AccountRepositoryContract::class
            )->give($this->repositoryContracts[AccountRepositoryContract::class]);

            $this->app->when($this->serviceContracts[ImageServiceContract::class])->needs(
                ImageRepositoryContract::class
            )->give($this->repositoryContracts[ImageRepositoryContract::class]);

            $this->app->when($this->serviceContracts[ImageServiceContract::class])->needs(
                ImageMetaRepositoryContract::class
            )->give($this->repositoryContracts[ImageMetaRepositoryContract::class]);

            $this->app->bind(UserRepositoryContract::class, $this->repositoryContracts[UserRepositoryContract::class]);
        }
    }

    protected function bindCustomFacades(): void
    {
        $this->app->bind('image', fn (): ImageManager => new ImageManager(config('image.driver.imagick')));
        $this->app->bind('keepsake', fn (): Keepsake => new Keepsake());
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    protected function contextualRepositoryBindings(string $abstract, string $concrete): void
    {
    }

    protected function contextualServiceBindings(string $abstract, string $concrete): void
    {
    }

}
