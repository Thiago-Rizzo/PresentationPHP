<?php

namespace ThiagoRizzo\PresentationPHP\Reader;

use Exception;
use Illuminate\Support\Str;
use ThiagoRizzo\PresentationPHP\Models\Files\App;
use ThiagoRizzo\PresentationPHP\Models\Files\Core;
use ThiagoRizzo\PresentationPHP\Models\Files\SlideLayout;
use ThiagoRizzo\PresentationPHP\Models\Rels\Relationships;
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
     * @param PresentationPHP $presentation
     */
    public function setPresentation(PresentationPHP $presentation): void
    {
        $this->presentation = $presentation;
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

        // /ppt
        $this->loadSlideLayouts();
//        $this->loadSlideMasters();
//        $this->loadSlides();
//        $this->loadTheme();
//        $this->loadPresentation();
//        $this->loadPresProps();
//        $this->loaTableStyles();
//        $this->loadViewProps();
//
//        // /
//        $this->loadContentTypes();

        return $this->presentation;
    }

    protected function loadRels(): void
    {
        for ($index = 0; $index < $this->zipArchive->numFiles; $index++) {
            $relPath = $this->zipArchive->statIndex($index)['name'];
            if (Str::endsWith($relPath, '.rels')) {
                $this->presentation->addRels($relPath, Relationships::loadFile($this->zipArchive, $relPath));
            }
        }
    }

    protected function loadDocumentProperties(): void
    {
        $this->presentation->setApp(App::loadFile($this->zipArchive));
        $this->presentation->setCore(Core::loadFile($this->zipArchive));
//        $this->presentation->getCustom()->load($this->zipArchive);
    }

    protected function loadSlideLayouts(): void
    {
        for ($index = 0; $index < $this->zipArchive->numFiles; $index++) {
            $namePath = $this->zipArchive->statIndex($index)['name'];

            if (Str::contains($namePath, 'slideLayouts/slideLayout')) {
                $this->presentation->addSlideLayout(SlideLayout::loadFile($this->zipArchive, $namePath));
            }
        }
    }
}
