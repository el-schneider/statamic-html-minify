# HTML Minify for Statamic

![Statamic 5 and 6](https://img.shields.io/badge/Statamic-5%20%7C%206-FF269E)
![PHP 8.2+](https://img.shields.io/badge/PHP-8.2%2B-777BB4)
[![Tests](https://github.com/el-schneider/statamic-html-minify/actions/workflows/tests.yaml/badge.svg)](https://github.com/el-schneider/statamic-html-minify/actions/workflows/tests.yaml)

Minifies HTML responses in Statamic 5 and 6 through Laravel's web middleware stack.

## Installation

```bash
composer require el-schneider/statamic-html-minify
php artisan vendor:publish --provider="ElSchneider\HtmlMinify\HtmlMinifyServiceProvider"
```

The published `config/html-minify.php` file controls the middleware and each `voku/html-min` option exposed by the addon.

```env
HTML_MINIFY_ENABLED=true
HTML_MINIFY_SKIP_ON_DEBUG=true
HTML_MINIFY_REMOVE_COMMENTS=true
```

Whitespace collapsing and removal between tags are disabled by default. Both can change rendered text: inter-tag removal joins inline elements, and `voku/html-min` 5.0.0 can discard literal non-breaking spaces while collapsing whitespace ([upstream issue #136](https://github.com/voku/HtmlMin/issues/136)). Enable either option only after testing representative pages.

See [DOCUMENTATION.md](./DOCUMENTATION.md) for every option and environment variable.

## Requirements

- PHP 8.2+
- Statamic 5 or 6

## Testing

```bash
composer test
```

## Credits

Maintained by [el-schneider](https://github.com/el-schneider). Based on the original addon by [Vaggelis Yfantis](https://github.com/octoper).

## License

MIT
