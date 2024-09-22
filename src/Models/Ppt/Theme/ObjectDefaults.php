<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Theme;

use PhpOffice\Common\XMLReader;
use PhpOffice\Common\XMLWriter;
use DOMElement;
use ThiagoRizzo\PresentationPHP\Models\Model;

class ObjectDefaults extends Model
{
    public string $tag = "a:objectDefaults";

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?Model
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
