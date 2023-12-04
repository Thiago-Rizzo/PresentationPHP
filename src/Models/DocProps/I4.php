<?php

namespace ThiagoRizzo\PresentationPHP\Models\DocProps;

use DOMElement;
use ThiagoRizzo\PresentationPHP\Utils;

class I4
{
    public ?string $value = null;

    public static function load(DOMElement $element): ?self
    {
        $dom = Utils::getElement($element, 'vt:i4');
        if (!$dom) {
            return null;
        }

        $i4 = new self();

        $i4->value = $dom->nodeValue;

        return $i4;
    }
}
