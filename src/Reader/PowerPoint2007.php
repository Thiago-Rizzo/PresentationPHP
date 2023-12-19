<?php

namespace ThiagoRizzo\PresentationPHP\Reader;

use Exception;
use ThiagoRizzo\PresentationPHP\Models\DocProps\App;
use ThiagoRizzo\PresentationPHP\Models\DocProps\Core;
use ThiagoRizzo\PresentationPHP\PresentationPHP;
use ZipArchive;

class PowerPoint2007
{
    protected PresentationPHP $presentation;

    protected ZipArchive $zipArchive;

    protected string $fileName;

    public function __construct(string $fileName = '')
    {
        $this->fileName = $fileName;
        $this->presentation = new PresentationPHP();
    }

    /**
     * @throws Exception
     */
    public function isPresentation(): bool
    {
        if (!file_exists($this->fileName)) {
            echo 'File not found: ' . $this->fileName . PHP_EOL;
            throw new Exception($this->fileName);
        }

        $zipArchive = new ZipArchive();

        if ($zipArchive->open($this->fileName) === true) {
            $hasContentTypes = $zipArchive->statName('[Content_Types].xml') !== false;
            $hasPresentation = $zipArchive->statName('ppt/presentation.xml') !== false;

            $zipArchive->close();
            if ($hasContentTypes && $hasPresentation) {
                return true;
            }
        }

        $zipArchive->close();
        return false;
    }

    /**
     * @throws Exception
     */
    public static function load(string $fileName = ''): PresentationPHP
    {
        $pptx = new self($fileName);

        if (!$pptx->isPresentation()) {
            throw new Exception($pptx->fileName);
        }

        return $pptx->read();
    }

    public function read(): PresentationPHP
    {
        $this->zipArchive = new ZipArchive();

        $this->zipArchive->open($this->fileName);

        $this->loadRels();

        // /docProps
        $this->loadDocumentProperties();

        return $this->presentation;
    }

    private function loadDocumentProperties(): void
    protected function loadRels(): void
    {
        for ($index = 0; $index < $this->zipArchive->numFiles; $index++) {
            $relPath = $this->zipArchive->statIndex($index)['name'];
            if (Str::endsWith($relPath, '.rels')) {
                $this->presentation->addRels($relPath, Relationships::loadFile($this->zipArchive, $relPath));
            }
        }
    }

    {
        $this->presentation->setApp(App::load($this->zipArchive));
        $this->presentation->setCore(Core::load($this->zipArchive));
//        $this->presentation->getCustom()->load($this->zipArchive);
    }
}
