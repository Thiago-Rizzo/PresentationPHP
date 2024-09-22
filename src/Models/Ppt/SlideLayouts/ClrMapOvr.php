<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\SlideLayouts;

use DOMElement;
use PhpOffice\Common\XMLReader;
use PhpOffice\Common\XMLWriter;
use ThiagoRizzo\PresentationPHP\Models\Model;
use ThiagoRizzo\PresentationPHP\Models\Ppt\Slides\SlideLayouts\MasterClrMapping;

class ClrMapOvr extends Model
{
    public string $tag = 'p:clrMapOvr';
    public ?MasterClrMapping $masterClrMapping = null;

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        $instance = new static($tag);

        $node = $instance->getElement($xmlReader, $element);
        if (!$node) {
            return null;
        }

        $instance->masterClrMapping = MasterClrMapping::load($xmlReader, $node);

        return $instance;
    }

    public function write(XMLWriter $xmlWriter): void
    {
        $xmlWriter->startElement($this->tag);

        $this->masterClrMapping->write($xmlWriter);

        $xmlWriter->endElement();
    }
}
