<?php

namespace App\Providers;

use App\Models\DatabaseHandler;
use App\Models\DoctrineDatabaseHandler;
use App\Models\LaravelPasswordHasher;
use App\Models\PasswordHasher;
use App\Models\RamseyUuidGenerator;
use App\Models\UuidGenerator;
use Doctrine\ORM\EntityManager;
use Illuminate\Contracts\Container\Container;
use Illuminate\Hashing\HashManager;
use Illuminate\Support\ServiceProvider;
use Ramsey\Uuid\UuidFactory;

/**
 * Class ModelServiceProvider
 *
 * @package App\Providers
 */
final class ModelServiceProvider extends ServiceProvider
{

    /**
     * @return void
     */
    public function register()
    {
        $this
            ->bindModels()
            ->bindModelFactories()
            ->bindDatabaseHandler()
            ->bindRepositories()
            ->bindUuidGenerator()
            ->bindPasswordHasher();
    }

    /**
     * @return $this
     */
    private function bindModels(): self
    {
        // TODO

        return $this;
    }

    /**
     * @return $this
     */
    private function bindModelFactories(): self
    {
        // TODO

        return $this;
    }

    /**
     * @return $this
     */
    private function bindDatabaseHandler(): self
    {
        $this->app->bind(
            DatabaseHandler::class,
            fn (Container $app, array $parameters) => new DoctrineDatabaseHandler($parameters[0], $parameters[1])
        );

        return $this;
    }

    /**
     * @param string $className
     *
     * @return DatabaseHandler
     */
    private function makeDatabaseHandler(string $className): DatabaseHandler
    {
        return $this->app->make(DatabaseHandler::class, [$this->app->get(EntityManager::class), $className]);
    }

    /**
     * @return $this
     */
    private function bindRepositories(): self
    {
        // TODO

        return $this;
    }

    /**
     * @return $this
     */
    private function bindUuidGenerator(): self
    {
        $this->app->singleton(UuidGenerator::class, fn () => new RamseyUuidGenerator(new UuidFactory()));

        return $this;
    }

    /**
     * @return $this
     */
    private function bindPasswordHasher(): self
    {
        $this->app->singleton(
            PasswordHasher::class,
            fn () => new LaravelPasswordHasher($this->app->get(HashManager::class))
        );

        return $this;
    }
}
