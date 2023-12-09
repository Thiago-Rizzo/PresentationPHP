<?php

namespace ThiagoRizzo\PresentationPHP\Models\DocProps;

use DOMElement;
use PhpOffice\Common\XMLReader;

class Variant
{
    public ?Lpstr $lpstr = null;

    public ?I4 $i4 = null;

    public static function load(XMLReader $xmlReader, DOMElement $element): ?self
    {
        if ($element->tagName == 'vt:variant') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('vt:variant', $element);
        }

        if (!$node) {
            return null;
        }

        $variant = new self();

        $variant->lpstr = Lpstr::load($xmlReader, $node);
        $variant->i4 = I4::load($xmlReader, $node);

        return $variant;
    }
}
