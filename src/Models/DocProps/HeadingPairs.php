<?php

namespace ThiagoRizzo\PresentationPHP\Models\DocProps;


use DOMElement;
use ThiagoRizzo\PresentationPHP\Utils;

class HeadingPairs
{
    public ?Vector $vector = null;

    public static function load(DOMElement $element): ?self
    {
        $dom = Utils::getElement($element, 'HeadingPairs');
        if (!$dom) {
            return null;
        }

        $headingPairs = new HeadingPairs();

        $headingPairs->vector = Vector::load($dom);

        return $headingPairs;
    }
}
