<?php

namespace ThiagoRizzo\PresentationPHP\Models\DocProps;


use DOMElement;
use PhpOffice\Common\XMLReader;
use PhpOffice\Common\XMLWriter;
use ThiagoRizzo\PresentationPHP\Models\Model;

class HeadingPairs extends Model
{
    public string $tag = 'HeadingPairs';

    public ?Vector $vector = null;

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        $instance = new static($tag);

        $node = $instance->getElement($xmlReader, $element);
        if (!$node) {
            return null;
        }

        $instance->vector = Vector::load($xmlReader, $node);

        return $instance;
    }

    public function write(XMLWriter $xmlWriter): void
    {
        $xmlWriter->startElement($this->tag);

        $this->vector && $this->vector->write($xmlWriter);

        $xmlWriter->endElement();
    }
}
