<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\SlideLayouts;

use DOMElement;
use PhpOffice\Common\XMLReader;
use PhpOffice\Common\XMLWriter;
use ThiagoRizzo\PresentationPHP\Models\Model;
use ThiagoRizzo\PresentationPHP\Models\Ppt\Slides\SpTree;

class CSld extends Model
{
    public string $tag = 'p:cSld';

    public string $name = '';

    public ?SpTree $spTree = null;

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        $instance = new static($tag);

        $node = $instance->getElement($xmlReader, $element);
        if (!$node) {
            return null;
        }

        $instance->name = $node->getAttribute('name');

        $instance->spTree = SpTree::load($xmlReader, $node);

        return $instance;
    }

    public function write(XMLWriter $xmlWriter): void
    {
        $xmlWriter->startElement($this->tag);

        $this->name !== '' && $xmlWriter->writeAttribute('name', $this->name);

        $this->spTree && $this->spTree->write($xmlWriter);

        $xmlWriter->endElement();
    }
}
