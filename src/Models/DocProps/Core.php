<?php

namespace ThiagoRizzo\PresentationPHP\Models\DocProps;

use DOMElement;
use PhpOffice\Common\XMLReader;
use PhpOffice\Common\XMLWriter;
use ThiagoRizzo\PresentationPHP\Models\Model;
use ThiagoRizzo\PresentationPHP\Utils;
use ZipArchive;

class Core extends Model
{
    public string $tag = 'cp:coreProperties';
    public static string $filename = 'docProps/core.xml';

    public string $xmlnsXsi = '';
    public string $xmlnsCp = '';
    public string $xmlnsDc = '';
    public string $xmlnsDcTerms = '';
    public string $xmlnsDcmiType = '';

    public string $title = '';
    public string $creator = '';
    public string $lastModifiedBy = '';
    public string $revision = '';

    public ?Time $created = null;
    public ?Time $modified = null;

    public static function loadFile(ZipArchive $zipArchive, ?string $fileName = null): ?self
    {
        $xml = $zipArchive->getFromName($fileName ?? self::$filename);
        $xmlReader = Utils::registerXMLReader($xml);

        return self::load($xmlReader, $xmlReader->getElement('/cp:coreProperties'));
    }

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        $instance = new static($tag);

        $node = $instance->getElement($xmlReader, $element);
        if (!$node) {
            return null;
        }

        $instance->xmlnsXsi = $node->getAttribute('xmlns:xsi');
        $instance->xmlnsCp = $node->getAttribute('xmlns:cp');
        $instance->xmlnsDc = $node->getAttribute('xmlns:dc');
        $instance->xmlnsDcTerms = $node->getAttribute('xmlns:dcterms');
        $instance->xmlnsDcmiType = $node->getAttribute('xmlns:dcmitype');

        $instance->title = $xmlReader->getElement('dc:title', $node)->nodeValue ?? '';
        $instance->creator = $xmlReader->getElement('dc:creator', $node)->nodeValue ?? '';
        $instance->lastModifiedBy = $xmlReader->getElement('cp:lastModifiedBy', $node)->nodeValue ?? '';
        $instance->revision = $xmlReader->getElement('cp:revision', $node)->nodeValue ?? '';

        $instance->created = Time::load($xmlReader, $node, 'dcterms:created');
        $instance->modified = Time::load($xmlReader, $node, 'dcterms:modified');

        return $instance;
    }


    public function writeFile(ZipArchive $zipArchive): void
    {
        $xmlWriter = new XMLWriter(XMLWriter::STORAGE_MEMORY);

        $xmlWriter->startDocument('1.0', 'UTF-8', 'yes');

        $this->write($xmlWriter);

        $zipArchive->addFromString(self::$filename, $xmlWriter->getData());
    }

    public function write(XMLWriter $xmlWriter): void
    {
        $xmlWriter->startElement($this->tag);

        $this->xmlnsXsi !== '' && $xmlWriter->writeAttribute('xmlns:xsi', $this->xmlnsXsi);
        $this->xmlnsCp !== '' && $xmlWriter->writeAttribute('xmlns:cp', $this->xmlnsCp);
        $this->xmlnsDc !== '' && $xmlWriter->writeAttribute('xmlns:dc', $this->xmlnsDc);
        $this->xmlnsDcTerms !== '' && $xmlWriter->writeAttribute('xmlns:dcterms', $this->xmlnsDcTerms);
        $this->xmlnsDcmiType !== '' && $xmlWriter->writeAttribute('xmlns:dcmitype', $this->xmlnsDcmiType);

        $this->title !== '' && $xmlWriter->writeElement('dc:title', $this->title);
        $this->creator !== '' && $xmlWriter->writeElement('dc:creator', $this->creator);
        $this->lastModifiedBy !== '' && $xmlWriter->writeElement('cp:lastModifiedBy', $this->lastModifiedBy);
        $this->revision !== '' && $xmlWriter->writeElement('cp:revision', $this->revision);

        $this->created && $this->created->write($xmlWriter);
        $this->modified && $this->modified->write($xmlWriter);

        $xmlWriter->endElement();
    }
}
