<?php

namespace ThiagoRizzo\PresentationPHP\Models\DocProps;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class Lpstr extends Model
{
    public string $value = '';

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        if ($element->tagName === 'vt:lpstr') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('vt:lpstr', $element);
        }

        if (!$node) {
            return null;
        }

        $instance = new self();

        $instance->value = $node->nodeValue;

        return $instance;
    }
}
