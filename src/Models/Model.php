<?php

namespace ThiagoRizzo\PresentationPHP\Models;

use DOMElement;
use PhpOffice\Common\XMLReader;
use PhpOffice\Common\XMLWriter;

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
            return $element;
        }

        return $xmlReader->getElement($this->tag, $element);
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

    public function write(XMLWriter $xmlWriter): void
    {
        $xmlWriter->startElement($this->tag);
        $xmlWriter->endElement();
    }
}
