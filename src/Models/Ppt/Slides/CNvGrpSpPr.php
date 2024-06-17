<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class CNvGrpSpPr extends Model
{

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        if ($element->nodeName == 'p:cNvGrpSpPr') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('p:cNvGrpSpPr', $element);
        }

        if (!$node) {
            return null;
        }

        return new self();
    }
}
