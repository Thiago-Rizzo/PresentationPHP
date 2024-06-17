<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class P extends Model
{
    public ?R $r = null;
    public ?EndParaRPr $endParaRPr = null;

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        if ($element->nodeName == 'a:p') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('a:p', $element);
        }

        if (!$node) {
            return null;
        }

        $instance = new self();

        $instance->r = R::load($xmlReader, $node);
        $instance->endParaRPr = EndParaRPr::load($xmlReader, $node);

        return $instance;
    }
}
