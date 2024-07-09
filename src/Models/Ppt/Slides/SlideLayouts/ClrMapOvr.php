<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides\SlideLayouts;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class ClrMapOvr extends Model
{
    public string $tag = 'p:clrMapOvr';
    public ?MasterClrMapping $masterClrMapping = null;

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        $instance = new static($tag);

        $node = $instance->getElement($xmlReader, $element);
        if (!$node) {
            return null;
        }

        $instance->masterClrMapping = MasterClrMapping::load($xmlReader, $node);

        return $instance;
    }
}
