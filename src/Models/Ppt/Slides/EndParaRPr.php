<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class EndParaRPr extends Model
{
    public string $lang = '';

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        if ($element->nodeName == 'a:endParaRPr') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('a:endParaRPr', $element);
        }

        if (!$node) {
            return null;
        }

        $instance = new self();

        $instance->lang = $node->getAttribute('lang');

        return $instance;
    }
}
