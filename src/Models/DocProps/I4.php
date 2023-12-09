<?php

namespace ThiagoRizzo\PresentationPHP\Models\DocProps;

use DOMElement;
use PhpOffice\Common\XMLReader;

class I4
{
    public ?string $value = null;

    public static function load(XMLReader $xmlReader, DOMElement $element): ?self
    {
        if ($element->tagName == 'vt:i4') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('vt:i4', $element);
        }

        if (!$node) {
            return null;
        }

        $i4 = new self();

        $i4->value = $node->nodeValue;

        return $i4;
    }
}
