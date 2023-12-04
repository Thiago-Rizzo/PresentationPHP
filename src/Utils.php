<?php

namespace ThiagoRizzo\PresentationPHP;

use DOMDocument;
use DOMElement;

class Utils
{
    /**
     * @param DOMElement|DOMDocument $document
     * @param string $path
     * @return DOMElement|null
     */
    public static function getElement($document, string $path): ?DOMElement
    {
        $elements = $document->getElementsByTagName($path);

        if ($elements->length > 0) {
            return $elements->item(0) instanceof DOMElement ? $elements->item(0) : null;
        }

        return null;
    }
}
