<?php

namespace ThiagoRizzo\PresentationPHP\Models\DocProps;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;
use ThiagoRizzo\PresentationPHP\Utils;
use ZipArchive;

class App extends Model
{
    public string $tag = 'Properties';

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

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        $instance = new static($tag);

        $node = $instance->getElement($xmlReader, $element);
        if (!$node) {
            return null;
        }

        $instance->xlmns = $node->getAttribute('xmlns');
        $instance->xlmnsVt = $node->getAttribute('xmlns:vt');

        $instance->headingPairs = HeadingPairs::load($xmlReader, $node);
        $instance->titlesOfParts = TitlesOfParts::load($xmlReader, $node);

        $instance->application = $xmlReader->getElement('Application', $node)->nodeValue ?? '';
        $instance->appVersion = $xmlReader->getElement('AppVersion', $node)->nodeValue ?? '';
        $instance->hiddenSlides = $xmlReader->getElement('HiddenSlides', $node)->nodeValue ?? '';
        $instance->hyperlinksChanged = $xmlReader->getElement('HyperlinksChanged', $node)->nodeValue ?? '';
        $instance->linksUpToDate = $xmlReader->getElement('LinksUpToDate', $node)->nodeValue ?? '';
        $instance->mMClips = $xmlReader->getElement('MMClips', $node)->nodeValue ?? '';
        $instance->notes = $xmlReader->getElement('Notes', $node)->nodeValue ?? '';
        $instance->paragraphs = $xmlReader->getElement('Paragraphs', $node)->nodeValue ?? '';
        $instance->presentationFormat = $xmlReader->getElement('PresentationFormat', $node)->nodeValue ?? '';
        $instance->scaleCrop = $xmlReader->getElement('ScaleCrop', $node)->nodeValue ?? '';
        $instance->slides = $xmlReader->getElement('Slides', $node)->nodeValue ?? '';
        $instance->sharedDoc = $xmlReader->getElement('SharedDoc', $node)->nodeValue ?? '';
        $instance->totalTime = $xmlReader->getElement('TotalTime', $node)->nodeValue ?? '';
        $instance->words = $xmlReader->getElement('Words', $node)->nodeValue ?? '';

        return $instance;
    }
}
