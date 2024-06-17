<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides\SlideLayouts;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;
use ThiagoRizzo\PresentationPHP\Models\Ppt\Slides\SpTree;

class CSld extends Model
{
    public string $name = '';

    public ?SpTree $spTree = null;

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        if ($element->nodeName === 'p:cSld') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('p:cSld', $element);
        }

        if (!$node) {
            return null;
        }

        $instance = new self();

        $instance->name = $node->getAttribute('name');

        $instance->spTree = SpTree::load($xmlReader, $node);

        return $instance;
    }
}
