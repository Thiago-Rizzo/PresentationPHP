<?php

namespace ThiagoRizzo\PresentationPHP\Models\DocProps;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class I4 extends Model
{
    public string $tag = 'vt:i4';

    public string $value = '';

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        $instance = new static($tag);

        $node = $instance->getElement($xmlReader, $element);
        if (!$node) {
            return null;
        }

        $instance->value = $node->nodeValue;

        return $instance;
    }
}
