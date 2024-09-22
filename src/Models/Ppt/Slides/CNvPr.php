<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use PhpOffice\Common\XMLWriter;
use ThiagoRizzo\PresentationPHP\Models\Model;

class CNvPr extends Model
{
    public string $tag = 'p:cNvPr';

    public string $id = '';
    public string $name = '';

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        $instance = new static($tag);

        $node = $instance->getElement($xmlReader, $element);
        if (!$node) {
            return null;
        }

        $instance->id = $node->getAttribute('id');
        $instance->name = $node->getAttribute('name');

        return $instance;
    }

    public function write(XMLWriter $xmlWriter): void
    {
        $xmlWriter->startElement($this->tag);

        $this->id !== '' && $xmlWriter->writeAttribute('id', $this->id);
        $this->name !== '' && $xmlWriter->writeAttribute('name', $this->name);

        $xmlWriter->endElement();
    }
}
