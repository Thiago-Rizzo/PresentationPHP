<?php

namespace ThiagoRizzo\PresentationPHP\Models\DocProps;

use DOMElement;
use PhpOffice\Common\XMLReader;

class TitlesOfParts
{
    public ?Vector $vector = null;

    public static function load(XMLReader $xmlReader, DOMElement $element): ?self
    {
        if ($element->tagName == 'TitlesOfParts') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('TitlesOfParts', $element);
        }

        if (!$node) {
            return null;
        }

        $titlesOfParts = new self();

        $titlesOfParts->vector = Vector::load($xmlReader, $node);

        return $titlesOfParts;
    }
}
