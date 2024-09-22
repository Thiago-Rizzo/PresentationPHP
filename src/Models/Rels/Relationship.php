<?php

namespace ThiagoRizzo\PresentationPHP\Models\Rels;

use DOMElement;
use PhpOffice\Common\XMLReader;
use PhpOffice\Common\XMLWriter;
use ThiagoRizzo\PresentationPHP\Models\Model;

class Relationship extends Model
{
    public string $tag = 'Relationship';

    public string $id = '';
    public string $type = '';
    public string $target = '';

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        $instance = new static($tag);

        $node = $instance->getElement($xmlReader, $element);
        if (!$node) {
            return null;
        }

        $instance->id = $node->getAttribute('Id');
        $instance->type = $node->getAttribute('Type');
        $instance->target = $node->getAttribute('Target');

        return $instance;
    }

    public function write(XMLWriter $xmlWriter): void
    {
        $xmlWriter->startElement($this->tag);

        $this->id !== '' && $xmlWriter->writeAttribute('Id', $this->id);
        $this->type !== '' && $xmlWriter->writeAttribute('Type', $this->type);
        $this->target !== '' && $xmlWriter->writeAttribute('Target', $this->target);

        $xmlWriter->endElement();
    }
}
