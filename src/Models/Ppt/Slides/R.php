<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class R extends Model
{
    public ?RPr $rPr = null;
    public ?T $t = null;


    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        if ($element->nodeName == 'a:r') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('a:r', $element);
        }

        if (!$node) {
            return null;
        }

        $instance = new self();

        $instance->rPr = RPr::load($xmlReader, $node);
        $instance->t = T::load($xmlReader, $node);

        return $instance;
    }
}
