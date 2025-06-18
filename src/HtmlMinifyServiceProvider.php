<?php

namespace ElSchneider\HtmlMinify;

use Statamic\Providers\AddonServiceProvider;

/**
 * HTML Minify addon service provider.
 * 
 * This service provider registers the HTML minification middleware
 * and handles configuration publishing for the Statamic addon.
 * 
 * @package ElSchneider\HtmlMinify
 */
class HtmlMinifyServiceProvider extends AddonServiceProvider
{
    /**
     * The middleware groups to register with the application.
     * 
     * @var array<string, array<class-string>>
     */
    protected $middlewareGroups = [
        'web' => [
            HtmlMinifyMiddleware::class,
        ],
    ];

    /**
     * Boot the addon and register publishable assets.
     */
    public function bootAddon(): void
    {
        $this->publishes([
            __DIR__.'/../config/html-minify.php' => config_path('html-minify.php'),
        ], 'statamic-html-minify-config');
    }

    /**
     * Register the application services.
     * 
     * This method merges the addon's configuration with the application's
     * configuration, making it available via the config() helper.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/html-minify.php',
            'html-minify'
        );
    }
}
