# Configuration

Publish the addon configuration:

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

The non-breaking-space bug is tracked at https://github.com/voku/HtmlMin/issues/136. Its fix was merged after 5.0.0 at https://github.com/voku/HtmlMin/pull/139 but has not been included in a tagged release.

The middleware skips streamed responses, JSON responses, disabled/debug requests, and responses whose `Content-Type` is not `text/html`.
