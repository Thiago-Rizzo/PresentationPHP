<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use PhpOffice\Common\XMLWriter;
use ThiagoRizzo\PresentationPHP\Models\Model;

class LstStyle extends Model
{
    public ?LvlpPr $lvl1pPr = null;
    public ?LvlpPr $lvl2pPr = null;
    public ?LvlpPr $lvl3pPr = null;
    public ?LvlpPr $lvl4pPr = null;
    public ?LvlpPr $lvl5pPr = null;
    public ?LvlpPr $lvl6pPr = null;
    public ?LvlpPr $lvl7pPr = null;
    public ?LvlpPr $lvl8pPr = null;
    public ?LvlpPr $lvl9pPr = null;

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        $instance = new static($tag ?? 'a:lstStyle');

        $node = $instance->getElement($xmlReader, $element);
        if (!$node) {
            return null;
        }

        $instance->lvl1pPr = LvlpPr::load($xmlReader, $node, 'a:lvl1pPr');
        $instance->lvl2pPr = LvlpPr::load($xmlReader, $node, 'a:lvl2pPr');
        $instance->lvl3pPr = LvlpPr::load($xmlReader, $node, 'a:lvl3pPr');
        $instance->lvl4pPr = LvlpPr::load($xmlReader, $node, 'a:lvl4pPr');
        $instance->lvl5pPr = LvlpPr::load($xmlReader, $node, 'a:lvl5pPr');
        $instance->lvl6pPr = LvlpPr::load($xmlReader, $node, 'a:lvl6pPr');
        $instance->lvl7pPr = LvlpPr::load($xmlReader, $node, 'a:lvl7pPr');
        $instance->lvl8pPr = LvlpPr::load($xmlReader, $node, 'a:lvl8pPr');
        $instance->lvl9pPr = LvlpPr::load($xmlReader, $node, 'a:lvl9pPr');

        return $instance;
    }

    public function write(XMLWriter $xmlWriter): void
    {
        $xmlWriter->startElement($this->tag);

        $this->lvl1pPr && $this->lvl1pPr->write($xmlWriter);
        $this->lvl2pPr && $this->lvl2pPr->write($xmlWriter);
        $this->lvl3pPr && $this->lvl3pPr->write($xmlWriter);
        $this->lvl4pPr && $this->lvl4pPr->write($xmlWriter);
        $this->lvl5pPr && $this->lvl5pPr->write($xmlWriter);
        $this->lvl6pPr && $this->lvl6pPr->write($xmlWriter);
        $this->lvl7pPr && $this->lvl7pPr->write($xmlWriter);
        $this->lvl8pPr && $this->lvl8pPr->write($xmlWriter);
        $this->lvl9pPr && $this->lvl9pPr->write($xmlWriter);

        $xmlWriter->endElement();
    }
}
