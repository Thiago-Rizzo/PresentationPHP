<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides\SlideLayouts;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class ClrMapOvr extends Model
{
    public ?MasterClrMapping $masterClrMapping = null;

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        if ($element->nodeName === 'p:clrMapOvr') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('p:clrMapOvr', $element);
        }

        if (!$node) {
            return null;
        }

        $instance = new self();

        $instance->masterClrMapping = MasterClrMapping::load($xmlReader, $node);

        return $instance;
    }
}
