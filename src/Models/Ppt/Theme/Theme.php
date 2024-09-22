<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Theme;

use PhpOffice\Common\XMLReader;
use PhpOffice\Common\XMLWriter;
use DOMElement;
use ThiagoRizzo\PresentationPHP\Models\Model;

class Theme extends Model
{
    public string $tag = "a:theme";

    public string $xmlnsA = "";

    public string $name = "";

    public ?ThemeElements $themeElements = null;
    public ?ObjectDefaults $objectDefaults = null;
    public ?ExtraClrSchemeLst $extraClrSchemeLst = null;

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?Model
    {
        $instance = new static($tag);

        $node = $instance->getElement($xmlReader, $element);
        if (!$node) {
            return null;
        }

        $instance->xmlnsA = $xmlReader->getAttribute("xmlns:a", $element);
        $instance->name = $xmlReader->getAttribute("name", $element);

        $instance->themeElements = ThemeElements::load($xmlReader, $node);
        $instance->objectDefaults = ObjectDefaults::load($xmlReader, $node);
        $instance->extraClrSchemeLst = ExtraClrSchemeLst::load($xmlReader, $node);

        return $instance;
    }

    public function write(XMLWriter $xmlWriter): void
    {
        $xmlWriter->startElement($this->tag);

        $this->xmlnsA !== "" && $xmlWriter->writeAttribute("xmlns:a", $this->xmlnsA);
        $this->name !== "" && $xmlWriter->writeAttribute("name", $this->name);

        $this->themeElements && $this->themeElements->write($xmlWriter);
        $this->objectDefaults && $this->objectDefaults->write($xmlWriter);
        $this->extraClrSchemeLst && $this->extraClrSchemeLst->write($xmlWriter);

        $xmlWriter->endElement();
    }
}
