<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class NvGrpSpPr extends Model
{
    public ?CNvPr $cNvPr = null;
    public ?CNvGrpSpPr $cNvGrpSpPr = null;
    public ?NvPr $nvPr = null;

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        if ($element->nodeName == 'p:nvGrpSpPr') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('p:nvGrpSpPr', $element);
        }

        if (!$node) {
            return null;
        }

        $instance = new self();

        $instance->cNvPr = CNvPr::load($xmlReader, $node);
        $instance->cNvGrpSpPr = CNvGrpSpPr::load($xmlReader, $node);
        $instance->nvPr = NvPr::load($xmlReader, $node);

        return $instance;
    }
}
