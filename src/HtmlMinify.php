<?php

namespace Octoper\HtmlMinify;

use voku\helper\HtmlMin;

class HtmlMinify
{
    protected string $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function minifiedHtml(): string
    {
        $config_prefix = 'html-minify';

        return (new HtmlMin())
            ->doOptimizeViaHtmlDomParser(
                config("{$config_prefix}.optimizeViaHtmlDomParser")
            )
            ->doRemoveComments(
                config("{$config_prefix}.removeComments")
            )
            ->doSumUpWhitespace(
                config("{$config_prefix}.sumUpWhitespace")
            )
            ->doSortCssClassNames(
                config("{$config_prefix}.sortCssClassNames")
            )
            ->doSortHtmlAttributes(
                config("{$config_prefix}.sortHtmlAttributes")
            )
            ->doRemoveWhitespaceAroundTags(
                config("{$config_prefix}.removeWhitespaceAroundTags")
            )
            ->doRemoveSpacesBetweenTags(
                config("{$config_prefix}.removeSpacesBetweenTags")
            )
            ->doRemoveOmittedQuotes(
                config("{$config_prefix}.removeOmittedQuotes")
            )
            ->doRemoveOmittedHtmlTags(
                config("{$config_prefix}.removeOmittedHtmlTags")
            )
            ->minify($this->content);
    }

    public function unminified(): string
    {
        return $this->content;
    }
}
