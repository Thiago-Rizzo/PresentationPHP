<?php

namespace ThiagoRizzo\PresentationPHP\Models\DocProps;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class Time extends Model
{
    public string $type = '';
    public string $value = '';

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        if ($element->tagName === $tag) {
            $node = $element;
        } else {
            $node = $xmlReader->getElement($tag, $element);
        }

        if (!$node) {
            return null;
        }

        $instance = new self();

        $instance->type = $node->getAttribute('xsi:type');

        $instance->value = $node->nodeValue;

        return $instance;
    }
}
