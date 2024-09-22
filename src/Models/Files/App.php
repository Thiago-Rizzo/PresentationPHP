<?php

namespace ThiagoRizzo\PresentationPHP\Models\Files;

use DOMElement;
use PhpOffice\Common\XMLReader;
use PhpOffice\Common\XMLWriter;
use ThiagoRizzo\PresentationPHP\Models\DocProps\HeadingPairs;
use ThiagoRizzo\PresentationPHP\Models\DocProps\TitlesOfParts;
use ThiagoRizzo\PresentationPHP\Models\Model;
use ThiagoRizzo\PresentationPHP\Utils;
use ZipArchive;

class App extends Model
{
    public static string $fileName = 'docProps/app.xml';
    public string $tag = 'Properties';

    public string $xmlns = '';
    public string $xmlnsVt = '';

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
        $xml = $zipArchive->getFromName($fileName ?? self::$fileName);
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

        $instance->xmlns = $node->getAttribute('xmlns');
        $instance->xmlnsVt = $node->getAttribute('xmlns:vt');

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

    public function writeFile(ZipArchive $zipArchive): void
    {
        $xmlWriter = new XMLWriter(XMLWriter::STORAGE_MEMORY);

        $xmlWriter->startDocument('1.0', 'UTF-8', 'yes');

        $this->write($xmlWriter);

        $zipArchive->addFromString(self::$fileName, $xmlWriter->getData());
    }

    public function write(XMLWriter $xmlWriter): void
    {
        $xmlWriter->startElement($this->tag);

        $this->xmlns !== '' && $xmlWriter->writeAttribute('xmlns', $this->xmlns);
        $this->xmlnsVt !== '' && $xmlWriter->writeAttribute('xmlns:vt', $this->xmlnsVt);

        $this->application !== '' && $xmlWriter->writeElement('Application', $this->application);
        $this->appVersion !== '' && $xmlWriter->writeElement('AppVersion', $this->appVersion);
        $this->hiddenSlides !== '' && $xmlWriter->writeElement('HiddenSlides', $this->hiddenSlides);
        $this->hyperlinksChanged !== '' && $xmlWriter->writeElement('HyperlinksChanged', $this->hyperlinksChanged);
        $this->linksUpToDate !== '' && $xmlWriter->writeElement('LinksUpToDate', $this->linksUpToDate);
        $this->mMClips !== '' && $xmlWriter->writeElement('MMClips', $this->mMClips);
        $this->notes !== '' && $xmlWriter->writeElement('Notes', $this->notes);
        $this->paragraphs !== '' && $xmlWriter->writeElement('Paragraphs', $this->paragraphs);
        $this->presentationFormat !== '' && $xmlWriter->writeElement('PresentationFormat', $this->presentationFormat);
        $this->scaleCrop !== '' && $xmlWriter->writeElement('ScaleCrop', $this->scaleCrop);
        $this->sharedDoc !== '' && $xmlWriter->writeElement('SharedDoc', $this->sharedDoc);
        $this->slides !== '' && $xmlWriter->writeElement('Slides', $this->slides);
        $this->totalTime !== '' && $xmlWriter->writeElement('TotalTime', $this->totalTime);
        $this->words !== '' && $xmlWriter->writeElement('Words', $this->words);

        $this->headingPairs && $this->headingPairs->write($xmlWriter);
        $this->titlesOfParts && $this->titlesOfParts->write($xmlWriter);

        $xmlWriter->endElement();
    }
}
