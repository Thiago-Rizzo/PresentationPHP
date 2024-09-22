<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use PhpOffice\Common\XMLWriter;
use ThiagoRizzo\PresentationPHP\Models\Model;

class P extends Model
{
    public string $tag = 'a:p';

    public ?R $r = null;
    public ?EndParaRPr $endParaRPr = null;

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        $instance = new static($tag);

        $node = $instance->getElement($xmlReader, $element);
        if (!$node) {
            return null;
        }

        $instance->r = R::load($xmlReader, $node);
        $instance->endParaRPr = EndParaRPr::load($xmlReader, $node);

        return $instance;
    }

    public function write(XMLWriter $xmlWriter): void
    {
        $xmlWriter->startElement($this->tag);

        $this->r && $this->r->write($xmlWriter);
        $this->endParaRPr && $this->endParaRPr->write($xmlWriter);

        $xmlWriter->endElement();
    }
}
