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
