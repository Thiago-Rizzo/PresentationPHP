<?php

namespace ThiagoRizzo\PresentationPHP\Models\DocProps;

use DOMElement;
use ThiagoRizzo\PresentationPHP\Utils;

class TitlesOfParts
{
    public ?Vector $vector = null;

    public static function load(DOMElement $element): ?self
    {
        $dom = Utils::getElement($element, 'TitlesOfParts');
        if (!$dom) {
            return null;
        }

        $titlesOfParts = new self();

        $titlesOfParts->vector = Vector::load($dom);

        return $titlesOfParts;
    }
}
