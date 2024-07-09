<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class GrpSpPr extends Model
{
    public string $tag = 'p:grpSpPr';

    public ?Xfrm $xfrm = null;

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        $instance = new static($tag);

        $node = $instance->getElement($xmlReader, $element);
        if (!$node) {
            return null;
        }

        $instance->xfrm = Xfrm::load($xmlReader, $node);

        return $instance;
    }
}
