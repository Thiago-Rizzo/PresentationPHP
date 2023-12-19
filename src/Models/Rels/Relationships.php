<?php

namespace ThiagoRizzo\PresentationPHP\Models\Rels;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Utils;
use ZipArchive;

class Relationships
{
    /** @var Relationship[] $relationships */
    public array $relationships = [];

    public string $xlmns = 'http://schemas.openxmlformats.org/package/2006/relationships';

    public static function loadFile(ZipArchive $zipArchive, ?string $fileName = null): ?self
    {
        $xml = $zipArchive->getFromName($fileName ?? '_rels/.rels');
        $xmlReader = Utils::registerXMLReader($xml);

        return self::load($xmlReader, $xmlReader->getElement('/Relationships'));
    }

    public static function load(XMLReader $xmlReader, DOMElement $element): ?self
    {
        if ($element->nodeName == 'Relationships') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('Relationships', $element);
        }

        if (!$node) {
            return null;
        }

        $rels = new self();

        $relationships = $xmlReader->getElements('Relationship', $node);
        for ($i = 0; $i < $relationships->length; $i++) {
            $rels->relationships[$i] = Relationship::load($xmlReader, $relationships->item($i));
        }

        return $rels;
    }
}
