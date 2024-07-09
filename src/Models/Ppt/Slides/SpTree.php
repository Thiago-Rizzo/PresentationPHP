<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class SpTree extends Model
{
    public string $tag = 'p:spTree';

    /** @var Sp[]|null $sps */
    public ?array $sps = null;

    public ?GrpSpPr $grpSpPr = null;

    public ?NvGrpSpPr $nvGrpSpPr = null;

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        $instance = new static($tag);

        $node = $instance->getElement($xmlReader, $element);
        if (!$node) {
            return null;
        }

        $sps = $xmlReader->getElements('p:sp', $node);
        for ($i = 0; $i < $sps->length; $i++) {
            $instance->sps[] = Sp::load($xmlReader, $sps->item($i));
        }

        $instance->grpSpPr = GrpSpPr::load($xmlReader, $node);
        $instance->nvGrpSpPr = NvGrpSpPr::load($xmlReader, $node);

        return $instance;
    }
}
