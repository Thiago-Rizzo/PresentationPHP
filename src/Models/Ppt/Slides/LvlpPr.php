<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use PhpOffice\Common\XMLWriter;
use ThiagoRizzo\PresentationPHP\Models\Model;

class LvlpPr extends Model
{
    public ?BuNone $buNone = null;
    public ?RPr $rPr = null;

    public static function load(XMLReader $xmlReader, DOMElement $element, string $tag = null): ?self
    {
        $instance = new static($tag ?? 'a:lvl1pPr');

        $node = $instance->getElement($xmlReader, $element);
        if (!$node) {
            return null;
        }

        $instance->buNone = BuNone::load($xmlReader, $node);
        $instance->rPr = RPr::load($xmlReader, $node);

        return $instance;
    }

    public function write(XMLWriter $xmlWriter): void
    {
        $xmlWriter->startElement($this->tag);

        $this->buNone && $this->buNone->write($xmlWriter);
        $this->rPr && $this->rPr->write($xmlWriter);

        $xmlWriter->endElement();
    }
}
