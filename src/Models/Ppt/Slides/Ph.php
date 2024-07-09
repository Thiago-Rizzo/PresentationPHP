<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class Ph extends Model
{
    public string $tag = 'p:ph';

    public string $type = '';
    public string $sz = '';
    public string $idx = '';

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        $instance = new static($tag);

        $node = $instance->getElement($xmlReader, $element);
        if (!$node) {
            return null;
        }

        $instance->type = $node->getAttribute('type');
        $instance->sz = $node->getAttribute('sz');
        $instance->idx = $node->getAttribute('idx');

        return $instance;
    }
}
