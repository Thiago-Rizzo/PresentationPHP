<?php

namespace ThiagoRizzo\PresentationPHP\Models\DocProps;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class Vector extends Model
{
    public string $tag = 'vt:vector';

    public string $baseType = '';

    public string $size = '';

    /** @var Lpstr[]|null $lpstr */
    public ?array $lpstr = null;

    /** @var Variant[]|null $variant */
    public ?array $variant = null;

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        $instance = new static($tag);

        $node = $instance->getElement($xmlReader, $element);
        if (!$node) {
            return null;
        }

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
