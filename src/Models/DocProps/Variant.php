<?php

namespace ThiagoRizzo\PresentationPHP\Models\DocProps;

use DOMElement;
use PhpOffice\Common\XMLReader;
use PhpOffice\Common\XMLWriter;
use ThiagoRizzo\PresentationPHP\Models\Model;

class Variant extends Model
{
    public string $tag = 'vt:variant';

    public ?Lpstr $lpstr = null;

    public ?I4 $i4 = null;

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        $instance = new static($tag);

        $node = $instance->getElement($xmlReader, $element);
        if (!$node) {
            return null;
        }

        $instance->lpstr = Lpstr::load($xmlReader, $node);
        $instance->i4 = I4::load($xmlReader, $node);

        return $instance;
    }

    public function write(XMLWriter $xmlWriter): void
    {
        $xmlWriter->startElement($this->tag);

        $this->lpstr && $this->lpstr->write($xmlWriter);
        $this->i4 && $this->i4->write($xmlWriter);

        $xmlWriter->endElement();
    }
}
