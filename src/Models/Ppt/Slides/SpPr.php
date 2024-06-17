<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class SpPr extends Model
{
    public ?Xfrm $xfrm = null;

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        if ($element->nodeName == 'p:spPr') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('p:spPr', $element);
        }

        if (!$node) {
            return null;
        }

        $instance = new self();

        $instance->xfrm = Xfrm::load($xmlReader, $node);

        return $instance;
    }
}
