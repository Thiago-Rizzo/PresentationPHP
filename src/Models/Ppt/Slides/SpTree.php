<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use PhpOffice\Common\XMLWriter;
use ThiagoRizzo\PresentationPHP\Models\Model;

class SpTree extends Model
{
    public string $tag = 'p:spTree';

    /** @var Sp[] $sps */
    public array $sps = [];

    public ?GrpSpPr $grpSpPr = null;

    public ?NvGrpSpPr $nvGrpSpPr = null;

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        $instance = new static($tag);

        $node = $instance->getElement($xmlReader, $element);
        if (!$node) {
            return null;
        }

        $sps = $xmlReader->getElements('p:sp', $node);
        for ($i = 0; $i < $sps->length; $i++) {
            $instance->sps[] = Sp::load($xmlReader, $sps->item($i));
        }

        $instance->grpSpPr = GrpSpPr::load($xmlReader, $node);
        $instance->nvGrpSpPr = NvGrpSpPr::load($xmlReader, $node);

        return $instance;
    }

    public function write(XMLWriter $xmlWriter): void
    {
        $xmlWriter->startElement($this->tag);

        $this->grpSpPr && $this->grpSpPr->write($xmlWriter);
        $this->nvGrpSpPr && $this->nvGrpSpPr->write($xmlWriter);

        foreach ($this->sps as $sp) {
            $sp && $sp->write($xmlWriter);
        }

        $xmlWriter->endElement();
    }
}
