<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use PhpOffice\Common\XMLWriter;
use ThiagoRizzo\PresentationPHP\Models\Model;

class Off extends Model
{
    public string $tag = 'a:off';

    public string $x = '';
    public string $y = '';

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        $instance = new static($tag);

        $node = $instance->getElement($xmlReader, $element);
        if (!$node) {
            return null;
        }

        $instance->x = $node->getAttribute('x');
        $instance->y = $node->getAttribute('y');

        return $instance;
    }

    public function write(XMLWriter $xmlWriter): void
    {
        $xmlWriter->startElement($this->tag);

        $this->x !== '' && $xmlWriter->writeAttribute('x', $this->x);
        $this->y !== '' && $xmlWriter->writeAttribute('y', $this->y);

        $xmlWriter->endElement();
    }
}
