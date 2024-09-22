<?php

namespace ThiagoRizzo\PresentationPHP\Models\Rels;

use DOMElement;
use PhpOffice\Common\XMLReader;
use PhpOffice\Common\XMLWriter;
use ThiagoRizzo\PresentationPHP\Models\Model;
use ThiagoRizzo\PresentationPHP\Utils;
use ZipArchive;

class Relationships extends Model
{
    public string $tag = 'Relationships';

    /** @var Relationship[] $relationships */
    public array $relationships = [];

    public string $xmlns = 'http://schemas.openxmlformats.org/package/2006/relationships';

    public static function loadFile(ZipArchive $zipArchive, ?string $fileName = null): ?self
    {
        $xml = $zipArchive->getFromName($fileName ?? '_rels/.rels');
        $xmlReader = Utils::registerXMLReader($xml);

        return self::load($xmlReader, $xmlReader->getElement('/Relationships'));
    }

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        $instance = new static($tag);

        $node = $instance->getElement($xmlReader, $element);
        if (!$node) {
            return null;
        }

        $relationships = $xmlReader->getElements('Relationship', $node);
        for ($i = 0; $i < $relationships->length; $i++) {
            $instance->relationships[$i] = Relationship::load($xmlReader, $relationships->item($i));
        }

        return $instance;
    }

    public function write(XMLWriter $xmlWriter): void
    {
        $xmlWriter->startElement($this->tag);

        foreach ($this->relationships as $relationship) {
            $relationship->write($xmlWriter);
        }

        $xmlWriter->endElement();
    }
}
