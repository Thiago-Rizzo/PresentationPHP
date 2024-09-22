<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use PhpOffice\Common\XMLWriter;
use ThiagoRizzo\PresentationPHP\Models\Model;

class RPr extends Model
{
    public string $tag = 'a:rPr';
    public string $lang = '';
    public string $smtClean = '';

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        $instance = new static($tag);

        $node = $instance->getElement($xmlReader, $element);
        if (!$node) {
            return null;
        }

        $instance->lang = $node->getAttribute('lang');
        $instance->smtClean = $node->getAttribute('smtClean');

        return $instance;
    }

    public function write(XMLWriter $xmlWriter): void
    {
        $xmlWriter->startElement($this->tag);

        $this->lang !== '' && $xmlWriter->writeAttribute('lang', $this->lang);
        $this->smtClean !== '' && $xmlWriter->writeAttribute('smtClean', $this->smtClean);

        $xmlWriter->endElement();
    }
}
