<?php

namespace ThiagoRizzo\PresentationPHP;

use Exception;
use PhpOffice\Common\XMLReader;
use SimpleXMLElement;

class Utils
{
    public static function registerXMLReader(string $xml): XMLReader
    {
        $xmlReader = new XMLReader();
        $xmlReader->getDomFromString($xml);

        try {
            $simpleXml = new SimpleXMLElement($xml);

            $namespaces = $simpleXml->getDocNamespaces(true);

            foreach ($namespaces as $prefix => $namespace) {
                if ($prefix) {
                    $xmlReader->registerNamespace($prefix, $namespace);
                } else {
                    $xml = str_replace($namespace, '', $xml);
                    $xmlReader->getDomFromString($xml);
                }
            }
        } catch (Exception $exception) {
            return $xmlReader;
        }

        return $xmlReader;
    }
}
