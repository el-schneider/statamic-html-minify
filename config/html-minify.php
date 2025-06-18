<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Enable HTML Minification
    |--------------------------------------------------------------------------
    |
    | This option allows you to completely enable or disable HTML minification.
    | When disabled, all HTML responses will be returned without modification.
    |
    */
    'enabled' => env('HTML_MINIFY_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Skip Minification in Debug Mode
    |--------------------------------------------------------------------------
    |
    | When enabled, HTML minification will be skipped when APP_DEBUG is true.
    | This can be useful during development to preserve readable HTML output.
    |
    */
    'skip_on_debug' => env('HTML_MINIFY_SKIP_ON_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | HTML Minification Options
    |--------------------------------------------------------------------------
    |
    | These options control how the HTML minification is performed. Each option
    | corresponds to a feature in the voku/html-min package.
    |
    */

    /**
     * Use HTML DOM parser for more advanced optimizations.
     */
    'optimizeViaHtmlDomParser' => env('HTML_MINIFY_OPTIMIZE_VIA_DOM_PARSER', true),

    /**
     * Remove HTML comments from the output.
     * Recommended for production to reduce file size.
     */
    'removeComments' => env('HTML_MINIFY_REMOVE_COMMENTS', true),

    /**
     * Sum up whitespace characters to single spaces.
     * Recommended for better compression.
     */
    'sumUpWhitespace' => env('HTML_MINIFY_SUM_UP_WHITESPACE', true),

    /**
     * Sort CSS class names alphabetically.
     * Can improve gzip compression.
     */
    'sortCssClassNames' => env('HTML_MINIFY_SORT_CSS_CLASS_NAMES', false),

    /**
     * Sort HTML attributes alphabetically.
     * Can improve gzip compression.
     */
    'sortHtmlAttributes' => env('HTML_MINIFY_SORT_HTML_ATTRIBUTES', false),

    /**
     * Remove whitespace around HTML tags.
     * WARNING: This can break layout in some cases!
     */
    'removeWhitespaceAroundTags' => env('HTML_MINIFY_REMOVE_WHITESPACE_AROUND_TAGS', false),

    /**
     * Remove whitespace between HTML tags.
     * Generally safe and provides good compression.
     */
    'removeSpacesBetweenTags' => env('HTML_MINIFY_REMOVE_SPACES_BETWEEN_TAGS', true),

    /**
     * Remove quotes around HTML attribute values when safe.
     * Can slightly reduce file size.
     */
    'removeOmittedQuotes' => env('HTML_MINIFY_REMOVE_OMITTED_QUOTES', false),

    /**
     * Remove optional HTML tags (like closing </p> tags).
     * WARNING: This can break some JavaScript and CSS selectors!
     */
    'removeOmittedHtmlTags' => env('HTML_MINIFY_REMOVE_OMITTED_HTML_TAGS', false),
];
