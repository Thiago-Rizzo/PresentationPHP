<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class SpLocks extends Model
{
    public string $noGrp = '';

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        if ($element->nodeName == 'a:spLocks') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('a:spLocks', $element);
        }

        if (!$node) {
            return null;
        }

        $instance = new self();

        $instance->noGrp = $node->getAttribute('noGrp');

        return $instance;
    }
}
