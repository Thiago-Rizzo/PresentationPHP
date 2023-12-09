<?php

namespace ThiagoRizzo\PresentationPHP\Models\DocProps;

use DOMElement;
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

    public static function load(ZipArchive $zipArchive): ?self
    {
        $docPropsCore = $zipArchive->getFromName('docProps/core.xml');
        $xmlReader = Utils::registerXMLReader($docPropsCore);

        if (!$xmlReader->getElement('/cp:coreProperties')) {
            return null;
        }

        $core = new self();
        $properties = $xmlReader->getElement('/cp:coreProperties');

        if ($properties instanceof DOMElement) {
            $core->xlmnsXsi = $properties->getAttribute('xmlns:xsi');
            $core->xlmnsCp = $properties->getAttribute('xmlns:cp');
            $core->xlmnsDc = $properties->getAttribute('xmlns:dc');
            $core->xlmnsDcTerms = $properties->getAttribute('xmlns:dcterms');
            $core->xlmnsDcmiType = $properties->getAttribute('xmlns:dcmitype');

            $core->title = $xmlReader->getElement('dc:title')->nodeValue ?? '';
            $core->creator = $xmlReader->getElement('dc:creator')->nodeValue ?? '';
            $core->lastModifiedBy = $xmlReader->getElement('cp:lastModifiedBy')->nodeValue ?? '';
            $core->revision = $xmlReader->getElement('cp:revision')->nodeValue ?? '';

            $core->created = Time::load($xmlReader, $properties, 'dcterms:created');
            $core->modified = Time::load($xmlReader, $properties, 'dcterms:modified');
        }

        return $core;
    }
}
