<?php

namespace ThiagoRizzo\PresentationPHP\Models;

use DOMElement;
use PhpOffice\Common\XMLReader;

class Model
{
    public string $tag = '';

    public function __construct(string $tag = null)
    {
        $this->tag = $tag ?? $this->tag;
    }

    public function getElement(XMLReader $xmlReader, DOMElement $element): ?DOMElement
    {
        if ($element->nodeName === $this->tag) {
            $node = $element;
        } else {
            $node = $xmlReader->getElement($this->tag, $element);
        }

        return $node;
    }

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        $instance = new static($tag);

        $node = $instance->getElement($xmlReader, $element);
        if (!$node) {
            return null;
        }

        return $instance;
    }
}
