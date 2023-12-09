<?php

namespace ThiagoRizzo\PresentationPHP\Models\DocProps;

use DOMElement;
use PhpOffice\Common\XMLReader;

class Time
{
    public ?string $type = null;
    public ?string $value = null;

    public static function load(XMLReader $xmlReader, DOMElement $element, string $tagName = ''): ?self
    {
        if ($element->tagName == $tagName) {
            $node = $element;
        } else {
            $node = $xmlReader->getElement($tagName, $element);
        }

        if (!$node) {
            return null;
        }

        $time = new self();
        $time->type = $node->getAttribute('xsi:type');
        $time->value = $node->nodeValue;

        return $time;
    }
}
