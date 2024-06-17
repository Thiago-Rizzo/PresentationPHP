<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class ChExt extends Model
{
    public string $cx = '';
    public string $cy = '';

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        if ($element->nodeName == 'a:chExt') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('a:chExt', $element);
        }

        if (!$node) {
            return null;
        }

        $instance = new self();

        $instance->cx = $node->getAttribute('cx');
        $instance->cy = $node->getAttribute('cy');

        return $instance;
    }
}
