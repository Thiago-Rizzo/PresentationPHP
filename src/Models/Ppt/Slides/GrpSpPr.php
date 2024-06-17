<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class GrpSpPr extends Model
{
    public ?Xfrm $xfrm = null;

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        if ($element->nodeName == 'p:grpSpPr') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('p:grpSpPr', $element);
        }

        if (!$node) {
            return null;
        }

        $instance = new self();

        $instance->xfrm = Xfrm::load($xmlReader, $node);

        return $instance;
    }
}
