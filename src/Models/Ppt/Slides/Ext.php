<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class Ext extends Model
{
    public string $cx = '';
    public string $cy = '';

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        if ($element->nodeName == 'a:ext') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('a:ext', $element);
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
