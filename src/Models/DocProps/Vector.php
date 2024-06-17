<?php

namespace ThiagoRizzo\PresentationPHP\Models\DocProps;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class Vector extends Model
{
    public string $baseType = '';

    public string $size = '';

    /** @var Lpstr[]|null $lpstr */
    public ?array $lpstr = null;

    /** @var Variant[]|null $variant */
    public ?array $variant = null;

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        if ($element->tagName === 'vt:vector') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('vt:vector', $element);
        }

        if (!$node) {
            return null;
        }

        $instance = new self();

        $instance->size = $node->getAttribute('size');
        $instance->baseType = $node->getAttribute('baseType');

        $lpstrs = $xmlReader->getElements('vt:lpstr', $node);
        for ($i = 0; $i < $lpstrs->length; $i++) {
            $instance->lpstr[$i] = Lpstr::load($xmlReader, $lpstrs->item($i));
        }

        $variants = $xmlReader->getElements('vt:variant', $node);
        for ($i = 0; $i < $variants->length; $i++) {
            $instance->variant[$i] = Variant::load($xmlReader, $variants->item($i));
        }

        return $instance;
    }
}
