<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use PhpOffice\Common\XMLWriter;
use ThiagoRizzo\PresentationPHP\Models\Model;

class NvSpPr extends Model
{
    public string $tag = 'p:nvSpPr';

    public ?CNvPr $cnvPr = null;
    public ?CNvSpPr $cnvSpPr = null;
    public ?NvPr $nvPr = null;

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        $instance = new static($tag);

        $node = $instance->getElement($xmlReader, $element);
        if (!$node) {
            return null;
        }

        $instance->cnvPr = CNvPr::load($xmlReader, $node);
        $instance->cnvSpPr = CNvSpPr::load($xmlReader, $node);
        $instance->nvPr = NvPr::load($xmlReader, $node);

        return $instance;
    }

    public function write(XMLWriter $xmlWriter): void
    {
        $xmlWriter->startElement($this->tag);

        $this->cnvPr && $this->cnvPr->write($xmlWriter);
        $this->cnvSpPr && $this->cnvSpPr->write($xmlWriter);
        $this->nvPr && $this->nvPr->write($xmlWriter);

        $xmlWriter->endElement();
    }
}
