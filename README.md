# HTML Minify for Statamic v5

![Statamic v5](https://img.shields.io/badge/Statamic-5.0+-FF269E)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4)
![Test Suite](https://github.com/el-schneider/statamic-html-minify/workflows/Test%20Suite/badge.svg)

A modern HTML minification addon for Statamic v5 that automatically compresses your website's HTML output, reducing page load times and bandwidth usage.

## Features

- **Automatic HTML Minification**: Compresses HTML on every request via middleware
- **Statamic v5 Compatible**: Fully modernized for the latest Statamic version
- **Performance Optimized**: Cached minification engine for optimal performance
- **Developer Friendly**: Skip minification in debug mode during development
- **Highly Configurable**: Comprehensive configuration with environment variable support
- **Error Resilient**: Graceful fallback if minification fails
- **Production Ready**: Battle-tested with comprehensive test suite

## Installation

Install the addon via Composer:

```bash
composer require el-schneider/statamic-html-minify
```

Publish the configuration file:

```bash
php artisan vendor:publish --provider="ElSchneider\HtmlMinify\HtmlMinifyServiceProvider"
```

## Configuration

The addon provides extensive configuration options via `config/html-minify.php`:

```php
return [
    // Enable/disable minification entirely
    'enabled' => env('HTML_MINIFY_ENABLED', true),

    // Skip minification when APP_DEBUG is true
    'skip_on_debug' => env('HTML_MINIFY_SKIP_ON_DEBUG', false),

    // Minification options
    'removeComments' => env('HTML_MINIFY_REMOVE_COMMENTS', true),
    'sumUpWhitespace' => env('HTML_MINIFY_SUM_UP_WHITESPACE', true),
    'removeSpacesBetweenTags' => env('HTML_MINIFY_REMOVE_SPACES_BETWEEN_TAGS', true),

    // ... and many more options
];
```

### Environment Variables

All configuration options support environment variables for easy deployment:

```env
HTML_MINIFY_ENABLED=true
HTML_MINIFY_SKIP_ON_DEBUG=true
HTML_MINIFY_REMOVE_COMMENTS=true
```

## Documentation

For detailed configuration options and advanced usage, see the [DOCUMENTATION.md](./DOCUMENTATION.md).

## Requirements

- PHP 8.2+
- Statamic v5.0+
- Laravel 10/11

## Testing

Run the test suite:

```bash
vendor/bin/pest
```

## Credits

This addon is maintained by [el-schneider](https://github.com/el-schneider) and builds upon the original work by:

- [Vaggelis Yfantis](https://github.com/octoper) - Original author and creator
- [All Contributors](../../contributors)

Big thanks to Vaggelis for creating this addon and sharing it with the community! 🙏

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Resources

- [Statamic v5 Docs](https://statamic.dev)
- [Statamic Discord](https://statamic.com/discord)
