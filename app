#!/usr/bin/env php
<?php

use Illuminate\Console\Application;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;

try {
    require_once __DIR__.'/vendor/autoload.php';

    $logger = new Logger('transactions');
    $logstream = new StreamHandler('errors.log', Logger::INFO);
    $logstream->setFormatter(new JsonFormatter());

    $logger->pushHandler($logstream);

    $container = new Container();
    $dispatcher = new Dispatcher();

    $app = new Application($container, $dispatcher, '0.1');
    $app->setName('Calculator');
    $appConfig = require_once __DIR__.'/config/app.php';
    $providers = $appConfig['providers'];

    foreach ($providers as $provider) {
        $container->make($provider)->register($container);
    }

    $commands = require __DIR__.'/commands.php';
    $commands = collect($commands)
        ->map(
            function ($command) use ($app) {
                return $app->getLaravel()->make($command);
            }
        )
        ->all()
    ;

    $app->addCommands($commands);

    $app->run(new ArgvInput(), new ConsoleOutput());
} catch (Throwable $e) {
    $message_string = "{$e->getMessage()} (file: {$e->getFile()}, line: {$e->getLine()})";
    $logger->error($message_string);
    print ($e->getMessage());
}
