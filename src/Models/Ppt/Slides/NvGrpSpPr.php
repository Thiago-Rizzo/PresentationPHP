<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use PhpOffice\Common\XMLWriter;
use ThiagoRizzo\PresentationPHP\Models\Model;

class NvGrpSpPr extends Model
{
    public string $tag = 'p:nvGrpSpPr';

    public ?CNvPr $cNvPr = null;
    public ?CNvGrpSpPr $cNvGrpSpPr = null;
    public ?NvPr $nvPr = null;

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        $instance = new static($tag);

        $node = $instance->getElement($xmlReader, $element);
        if (!$node) {
            return null;
        }

        $instance->cNvPr = CNvPr::load($xmlReader, $node);
        $instance->cNvGrpSpPr = CNvGrpSpPr::load($xmlReader, $node);
        $instance->nvPr = NvPr::load($xmlReader, $node);

        return $instance;
    }

    public function write(XMLWriter $xmlWriter): void
    {
        $xmlWriter->startElement($this->tag);

        $this->cNvPr && $this->cNvPr->write($xmlWriter);
        $this->cNvGrpSpPr && $this->cNvGrpSpPr->write($xmlWriter);
        $this->nvPr && $this->nvPr->write($xmlWriter);

        $xmlWriter->endElement();
    }
}
