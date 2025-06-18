<?php

namespace Octoper\HtmlMinify;

use Statamic\Providers\AddonServiceProvider;

class HtmlMinifyServiceProvider extends AddonServiceProvider
{
    protected $middlewareGroups = [
        'web' => [
            HtmlMinifyMiddleware::class,
        ],
    ];

    public function bootAddon(): void
    {
        $this->publishes([
            __DIR__.'/../config/html-minify.php' => config_path('html-minify.php'),
        ], 'statamic-html-minify-config');
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/html-minify.php',
            'html-minify'
        );
    }
}
