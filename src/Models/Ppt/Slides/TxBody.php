<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class TxBody extends Model
{
    public string $tag = 'p:txBody';
    public ?BodyPr $bodyPr = null;
    public ?LstStyle $lstStyle = null;
    public ?P $p = null;

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        $instance = new static($tag);

        $node = $instance->getElement($xmlReader, $element);
        if (!$node) {
            return null;
        }

        $instance->bodyPr = BodyPr::load($xmlReader, $node);
        $instance->lstStyle = LstStyle::load($xmlReader, $node);
        $instance->p = P::load($xmlReader, $node);

        return $instance;
    }
}
