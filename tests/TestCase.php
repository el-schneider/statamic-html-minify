<?php

namespace ElSchneider\HtmlMinify\Tests;

use Illuminate\Support\Facades\Route;
use ElSchneider\HtmlMinify\HtmlMinifyMiddleware;
use ElSchneider\HtmlMinify\HtmlMinifyServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Statamic\Providers\StatamicServiceProvider;
use Statamic\Statamic;
use Statamic\Testing\Concerns\PreventsSavingStacheItemsToDisk;

abstract class TestCase extends OrchestraTestCase
{
    use PreventsSavingStacheItemsToDisk;
    protected function getPackageProviders($app): array
    {
        return [
            StatamicServiceProvider::class,
            HtmlMinifyServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app): array
    {
        return [
            'Statamic' => Statamic::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        parent::getEnvironmentSetUp($app);

        // Statamic v5 has automatic addon discovery, so manual manifest setup may not be needed
        // but keeping for compatibility
    }

    protected function resolveApplicationConfiguration($app): void
    {
        parent::resolveApplicationConfiguration($app);

        $configs = [
            'assets', 'cp', 'forms', 'static_caching',
            'sites', 'stache', 'system', 'users',
        ];

        foreach ($configs as $config) {
            $configPath = __DIR__."/../vendor/statamic/cms/config/{$config}.php";
            if (!file_exists($configPath)) {
                // Try the main project's vendor directory
                $configPath = __DIR__."/../../../../vendor/statamic/cms/config/{$config}.php";
            }
            if (file_exists($configPath)) {
                $app['config']->set("statamic.$config", require($configPath));
            }
        }

        $app['config']->set('statamic.users.repository', 'file');
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('html-minify.optimizeViaHtmlDomParser', true);

        // Workaround for registering routes for tests
        Statamic::booted(function () {
            Statamic::pushWebRoutes(function () {
                Route::namespace('\\ElSchneider\\HtmlMinify\\\Http\\Controllers')->group(function () {
                    Route::get('/html-minify/test', function () {
                        return response(file_get_contents(__DIR__.'/testPages/simpleMinify.html'), '200', [
                            'Content-Type' => 'text/html',
                        ]);
                    })->middleware(HtmlMinifyMiddleware::class);

                    Route::get('/html-minify/test/remove-comments', function () {
                        return response(file_get_contents(__DIR__.'/testPages/removeComments.html'), '200', [
                            'Content-Type' => 'text/html',
                        ]);
                    })->middleware(HtmlMinifyMiddleware::class);
                });
            });
        });
    }
}
