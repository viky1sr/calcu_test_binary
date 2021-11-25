<?php

namespace Jakmall\Recruitment\Calculator\Providers;

use Illuminate\Contracts\Container\Container;
use Jakmall\Recruitment\Calculator\Container\ContainerServiceProviderInterface;
use Jakmall\Recruitment\Calculator\Repositories\CalculatorRepository;
use Jakmall\Recruitment\Calculator\Repositories\CalculatorRepositoryInterface;
use Jakmall\Recruitment\Calculator\Repositories\StorageRepository;
use Jakmall\Recruitment\Calculator\Repositories\StorageRepositoryInterface;

class RepositoryServiceProvider implements ContainerServiceProviderInterface
{
    /**
     * @inheritDoc
     */
    public function register(Container $container): void
    {
        $container->bind(
            StorageRepositoryInterface::class, StorageRepository::class,
        );
        $container->bind(
            CalculatorRepositoryInterface::class, CalculatorRepository::class,
        );
    }
}
