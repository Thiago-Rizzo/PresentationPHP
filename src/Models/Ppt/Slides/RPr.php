<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class RPr extends Model
{
    public string $lang = '';
    public string $smtClean = '';

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        $instance = new self($tag ?? 'a:rPr');

        $node = $instance->getElement($xmlReader, $element);
        if (!$node) {
            return null;
        }

        $instance->lang = $node->getAttribute('lang');
        $instance->smtClean = $node->getAttribute('smtClean');

        return $instance;
    }
}
