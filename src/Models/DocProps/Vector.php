<?php

namespace ThiagoRizzo\PresentationPHP\Models\DocProps;

use DOMElement;
use PhpOffice\Common\XMLReader;
use PhpOffice\Common\XMLWriter;
use ThiagoRizzo\PresentationPHP\Models\Model;

class Vector extends Model
{
    public string $tag = 'vt:vector';

    public string $baseType = '';

    public string $size = '';

    /** @var Lpstr[] $lpstr */
    public array $lpstr = [];

    /** @var Variant[] $variant */
    public array $variant = [];

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        $instance = new static($tag);

        $node = $instance->getElement($xmlReader, $element);
        if (!$node) {
            return null;
        }

        $instance->size = $node->getAttribute('size');
        $instance->baseType = $node->getAttribute('baseType');

        $lpstrs = $xmlReader->getElements('vt:lpstr', $node);
        for ($i = 0; $i < $lpstrs->length; $i++) {
            $instance->lpstr[$i] = Lpstr::load($xmlReader, $lpstrs->item($i));
        }

        $variants = $xmlReader->getElements('vt:variant', $node);
        for ($i = 0; $i < $variants->length; $i++) {
            $instance->variant[$i] = Variant::load($xmlReader, $variants->item($i));
        }

        return $instance;
    }

    public function write(XMLWriter $xmlWriter): void
    {
        $xmlWriter->startElement($this->tag);

        $this->size !== '' && $xmlWriter->writeAttribute('size', $this->size);
        $this->baseType !== '' && $xmlWriter->writeAttribute('baseType', $this->baseType);

        foreach ($this->lpstr as $lpstr) {
            $lpstr && $lpstr->write($xmlWriter);
        }

        foreach ($this->variant as $variant) {
            $variant && $variant->write($xmlWriter);
        }

        $xmlWriter->endElement();
    }
}
