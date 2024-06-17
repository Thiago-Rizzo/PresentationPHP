<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class BodyPr extends Model
{
    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        if ($element->nodeName === 'a:bodyPr') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('a:bodyPr', $element);
        }

        if (!$node) {
            return null;
        }

        return new self();
    }
}
