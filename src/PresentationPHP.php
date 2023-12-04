<?php

declare(strict_types=1);

namespace ThiagoRizzo\PresentationPHP;

use ThiagoRizzo\PresentationPHP\Models\DocProps\App;
use ThiagoRizzo\PresentationPHP\Models\DocProps\Core;
use ThiagoRizzo\PresentationPHP\Models\Slide;

class PresentationPHP
{
    /**
     * All slides
     * @var array<int, Slide> $slides
     */
    public array $slides;

    public App $app;

    public Core $core;

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
     * @return array<int, Slide>
     */
    public function getSlides(): array
    {
        return $this->slides;
    }

    /**
     * @param array<int, Slide> $slides
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
