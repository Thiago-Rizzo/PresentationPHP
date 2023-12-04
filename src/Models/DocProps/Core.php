<?php

namespace ThiagoRizzo\PresentationPHP\Models\DocProps;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Utils;
use ZipArchive;

class Core
{
    public ?string $xlmnsXsi = null;
    public ?string $xlmnsCp = null;
    public ?string $xlmnsDc = null;
    public ?string $xlmnsDcTerms = null;
    public ?string $xlmnsDcmiType = null;

    public string $title = '';
    public string $creator = '';
    public string $lastModifiedBy = '';
    public string $revision = '';
    public ?Time $created = null;
    public ?Time $modified = null;

    public static function load(ZipArchive $zipArchive): ?self
    {
        $docPropsCore = $zipArchive->getFromName('docProps/core.xml');
        $xmlReader = new XMLReader();
        $dom = $xmlReader->getDomFromString($docPropsCore);

        if (!$dom || !Utils::getElement($dom, 'cp:coreProperties')) {
            return null;
        }

        $core = new self();
        $properties = Utils::getElement($dom, 'cp:coreProperties');

        if ($properties instanceof DOMElement) {
            $core->xlmnsXsi = $properties->getAttribute('xmlns:xsi');
            $core->xlmnsCp = $properties->getAttribute('xmlns:cp');
            $core->xlmnsDc = $properties->getAttribute('xmlns:dc');
            $core->xlmnsDcTerms = $properties->getAttribute('xmlns:dcTerms');
            $core->xlmnsDcmiType = $properties->getAttribute('xmlns:dcmitype');

            $core->title = Utils::getElement($properties, 'dc:title')->nodeValue ?? '';
            $core->creator = Utils::getElement($properties, 'dc:creator')->nodeValue ?? '';
            $core->lastModifiedBy = Utils::getElement($properties, 'cp:lastModifiedBy')->nodeValue ?? '';
            $core->revision = Utils::getElement($properties, 'cp:revision')->nodeValue ?? '';

            $core->created = Time::load($properties, 'dcterms:created');
            $core->modified = Time::load($properties, 'dcterms:modified');
        }

        return $core;
    }
}
