<?php

class GeneralTest extends PHPUnit\Framework\TestCase
{

    /**
     * @throws Exception
     */
    public function test()
    {
        $t = ThiagoRizzo\PresentationPHP\Reader\PowerPoint2007::load(realpath(__DIR__ . '/novo.pptx'));

        $t->save(__DIR__ . '/novo.zip');

        echo 'test';
    }
}