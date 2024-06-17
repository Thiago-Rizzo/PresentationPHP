<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class NvSpPr extends Model
{
    public ?CNvPr $cnvPr = null;
    public ?CNvSpPr $cnvSpPr = null;
    public ?NvPr $nvPr = null;

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        if ($element->nodeName == 'p:nvSpPr') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('p:nvSpPr', $element);
        }

        if (!$node) {
            return null;
        }

        $instance = new self();

        $instance->cnvPr = CNvPr::load($xmlReader, $node);
        $instance->cnvSpPr = CNvSpPr::load($xmlReader, $node);
        $instance->nvPr = NvPr::load($xmlReader, $node);

        return $instance;
    }
}
