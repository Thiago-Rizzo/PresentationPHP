<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class CNvSpPr extends Model
{
    public ?SpLocks $spLocks = null;

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        if ($element->nodeName == 'p:cNvSpPr') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('p:cNvSpPr', $element);
        }

        if (!$node) {
            return null;
        }

        $instance = new self();

        $instance->spLocks = SpLocks::load($xmlReader, $node);

        return $instance;
    }
}
