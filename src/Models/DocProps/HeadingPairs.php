<?php

namespace ThiagoRizzo\PresentationPHP\Models\DocProps;


use DOMElement;
use PhpOffice\Common\XMLReader;

class HeadingPairs
{
    public ?Vector $vector = null;

    public static function load(XMLReader $xmlReader, DOMElement $element): ?self
    {
        if ($element->tagName == 'HeadingPairs') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('HeadingPairs', $element);
        }

        if (!$node) {
            return null;
        }

        $headingPairs = new HeadingPairs();

        $headingPairs->vector = Vector::load($xmlReader, $node);

        return $headingPairs;
    }
}
