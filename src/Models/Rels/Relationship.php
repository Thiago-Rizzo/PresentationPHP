<?php

namespace ThiagoRizzo\PresentationPHP\Models\Rels;

use DOMElement;
use PhpOffice\Common\XMLReader;

class Relationship
{
    public string $id = '';
    public string $type = '';
    public string $target = '';

    public static function load(XMLReader $xmlReader, DOMElement $element): ?self
    {
        if ($element->nodeName == 'Relationship') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('Relationship', $element);
        }

        if (!$node) {
            return null;
        }

        $relationship = new self();

        $relationship->id = $node->getAttribute('Id');
        $relationship->type = $node->getAttribute('Type');
        $relationship->target = $node->getAttribute('Target');

        return $relationship;
    }
}
