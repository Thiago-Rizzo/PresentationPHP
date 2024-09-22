<?php

namespace ThiagoRizzo\PresentationPHP\Models\DocProps;

use DOMElement;
use PhpOffice\Common\XMLReader;
use PhpOffice\Common\XMLWriter;
use ThiagoRizzo\PresentationPHP\Models\Model;

class Time extends Model
{
    public string $tag = '';

    public string $type = '';
    public string $value = '';

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        $instance = new static($tag);

        $node = $instance->getElement($xmlReader, $element);
        if (!$node) {
            return null;
        }

        $instance->type = $node->getAttribute('xsi:type');

        $instance->value = $node->nodeValue;

        return $instance;
    }

    public function write(XMLWriter $xmlWriter): void
    {
        $xmlWriter->startElement($this->tag);

        $this->type !== '' && $xmlWriter->writeAttribute('xsi:type', $this->type);

        $this->value !== '' && $xmlWriter->text($this->value);

        $xmlWriter->endElement();
    }
}
