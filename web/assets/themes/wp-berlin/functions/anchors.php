<?php
/**
 * Created by PhpStorm.
 * User: alpipego
 * Date: 30.04.18
 * Time: 15:42
 */

add_filter('the_content', function (string $content) : string {
    libxml_use_internal_errors(true);
    $dom = new \DOMDocument('1.0', 'utf-8');
    $dom->loadHTML('<!DOCTYPE html><html><body>' . mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8') . '</body></html>');

    for ($i = 1; $i <= 6; $i++) {
        /** @var \DOMElement $heading */
        foreach ($dom->getElementsByTagName('h' . $i) as $heading) {
            if ($heading->hasAttribute('id') && !empty($heading->getAttribute('id'))) {
                continue;
            }

            $heading->setAttribute('id', sanitize_title_with_dashes($heading->textContent));
        }
    }

    $content = preg_replace('/^<!DOCTYPE.+?>/', '', str_replace([
        '<html>',
        '</html>',
        '<body>',
        '</body>',
    ], ['', '', '', ''], $dom->saveHTML()));

    libxml_clear_errors();

    return $content;
});
