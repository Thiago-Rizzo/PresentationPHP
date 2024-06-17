<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides\SlideLayouts;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class MasterClrMapping extends Model
{
    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        if ($element->nodeName === 'a:masterClrMapping') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('a:masterClrMapping', $element);
        }

        if (!$node) {
            return null;
        }

        return new self();
    }
}
