<?php

namespace ThiagoRizzo\PresentationPHP\Models\DocProps;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Utils;
use ZipArchive;

class Core
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

    public static function load(XMLReader $xmlReader, DOMElement $element): ?self
    {
        if ($element->tagName == 'cp:coreProperties') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('cp:coreProperties', $element);
        }

        if (!$node) {
            return null;
        }

        $core = new self();

        $core->xlmnsXsi = $node->getAttribute('xmlns:xsi');
        $core->xlmnsCp = $node->getAttribute('xmlns:cp');
        $core->xlmnsDc = $node->getAttribute('xmlns:dc');
        $core->xlmnsDcTerms = $node->getAttribute('xmlns:dcterms');
        $core->xlmnsDcmiType = $node->getAttribute('xmlns:dcmitype');

        $core->title = $xmlReader->getElement('dc:title', $node)->nodeValue ?? '';
        $core->creator = $xmlReader->getElement('dc:creator', $node)->nodeValue ?? '';
        $core->lastModifiedBy = $xmlReader->getElement('cp:lastModifiedBy', $node)->nodeValue ?? '';
        $core->revision = $xmlReader->getElement('cp:revision', $node)->nodeValue ?? '';

        $core->created = Time::load($xmlReader, $node, 'dcterms:created');
        $core->modified = Time::load($xmlReader, $node, 'dcterms:modified');

        return $core;
    }
}
