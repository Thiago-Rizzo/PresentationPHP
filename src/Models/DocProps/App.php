<?php

namespace ThiagoRizzo\PresentationPHP\Models\DocProps;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Utils;
use ZipArchive;

class App
{
    public string $xlmns = '';
    public string $xlmnsVt = '';

    public string $application = '';
    public string $appVersion = '';
    public string $hiddenSlides = '';
    public string $hyperlinksChanged = '';
    public string $linksUpToDate = '';
    public string $mMClips = '';
    public string $notes = '';
    public string $paragraphs = '';
    public string $presentationFormat = '';
    public string $scaleCrop = '';
    public string $sharedDoc = '';
    public string $slides = '';
    public string $totalTime = '';
    public string $words = '';

    public ?HeadingPairs $headingPairs = null;
    public ?TitlesOfParts $titlesOfParts = null;

    public static function loadFile(ZipArchive $zipArchive, ?string $fileName = null): ?self
    {
        $xml = $zipArchive->getFromName($fileName ?? 'docProps/app.xml');
        $xmlReader = Utils::registerXMLReader($xml);

        return self::load($xmlReader, $xmlReader->getElement('/Properties'));
    }

    public static function load(XMLReader $xmlReader, DOMElement $element): ?self
    {
        if ($element->tagName == 'Properties') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('Properties', $element);
        }

        if (!$node) {
            return null;
        }

        $app = new self();

        $app->xlmns = $node->getAttribute('xmlns');
        $app->xlmnsVt = $node->getAttribute('xmlns:vt');

        $app->headingPairs = HeadingPairs::load($xmlReader, $node);
        $app->titlesOfParts = TitlesOfParts::load($xmlReader, $node);

        $app->application = $xmlReader->getElement('Application', $node)->nodeValue ?? '';
        $app->appVersion = $xmlReader->getElement('AppVersion', $node)->nodeValue ?? '';
        $app->hiddenSlides = $xmlReader->getElement('HiddenSlides', $node)->nodeValue ?? '';
        $app->hyperlinksChanged = $xmlReader->getElement('HyperlinksChanged', $node)->nodeValue ?? '';
        $app->linksUpToDate = $xmlReader->getElement('LinksUpToDate', $node)->nodeValue ?? '';
        $app->mMClips = $xmlReader->getElement('MMClips', $node)->nodeValue ?? '';
        $app->notes = $xmlReader->getElement('Notes', $node)->nodeValue ?? '';
        $app->paragraphs = $xmlReader->getElement('Paragraphs', $node)->nodeValue ?? '';
        $app->presentationFormat = $xmlReader->getElement('PresentationFormat', $node)->nodeValue ?? '';
        $app->scaleCrop = $xmlReader->getElement('ScaleCrop', $node)->nodeValue ?? '';
        $app->slides = $xmlReader->getElement('Slides', $node)->nodeValue ?? '';
        $app->sharedDoc = $xmlReader->getElement('SharedDoc', $node)->nodeValue ?? '';
        $app->totalTime = $xmlReader->getElement('TotalTime', $node)->nodeValue ?? '';
        $app->words = $xmlReader->getElement('Words', $node)->nodeValue ?? '';

        return $app;
    }
}
