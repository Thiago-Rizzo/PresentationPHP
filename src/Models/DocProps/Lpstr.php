<?php

namespace ThiagoRizzo\PresentationPHP\Models\DocProps;

use DOMElement;
use PhpOffice\Common\XMLReader;

class Lpstr
{
    public string $value = '';

    public static function load(XMLReader $xmlReader, DOMElement $element): ?self
    {
        if ($element->tagName == 'vt:lpstr') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('vt:lpstr', $element);
        }

        if (!$node) {
            return null;
        }

        $lpstr = new self();

        $lpstr->value = $node->nodeValue;

        return $lpstr;
    }
}
