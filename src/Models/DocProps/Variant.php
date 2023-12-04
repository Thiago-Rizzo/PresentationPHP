<?php

namespace ThiagoRizzo\PresentationPHP\Models\DocProps;

use DOMElement;
use ThiagoRizzo\PresentationPHP\Utils;

class Variant
{
    public ?Lpstr $lpstr = null;

    public ?I4 $i4 = null;

    public static function load(DOMElement $element): ?self
    {
        $dom = Utils::getElement($element, 'vt:variant');
        if (!$dom) {
            return null;
        }

        $variant = new self();

        $variant->lpstr = Lpstr::load($dom);
        $variant->i4 = I4::load($dom);

        return $variant;
    }
}
