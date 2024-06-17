<?php

namespace ThiagoRizzo\PresentationPHP\Models\DocProps;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;
use ThiagoRizzo\PresentationPHP\Utils;
use ZipArchive;

class Core  extends Model
{
    public string $xlmnsXsi = '';
    public string $xlmnsCp = '';
    public string $xlmnsDc = '';
    public string $xlmnsDcTerms = '';
    public string $xlmnsDcmiType = '';

    public string $title = '';
    public string $creator = '';
    public string $lastModifiedBy = '';
    public string $revision = '';

    public ?Time $created = null;
    public ?Time $modified = null;

    public static function loadFile(ZipArchive $zipArchive, ?string $fileName = null): ?self
    {
        $xml = $zipArchive->getFromName($fileName ?? 'docProps/core.xml');
        $xmlReader = Utils::registerXMLReader($xml);

        return self::load($xmlReader, $xmlReader->getElement('/cp:coreProperties'));
    }

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        if ($element->tagName == 'cp:coreProperties') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('cp:coreProperties', $element);
        }

        if (!$node) {
            return null;
        }

        $instance = new self();

        $instance->xlmnsXsi = $node->getAttribute('xmlns:xsi');
        $instance->xlmnsCp = $node->getAttribute('xmlns:cp');
        $instance->xlmnsDc = $node->getAttribute('xmlns:dc');
        $instance->xlmnsDcTerms = $node->getAttribute('xmlns:dcterms');
        $instance->xlmnsDcmiType = $node->getAttribute('xmlns:dcmitype');

        $instance->title = $xmlReader->getElement('dc:title', $node)->nodeValue ?? '';
        $instance->creator = $xmlReader->getElement('dc:creator', $node)->nodeValue ?? '';
        $instance->lastModifiedBy = $xmlReader->getElement('cp:lastModifiedBy', $node)->nodeValue ?? '';
        $instance->revision = $xmlReader->getElement('cp:revision', $node)->nodeValue ?? '';

        $instance->created = Time::load($xmlReader, $node, 'dcterms:created');
        $instance->modified = Time::load($xmlReader, $node, 'dcterms:modified');

        return $instance;
    }
}
