<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class T extends Model
{
    public string $value = '';

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        if ($element->nodeName == 'a:t') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('a:t', $element);
        }

        if (!$node) {
            return null;
        }

        $instance = new self();

        $instance->value = $node->nodeValue;

        return $instance;
    }
}
