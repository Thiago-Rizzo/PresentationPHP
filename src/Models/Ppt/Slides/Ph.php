<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class Ph extends Model
{
    public string $type = '';
    public string $sz = '';
    public string $idx = '';

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        if ($element->nodeName == 'p:ph') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('p:ph', $element);
        }

        if (!$node) {
            return null;
        }

        $instance = new self();

        $instance->type = $node->getAttribute('type');
        $instance->sz = $node->getAttribute('sz');
        $instance->idx = $node->getAttribute('idx');

        return $instance;
    }
}
