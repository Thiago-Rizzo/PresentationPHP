<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class LvlpPr extends Model
{
    public ?BuNone $buNone = null;
    public ?RPr $rPr = null;

    public static function load(XMLReader $xmlReader, DOMElement $element, string $tag = null): ?self
    {
        $instance = new self($tag ?? 'a:lvl1pPr');

        $node = $instance->getElement($xmlReader, $element);
        if (!$node) {
            return null;
        }

        $instance->buNone = BuNone::load($xmlReader, $node);
        $instance->rPr = RPr::load($xmlReader, $node);

        return $instance;
    }
}
