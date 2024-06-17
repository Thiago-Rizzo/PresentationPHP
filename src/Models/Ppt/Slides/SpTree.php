<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class SpTree extends Model
{
    /** @var Sp[]|null $sps */
    public ?array $sps = null;

    public ?GrpSpPr $grpSpPr = null;

    public ?NvGrpSpPr $nvGrpSpPr = null;

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        if ($element->nodeName == 'p:spTree') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('p:spTree', $element);
        }

        if (!$node) {
            return null;
        }

        $instance = new self();

        $sps = $xmlReader->getElements('p:sp', $node);
        for ($i = 0; $i < $sps->length; $i++) {
            $instance->sps[] = Sp::load($xmlReader, $sps->item($i));
        }

        $instance->grpSpPr = GrpSpPr::load($xmlReader, $node);
        $instance->nvGrpSpPr = NvGrpSpPr::load($xmlReader, $node);

        return $instance;
    }
}
