<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use PhpOffice\Common\XMLWriter;
use ThiagoRizzo\PresentationPHP\Models\Model;

class R extends Model
{
    public string $tag = 'a:r';

    public ?RPr $rPr = null;
    public ?T $t = null;


    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        $instance = new static($tag);

        $node = $instance->getElement($xmlReader, $element);
        if (!$node) {
            return null;
        }

        $instance->rPr = RPr::load($xmlReader, $node);
        $instance->t = T::load($xmlReader, $node);

        return $instance;
    }

    public function write(XMLWriter $xmlWriter): void
    {
        $xmlWriter->startElement($this->tag);

        $this->rPr && $this->rPr->write($xmlWriter);
        $this->t && $this->t->write($xmlWriter);

        $xmlWriter->endElement();
    }
}
