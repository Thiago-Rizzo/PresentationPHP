<?php

declare(strict_types=1);

namespace ThiagoRizzo\PresentationPHP;

use Exception;
use ThiagoRizzo\PresentationPHP\Models\DocProps\App;
use ThiagoRizzo\PresentationPHP\Models\DocProps\Core;
use ThiagoRizzo\PresentationPHP\Models\Ppt\Presentation;
use ThiagoRizzo\PresentationPHP\Models\Ppt\PresProps;
use ThiagoRizzo\PresentationPHP\Models\Ppt\Slides\Slide;
use ThiagoRizzo\PresentationPHP\Models\Ppt\Slides\SlideLayouts\SlideLayout;
use ThiagoRizzo\PresentationPHP\Models\Ppt\Slides\SlideMasters\SlideMaster;
use ThiagoRizzo\PresentationPHP\Models\Ppt\TableStyles;
use ThiagoRizzo\PresentationPHP\Models\Ppt\Themes\Theme;
use ThiagoRizzo\PresentationPHP\Models\Ppt\ViewProps;
use ThiagoRizzo\PresentationPHP\Models\Rels\Relationships;
use ThiagoRizzo\PresentationPHP\Reader\PowerPoint2007;
use ZipArchive;

class PresentationPHP
{
    /** @var Slide[] $slides */
    protected array $slides;

    /** @var SlideMaster[] $slideMasters */
    protected array $slideMasters;

    /** @var SlideLayout[] $slideLayouts */
    protected array $slideLayouts;

    /** @var Theme[] $themes */
    protected array $themes;

    protected PresProps $presProps;

    protected Presentation $presentation;

    protected TableStyles $tableStyles;

    protected ViewProps $viewProps;

    protected App $app;

    protected Core $core;

    /** @var Relationships[] $rels */
    protected array $rels = [];

    /**
     * Create a new PhpPresentation with one Slide.
     */
    public function __construct()
    {
        $this->app = new App();
        $this->core = new Core();

        $this->slides = [new Slide()];
        $this->slideMasters = [];
        $this->slideLayouts = [];
        $this->themes = [];
        $this->presProps = new PresProps();
        $this->presentation = new Presentation();
        $this->tableStyles = new TableStyles();
        $this->viewProps = new ViewProps();
    }

    /**
     * @throws Exception
     */
    public function load(string $fileName): self
    {
        $powerPoint2007 = new PowerPoint2007($fileName);
        $powerPoint2007->setPresentation($this);

        if (!$powerPoint2007->isPresentation()) {
            throw new Exception($fileName);
        }

        return $powerPoint2007->read();
    }

    /**
     * Save PhpPresentation to file.
     *
     * @throws Exception
     */
    public function save(string $filename): void
    {
        if (empty($filename)) {
            throw new Exception('filename is empty');
        }

        $zipAdapter = new ZipArchive();
        $zipAdapter->open($filename, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $this->writeFiles($zipAdapter);

        $zipAdapter->close();
    }

    public function writeFiles(ZipArchive $zipArchive): void
    {
        $this->getApp()->writeFile($zipArchive);
        $this->getCore()->writeFile($zipArchive);

//        $this->getPresProps()->writeFile();
//        $this->getPresentation()->writeFile();
//        $this->getTableStyles()->writeFile();
//        $this->getViewProps()->writeFile();


    }

    /**
     * @return Slide[]
     */
    public function getSlides(): array
    {
        return $this->slides;
    }

    /**
     * @param Slide[] $slides
     */
    public function setSlides(array $slides): void
    {
        $this->slides = $slides;
    }

    /**
     * @param Slide|null $slide
     * @return PresentationPHP
     */
    public function addSlide(?Slide $slide = null): self
    {
        if ($slide === null) {
            $slide = new Slide();
        }

        $this->slides[] = $slide;

        return $this;
    }

    public function getSlideMasters(): array
    {
        return $this->slideMasters;
    }

    public function setSlideMasters(array $slideMasters): void
    {
        $this->slideMasters = $slideMasters;
    }

    /**
     * @param SlideMaster|null $slideMaster
     * @return PresentationPHP
     */
    public function addSlideMaster(?SlideMaster $slideMaster = null): self
    {
        if ($slideMaster === null) {
            $slideMaster = new SlideMaster();
        }

        $this->slideMasters[] = $slideMaster;

        return $this;
    }

    public function getSlideLayouts(): array
    {
        return $this->slideLayouts;
    }

    public function setSlideLayouts(array $slideLayouts): void
    {
        $this->slideLayouts = $slideLayouts;
    }

    /**
     * @param SlideLayout|null $slideLayout
     * @return PresentationPHP
     */
    public function addSlideLayout(?SlideLayout $slideLayout = null): self
    {
        if ($slideLayout) {
            $this->slideLayouts[] = $slideLayout;
        }

        return $this;
    }

    public function getThemes(): array
    {
        return $this->themes;
    }

    public function setThemes(array $themes): void
    {
        $this->themes = $themes;
    }

    /**
     * @param Theme|null $theme
     * @return PresentationPHP
     */
    public function addTheme(?Theme $theme = null): self
    {
        if ($theme === null) {
            $theme = new Theme();
        }

        $this->themes[] = $theme;

        return $this;
    }

    public function getPresProps(): PresProps
    {
        return $this->presProps;
    }

    public function setPresProps(PresProps $presProps): void
    {
        $this->presProps = $presProps;
    }

    public function getPresentation(): Presentation
    {
        return $this->presentation;
    }

    public function setPresentation(Presentation $presentation): void
    {
        $this->presentation = $presentation;
    }

    public function getTableStyles(): TableStyles
    {
        return $this->tableStyles;
    }

    public function setTableStyles(TableStyles $tableStyles): void
    {
        $this->tableStyles = $tableStyles;
    }

    public function getViewProps(): ViewProps
    {
        return $this->viewProps;
    }

    public function setViewProps(ViewProps $viewProps): void
    {
        $this->viewProps = $viewProps;
    }

    public function getApp(): App
    {
        return $this->app;
    }

    public function setApp(App $app): void
    {
        $this->app = $app;
    }

    public function getCore(): Core
    {
        return $this->core;
    }

    public function setCore(Core $core): void
    {
        $this->core = $core;
    }

    public function getRels(): array
    {
        return $this->rels;
    }

    public function setRels(?array $rels = null): self
    {
        $this->rels = $rels ?? [];

        return $this;
    }

    public function addRels(string $relPath, ?Relationships $rels = null): self
    {
        if ($rels) {
            $this->rels[$relPath] = $rels;
        }

        return $this;
    }
}
