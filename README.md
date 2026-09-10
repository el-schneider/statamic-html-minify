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

## Configuration

The published `config/html-minify.php` file controls the middleware and each `voku/html-min` option exposed by the addon.

```env
HTML_MINIFY_ENABLED=true
HTML_MINIFY_SKIP_ON_DEBUG=true
HTML_MINIFY_REMOVE_COMMENTS=true
```

Publish the configuration first:

```bash
php artisan vendor:publish --provider="ElSchneider\HtmlMinify\HtmlMinifyServiceProvider"
```

Every option can also be set through the listed environment variable.

| Config key | Environment variable | Default | Effect |
| --- | --- | --- | --- |
| `enabled` | `HTML_MINIFY_ENABLED` | `true` | Minify eligible HTML responses. |
| `skip_on_debug` | `HTML_MINIFY_SKIP_ON_DEBUG` | `false` | Return HTML unchanged when `APP_DEBUG=true`. |
| `optimizeViaHtmlDomParser` | `HTML_MINIFY_OPTIMIZE_VIA_DOM_PARSER` | `true` | Parse and optimize the HTML DOM. |
| `removeComments` | `HTML_MINIFY_REMOVE_COMMENTS` | `true` | Remove regular HTML comments. Protected conditional comments remain. |
| `sumUpWhitespace` | `HTML_MINIFY_SUM_UP_WHITESPACE` | `false` | Collapse runs of whitespace. Test before enabling: `voku/html-min` 5.0.0 can remove literal non-breaking spaces. |
| `sortCssClassNames` | `HTML_MINIFY_SORT_CSS_CLASS_NAMES` | `false` | Sort CSS class names for more compressible output. |
| `sortHtmlAttributes` | `HTML_MINIFY_SORT_HTML_ATTRIBUTES` | `false` | Sort attributes for more compressible output. |
| `removeWhitespaceAroundTags` | `HTML_MINIFY_REMOVE_WHITESPACE_AROUND_TAGS` | `false` | Remove whitespace around tags. This can change rendered text. |
| `removeSpacesBetweenTags` | `HTML_MINIFY_REMOVE_SPACES_BETWEEN_TAGS` | `false` | Remove whitespace between tags. This joins text separated by inline elements. |
| `removeOmittedQuotes` | `HTML_MINIFY_REMOVE_OMITTED_QUOTES` | `false` | Remove attribute quotes where HTML permits it. |
| `removeOmittedHtmlTags` | `HTML_MINIFY_REMOVE_OMITTED_HTML_TAGS` | `false` | Remove optional HTML tags. This can affect scripts and selectors that inspect source markup. |

### Existing installs and whitespace upgrades

Existing users who already published the config file will keep their previous values after package updates. When upgrading, explicitly set both of these to `false` (or set the environment variables to `false`) if your pages rely on existing whitespace boundaries:

- `sumUpWhitespace`
- `removeSpacesBetweenTags`

If config is cached, clear and rebuild it after changing these values:

```bash
php artisan config:clear
php artisan config:cache
```

### Behavior

The middleware skips streamed responses, JSON responses, disabled/debug requests, and responses whose `Content-Type` is not `text/html`.

The non-breaking-space behavior is tracked at <https://github.com/voku/HtmlMin/issues/136>.

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
