<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use PhpOffice\Common\XMLWriter;
use ThiagoRizzo\PresentationPHP\Models\Model;

class ChExt extends Model
{
    public string $tag = 'a:chExt';

    public string $cx = '';
    public string $cy = '';

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        $instance = new static($tag);

        $node = $instance->getElement($xmlReader, $element);
        if (!$node) {
            return null;
        }

        $instance->cx = $node->getAttribute('cx');
        $instance->cy = $node->getAttribute('cy');

        return $instance;
    }

    public function write(XMLWriter $xmlWriter): void
    {
        $xmlWriter->startElement($this->tag);

        $this->cx !== '' && $xmlWriter->writeAttribute('cx', $this->cx);
        $this->cy !== '' && $xmlWriter->writeAttribute('cy', $this->cy);

        $xmlWriter->endElement();
    }
}
