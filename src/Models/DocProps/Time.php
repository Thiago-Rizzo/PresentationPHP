<?php

namespace ThiagoRizzo\PresentationPHP\Models\DocProps;

use DOMElement;
use ThiagoRizzo\PresentationPHP\Utils;

class Time
{
    public ?string $type = null;
    public ?string $value = null;

    public static function load(DOMElement $element, string $tagName = ''): ?self
    {
        $dom = Utils::getElement($element, $tagName);
        if (!$dom) {
            return null;
        }

        $time = new self();
        $time->type = $dom->getAttribute('xsi:type');
        $time->value = $dom->nodeValue;

        return $time;
    }
}
