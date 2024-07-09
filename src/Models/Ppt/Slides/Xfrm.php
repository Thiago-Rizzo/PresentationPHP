<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class Xfrm extends Model
{
    public string $tag = 'a:xfrm';

    public ?Off $off = null;
    public ?Ext $ext = null;
    public ?ChOff $chOff = null;
    public ?ChExt $chExt = null;

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        $instance = new static($tag);

        $node = $instance->getElement($xmlReader, $element);
        if (!$node) {
            return null;
        }

        $instance->off = Off::load($xmlReader, $node);
        $instance->ext = Ext::load($xmlReader, $node);
        $instance->chOff = ChOff::load($xmlReader, $node);
        $instance->chExt = ChExt::load($xmlReader, $node);

        return $instance;
    }
}
