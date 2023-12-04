<?php

namespace ThiagoRizzo\PresentationPHP\Models\DocProps;

use DOMElement;
use ThiagoRizzo\PresentationPHP\Utils;

class Vector
{
    public ?string $baseType = null;

    public ?string $size = null;

    /** @var array<int, Lpstr>|null $lpstr */
    public ?array $lpstr = null;

    /** @var array<int, Variant>|null $variant */
    public ?array $variant = null;

    public static function load(DOMElement $element): ?self
    {
        $dom = Utils::getElement($element, 'vt:vector');
        if (!$dom) {
            return null;
        }

        $vector = new self();

        $vector->size = $dom->getAttribute('size');
        $vector->baseType = $dom->getAttribute('baseType');

        $lpstrs = $dom->getElementsByTagName('vt:lpstr');
        for ($i = 0; $i < $lpstrs->length; $i++) {
            $vector->lpstr[$i] = Lpstr::load($dom);
        }

        $variants = $dom->getElementsByTagName('vt:variant');
        for ($i = 0; $i < $variants->length; $i++) {
            $vector->variant[$i] = Variant::load($dom);
        }

        return $vector;
    }
}
