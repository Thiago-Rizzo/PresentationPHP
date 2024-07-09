<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class Sp extends Model
{
    public string $tag = 'p:sp';
    public ?NvSpPr $nvSpPr = null;
    public ?SpPr $spPr = null;
    public ?TxBody $txBody = null;

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        $instance = new static($tag);

        $node = $instance->getElement($xmlReader, $element);
        if (!$node) {
            return null;
        }

        $instance->nvSpPr = NvSpPr::load($xmlReader, $node);
        $instance->spPr = SpPr::load($xmlReader, $node);
        $instance->txBody = TxBody::load($xmlReader, $node);

        return $instance;
    }
}
