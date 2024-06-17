<?php

namespace ThiagoRizzo\PresentationPHP\Models\DocProps;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class TitlesOfParts extends Model
{
    public ?Vector $vector = null;

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        if ($element->tagName === 'TitlesOfParts') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('TitlesOfParts', $element);
        }

        if (!$node) {
            return null;
        }

        $instance = new self();

        $instance->vector = Vector::load($xmlReader, $node);

        return $instance;
    }
}
