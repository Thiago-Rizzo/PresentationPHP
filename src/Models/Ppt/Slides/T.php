<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use PhpOffice\Common\XMLWriter;
use ThiagoRizzo\PresentationPHP\Models\Model;

class T extends Model
{
    public string $tag = 'a:t';

    public string $value = '';

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        $instance = new static($tag);

        $node = $instance->getElement($xmlReader, $element);
        if (!$node) {
            return null;
        }

        $instance->value = $node->nodeValue;

        return $instance;
    }

    public function write(XMLWriter $xmlWriter): void
    {
        $xmlWriter->startElement($this->tag);

        $xmlWriter->text($this->value);

        $xmlWriter->endElement();
    }
}
