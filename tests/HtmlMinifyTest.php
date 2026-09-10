<?php

namespace ElSchneider\HtmlMinify\Tests;

use ElSchneider\HtmlMinify\HtmlMinify;

it('can minify html', function () {
    $minifiedHtml = $this->get('/html-minify/test')->getContent();

    expect($minifiedHtml)->toBe(
        '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Title</title></head>'
        .'<body><p>Hello</p></body></html>'
    );
});

it('can remove comments', function () {
    app()['config']->set('html-minify.removeComments', true);

    $minifiedHtml = $this->get('/html-minify/test/remove-comments')->getContent();

    expect($minifiedHtml)->toBe(
        '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Title</title></head>'
        .'<body><p>Hello</p></body></html>'
    );
});

it('can be disabled via config', function () {
    app()['config']->set('html-minify.enabled', false);

    $response = $this->get('/html-minify/test');
    $html = $response->getContent();

    // Should contain original formatting (newlines, indentation)
    expect($html)->toContain("\n")
        ->and($html)->toContain('    '); // Indentation
});

it('can skip minification in debug mode', function () {
    app()['config']->set('html-minify.skip_on_debug', true);
    app()['config']->set('app.debug', true);

    $response = $this->get('/html-minify/test');
    $html = $response->getContent();

    // Should contain original formatting when debug is enabled
    expect($html)->toContain("\n")
        ->and($html)->toContain('    '); // Indentation
});

it('minifies when debug mode is disabled', function () {
    app()['config']->set('html-minify.skip_on_debug', true);
    app()['config']->set('app.debug', false);

    $response = $this->get('/html-minify/test');
    $html = $response->getContent();

    // Should be minified
    expect($html)->not->toContain("\n")
        ->and($html)->not->toContain('    '); // No indentation
});

it('preserves whitespace that separates inline elements by default', function () {
    $html = '<p>Hello <strong>world</strong> <a href="/again">again</a></p>';

    expect((new HtmlMinify($html))->minifiedHtml())
        ->toContain('</strong> <a href="/again">');
});

it('preserves literal non-breaking spaces by default', function () {
    $nbsp = "\u{00A0}";
    $html = "<span>foo {$nbsp}·{$nbsp} bar</span>";

    expect((new HtmlMinify($html))->minifiedHtml())
        ->toContain("foo {$nbsp}·{$nbsp} bar");
});

it('preserves script templates without leaking parser placeholders', function () {
    $html = '<script id="row" type="text/html"><tr><td colspan="5"></td></tr></script>'
        .'<script id="label" type="text/html">Label</script>';

    expect((new HtmlMinify($html))->minifiedHtml())
        ->toBe($html)
        ->not->toContain('simple_html_dom');
});

it('keeps JSON-LD valid while minifying its insignificant whitespace', function () {
    $html = <<<'HTML'
<script type="application/ld+json">
{
    "name": "two words",
    "items": [1, 2]
}
</script>
HTML;

    $minified = (new HtmlMinify($html))->minifiedHtml();

    expect($minified)
        ->toBe('<script type="application/ld+json">{"name":"two words","items":[1,2]}</script>');
});

it('preserves protected and whitespace-sensitive content', function () {
    $html = '<code><nocompress>  <strong> keep </strong>  </nocompress></code>'
        ."<pre>line  one\n  line two</pre>"
        ."<textarea>line  one\n  line two</textarea>";

    expect((new HtmlMinify($html))->minifiedHtml())
        ->toBe($html)
        ->not->toContain('html-min--voku--saved-content');
});

it('preserves conditional comments while removing regular comments', function () {
    $html = '<!--[if IE]><script src="legacy.js"></script><![endif]--><!-- remove -->';

    expect((new HtmlMinify($html))->minifiedHtml())
        ->toBe('<!--[if IE]><script src="legacy.js"></script><![endif]-->');
});

it('keeps repeated minifications isolated', function () {
    $first = (new HtmlMinify('<nocompress>  first  </nocompress>'))->minifiedHtml();
    $second = (new HtmlMinify('<nocompress>  second  </nocompress>'))->minifiedHtml();

    expect($first)->toContain('first')->not->toContain('second')
        ->and($second)->toContain('second')->not->toContain('first');
});
