<?php

namespace ThiagoRizzo\PresentationPHP\Models\DocProps;

use DOMElement;
use ThiagoRizzo\PresentationPHP\Utils;
use ZipArchive;

class App
{
    public ?string $xlmns = null;
    public ?string $xlmnsVt = null;

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

    public static function load(ZipArchive $zipArchive): ?self
    {
        $docPropsApp = $zipArchive->getFromName('docProps/app.xml');
        $xmlReader = Utils::registerXMLReader($docPropsApp);

        if (!$xmlReader->getElement('/Properties')) {
            return null;
        }

        $app = new self();
        $properties = $xmlReader->getElement('/Properties');

        if ($properties instanceof DOMElement) {
            $app->xlmns = $properties->getAttribute('xmlns');
            $app->xlmnsVt = $properties->getAttribute('xmlns:vt');

            $app->headingPairs = HeadingPairs::load($xmlReader, $properties);
            $app->titlesOfParts = TitlesOfParts::load($xmlReader, $properties);

            $app->application = $xmlReader->getElement('Application')->nodeValue ?? '';
            $app->appVersion = $xmlReader->getElement('AppVersion')->nodeValue ?? '';
            $app->hiddenSlides = $xmlReader->getElement('HiddenSlides')->nodeValue ?? '';
            $app->hyperlinksChanged = $xmlReader->getElement('HyperlinksChanged')->nodeValue ?? '';
            $app->linksUpToDate = $xmlReader->getElement('LinksUpToDate')->nodeValue ?? '';
            $app->mMClips = $xmlReader->getElement('MMClips')->nodeValue ?? '';
            $app->notes = $xmlReader->getElement('Notes')->nodeValue ?? '';
            $app->paragraphs = $xmlReader->getElement('Paragraphs')->nodeValue ?? '';
            $app->presentationFormat = $xmlReader->getElement('PresentationFormat')->nodeValue ?? '';
            $app->scaleCrop = $xmlReader->getElement('ScaleCrop')->nodeValue ?? '';
            $app->slides = $xmlReader->getElement('Slides')->nodeValue ?? '';
            $app->sharedDoc = $xmlReader->getElement('SharedDoc')->nodeValue ?? '';
            $app->totalTime = $xmlReader->getElement('TotalTime')->nodeValue ?? '';
            $app->words = $xmlReader->getElement('Words')->nodeValue ?? '';
        }

        return $app;
    }
}
