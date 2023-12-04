<?php

namespace ThiagoRizzo\PresentationPHP\Models\DocProps;

use DOMElement;
use ThiagoRizzo\PresentationPHP\Utils;

class Lpstr
{
    public ?string $value = null;

    public static function load(DOMElement $element): ?self
    {
        $dom = Utils::getElement($element, 'vt:lpstr');
        if (!$dom) {
            return null;
        }

        $lpstr = new self();

        $lpstr->value = $dom->nodeValue;

        return $lpstr;
    }
}
