<?php

namespace ThiagoRizzo\PresentationPHP\Models\DocProps;

use DOMElement;
use PhpOffice\Common\XMLReader;

class Vector
{
    public string $baseType = '';

    public string $size = '';

    /** @var Lpstr[]|null $lpstr */
    public ?array $lpstr = null;

    /** @var Variant[]|null $variant */
    public ?array $variant = null;

    public static function load(XMLReader $xmlReader, DOMElement $element): ?self
    {
        if ($element->tagName == 'vt:vector') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('vt:vector', $element);
        }

        if (!$node) {
            return null;
        }

        $vector = new self();

        $vector->size = $node->getAttribute('size');
        $vector->baseType = $node->getAttribute('baseType');

        $lpstrs = $xmlReader->getElements('vt:lpstr', $node);
        for ($i = 0; $i < $lpstrs->length; $i++) {
            $vector->lpstr[$i] = Lpstr::load($xmlReader, $lpstrs->item($i));
        }

        $variants = $xmlReader->getElements('vt:variant', $node);
        for ($i = 0; $i < $variants->length; $i++) {
            $vector->variant[$i] = Variant::load($xmlReader, $variants->item($i));
        }

        return $vector;
    }
}
