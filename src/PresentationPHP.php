<?php

declare(strict_types=1);

namespace ThiagoRizzo\PresentationPHP;

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
        $this->slides = [new Slide()];

        $this->app = new App();
        $this->core = new Core();
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

    public function addSlide(Slide $slide): void
    {
        $this->slides[] = $slide;
    }

    public function removeSlide(int $index): void
    {
        unset($this->slides[$index]);
    }

    public function getSlide(int $index): Slide
    {
        return $this->slides[$index];
    }

    public function setSlide(int $index, Slide $slide): void
    {
        $this->slides[$index] = $slide;
    }

    public function getSlideCount(): int
    {
        return count($this->slides);
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
}
