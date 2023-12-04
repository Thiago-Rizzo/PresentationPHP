<?php

namespace ThiagoRizzo\PresentationPHP\Models\DocProps;

use DOMElement;
use PhpOffice\Common\XMLReader;
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

    public static function load(ZipArchive $zipArchive): ?App
    {
        $docPropsApp = $zipArchive->getFromName('docProps/app.xml');
        $xmlReader = new XMLReader();

        $dom = $xmlReader->getDomFromString($docPropsApp);

        if (!$dom || !Utils::getElement($dom, 'Properties')) {
            return null;
        }

        $app = new self();
        $properties = Utils::getElement($dom, 'Properties');

        if ($properties instanceof DOMElement) {
            $app->xlmns = $properties->getAttribute('xmlns');
            $app->xlmnsVt = $properties->getAttribute('xmlns:vt');

            $app->headingPairs = HeadingPairs::load($properties);
            $app->titlesOfParts = TitlesOfParts::load($properties);

            $app->application = Utils::getElement($properties, 'Application')->nodeValue ?? '';
            $app->appVersion = Utils::getElement($properties, 'AppVersion')->nodeValue ?? '';
            $app->hiddenSlides = Utils::getElement($properties, 'HiddenSlides')->nodeValue ?? '';
            $app->hyperlinksChanged = Utils::getElement($properties, 'HyperlinksChanged')->nodeValue ?? '';
            $app->linksUpToDate = Utils::getElement($properties, 'LinksUpToDate')->nodeValue ?? '';
            $app->mMClips = Utils::getElement($properties, 'MMClips')->nodeValue ?? '';
            $app->notes = Utils::getElement($properties, 'Notes')->nodeValue ?? '';
            $app->paragraphs = Utils::getElement($properties, 'Paragraphs')->nodeValue ?? '';
            $app->presentationFormat = Utils::getElement($properties, 'PresentationFormat')->nodeValue ?? '';
            $app->scaleCrop = Utils::getElement($properties, 'ScaleCrop')->nodeValue ?? '';
            $app->slides = Utils::getElement($properties, 'Slides')->nodeValue ?? '';
            $app->sharedDoc = Utils::getElement($properties, 'SharedDoc')->nodeValue ?? '';
            $app->totalTime = Utils::getElement($properties, 'TotalTime')->nodeValue ?? '';
            $app->words = Utils::getElement($properties, 'Words')->nodeValue ?? '';
        }

        return $app;
    }
}
