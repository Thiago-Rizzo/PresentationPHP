<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class Sp extends Model
{
    public ?NvSpPr $nvSpPr = null;
    public ?SpPr $spPr = null;
    public ?TxBody $txBody = null;

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        if ($element->nodeName == 'p:sp') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('p:sp', $element);
        }

        if (!$node) {
            return null;
        }

        $instance = new self();

        $instance->nvSpPr = NvSpPr::load($xmlReader, $node);
        $instance->spPr = SpPr::load($xmlReader, $node);
        $instance->txBody = TxBody::load($xmlReader, $node);

        return $instance;
    }
}
