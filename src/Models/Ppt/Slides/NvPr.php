<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class NvPr extends Model
{
    public ?Ph $ph = null;

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        if ($element->nodeName == 'p:nvPr') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('p:nvPr', $element);
        }

        if (!$node) {
            return null;
        }

        $instance = new self();

        $instance->ph = Ph::load($xmlReader, $node);

        return $instance;
    }
}
