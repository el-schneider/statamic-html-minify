<?php

namespace Octoper\HtmlMinify;

use voku\helper\HtmlMin;

/**
 * HTML Minification wrapper class.
 * 
 * This class provides a convenient interface for minifying HTML content
 * using the voku/html-min package with configurable options.
 * 
 * @package Octoper\HtmlMinify
 */
class HtmlMinify
{
    /**
     * The HTML content to be minified.
     */
    protected string $content;
    
    /**
     * Cached HtmlMin instance for performance optimization.
     */
    private static ?HtmlMin $htmlMinInstance = null;

    /**
     * Create a new HTML minification instance.
     * 
     * @param string $content The HTML content to minify
     */
    public function __construct(string $content)
    {
        $this->content = $content;
    }

    /**
     * Get the minified HTML content.
     * 
     * @return string The minified HTML
     */
    public function minifiedHtml(): string
    {
        return $this->getHtmlMinInstance()
            ->minify($this->content);
    }

    /**
     * Get the original unminified HTML content.
     * 
     * @return string The original HTML content
     */
    public function unminified(): string
    {
        return $this->content;
    }
    
    /**
     * Get a cached HtmlMin instance configured with current settings.
     * 
     * This method implements a singleton pattern to avoid recreating
     * the HtmlMin instance on every request, improving performance.
     * 
     * @return HtmlMin Configured HtmlMin instance
     */
    private function getHtmlMinInstance(): HtmlMin
    {
        if (self::$htmlMinInstance === null) {
            self::$htmlMinInstance = new HtmlMin();
        }
        
        $config_prefix = 'html-minify';
        
        return self::$htmlMinInstance
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
            );
    }
}