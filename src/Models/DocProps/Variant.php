<?php

namespace ThiagoRizzo\PresentationPHP\Models\DocProps;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class Variant extends Model
{
    public ?Lpstr $lpstr = null;

    public ?I4 $i4 = null;

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        if ($element->tagName == 'vt:variant') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('vt:variant', $element);
        }

        if (!$node) {
            return null;
        }

        $instance = new self();

        $instance->lpstr = Lpstr::load($xmlReader, $node);
        $instance->i4 = I4::load($xmlReader, $node);

        return $instance;
    }
}
