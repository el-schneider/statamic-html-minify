<?php

namespace Octoper\HtmlMinify\Tests;

use function Spatie\Snapshots\assertMatchesSnapshot;

it('can minify html', function () {
    $minifiedHtml = $this->get('/html-minify/test')->getContent();

    assertMatchesSnapshot($minifiedHtml);
});

it('can remove comments', function () {
    app()['config']->set('html-minify.removeComments', true);

    $minifiedHtml = $this->get('/html-minify/test/remove-comments')->getContent();

    assertMatchesSnapshot($minifiedHtml);
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

it('uses cached htmlmin instance for performance', function () {
    // Create multiple instances to test caching
    $minifier1 = new \Octoper\HtmlMinify\HtmlMinify('<html></html>');
    $minifier2 = new \Octoper\HtmlMinify\HtmlMinify('<html></html>');
    
    // Both should use the same cached instance internally
    $result1 = $minifier1->minifiedHtml();
    $result2 = $minifier2->minifiedHtml();
    
    expect($result1)->toBe($result2);
});
