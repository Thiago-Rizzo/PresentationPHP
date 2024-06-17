<?php

namespace ThiagoRizzo\PresentationPHP\Models\Rels;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class Relationship extends Model
{
    public string $id = '';
    public string $type = '';
    public string $target = '';

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        if ($element->nodeName === 'Relationship') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('Relationship', $element);
        }

        if (!$node) {
            return null;
        }

        $instance = new self();

        $instance->id = $node->getAttribute('Id');
        $instance->type = $node->getAttribute('Type');
        $instance->target = $node->getAttribute('Target');

        return $instance;
    }
}
