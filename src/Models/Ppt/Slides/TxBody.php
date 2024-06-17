<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class TxBody extends Model
{
    public ?BodyPr $bodyPr = null;
    public ?LstStyle $lstStyle = null;
    public ?P $p = null;

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        if ($element->nodeName == 'p:txBody') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('p:txBody', $element);
        }

        if (!$node) {
            return null;
        }

        $instance = new self();

        $instance->bodyPr = BodyPr::load($xmlReader, $node);
        $instance->lstStyle = LstStyle::load($xmlReader, $node);
        $instance->p = P::load($xmlReader, $node);

        return $instance;
    }
}
