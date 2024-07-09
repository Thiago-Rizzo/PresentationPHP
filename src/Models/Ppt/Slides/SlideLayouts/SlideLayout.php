<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides\SlideLayouts;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;
use ThiagoRizzo\PresentationPHP\Utils;
use ZipArchive;

class SlideLayout extends Model
{
    public string $tag = 'p:sldLayout';
    public string $type = 'title';
    public string $preserve = '1';

    public ?CSld $csld = null;
    public ?ClrMapOvr $clrMapOvr = null;

    public static function loadFile(ZipArchive $zipArchive, ?string $fileName = null): ?self
    {
        $xml = $zipArchive->getFromName($fileName ?? 'ppt/slideLayouts/slideLayout1.xml');
        $xmlReader = Utils::registerXMLReader($xml);

        return self::load($xmlReader, $xmlReader->getElement('/p:sldLayout'));
    }

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        $instance = new static($tag);

        $node = $instance->getElement($xmlReader, $element);
        if (!$node) {
            return null;
        }

        $instance->type = $node->getAttribute('type');
        $instance->preserve = $node->getAttribute('preserve');

        $instance->csld = CSld::load($xmlReader, $node);
        $instance->clrMapOvr = ClrMapOvr::load($xmlReader, $node);

        return $instance;
    }
}
