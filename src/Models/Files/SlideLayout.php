<?php

namespace ThiagoRizzo\PresentationPHP\Models\Files;

use DOMElement;
use PhpOffice\Common\XMLReader;
use PhpOffice\Common\XMLWriter;
use ThiagoRizzo\PresentationPHP\Models\Model;
use ThiagoRizzo\PresentationPHP\Models\Ppt\SlideLayouts\ClrMapOvr;
use ThiagoRizzo\PresentationPHP\Models\Ppt\SlideLayouts\CSld;
use ThiagoRizzo\PresentationPHP\Utils;
use ZipArchive;

class SlideLayout extends Model
{
    public static string $fileName = 'ppt/slideLayouts/slideLayout1.xml';
    public string $tag = 'p:sldLayout';

    public string $currentFilename = '';

    public string $type = 'title';
    public string $preserve = '1';

    public ?CSld $csld = null;
    public ?ClrMapOvr $clrMapOvr = null;

    public static function loadFile(ZipArchive $zipArchive, ?string $fileName = null): ?self
    {
        $xml = $zipArchive->getFromName($fileName ?? 'ppt/slideLayouts/slideLayout1.xml');
        $xmlReader = Utils::registerXMLReader($xml);

        self::$fileName = $fileName ?? 'ppt/slideLayouts/slideLayout1.xml';

        return self::load($xmlReader, $xmlReader->getElement('/p:sldLayout'));
    }

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        $instance = new static($tag);

        $node = $instance->getElement($xmlReader, $element);
        if (!$node) {
            return null;
        }

        $instance->currentFilename = self::$fileName;

        $instance->type = $node->getAttribute('type');
        $instance->preserve = $node->getAttribute('preserve');

        $instance->csld = CSld::load($xmlReader, $node);
        $instance->clrMapOvr = ClrMapOvr::load($xmlReader, $node);

        return $instance;
    }

    public function writeFile(ZipArchive $zipArchive): void
    {
        $xmlWriter = new XMLWriter(XMLWriter::STORAGE_MEMORY);

        $xmlWriter->startDocument('1.0', 'UTF-8', 'yes');

        $this->write($xmlWriter);

        $zipArchive->addFromString($this->currentFilename, $xmlWriter->getData());
    }

    public function write(XMLWriter $xmlWriter): void
    {
        $xmlWriter->startElement($this->tag);

        $this->type !== '' && $xmlWriter->writeAttribute('type', $this->type);
        $this->preserve !== '' && $xmlWriter->writeAttribute('preserve', $this->preserve);

        $this->csld && $this->csld->write($xmlWriter);
        $this->clrMapOvr && $this->clrMapOvr->write($xmlWriter);

        $xmlWriter->endElement();
    }
}
