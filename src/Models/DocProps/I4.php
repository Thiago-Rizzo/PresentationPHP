<?php

namespace ThiagoRizzo\PresentationPHP\Models\DocProps;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class I4 extends Model
{
    public string $value = '';

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        if ($element->tagName === 'vt:i4') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('vt:i4', $element);
        }

        if (!$node) {
            return null;
        }

        $instance = new self();

        $instance->value = $node->nodeValue;

        return $instance;
    }
}
