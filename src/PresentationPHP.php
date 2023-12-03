<?php

declare(strict_types=1);

namespace ThiagoRizzo\PresentationPHP;

use ThiagoRizzo\PresentationPHP\Models\Core;

class PresentationPHP
{
    /**
     * All slides
     * @var array<int, Core\Slide> $slides
     */
    protected array $slides;

    /**
     * Create a new PhpPresentation with one Slide.
     */
    public function __construct()
    {
        $this->slides = [new Core\Slide()];
    }

    /**
     * @return array<int, Core\Slide>
     */
    public function getSlides(): array
    {
        return $this->slides;
    }

    /**
     * @param array<int, Core\Slide> $slides
     */
    public function setSlides(array $slides): void
    {
        $this->slides = $slides;
    }

    public function addSlide(Core\Slide $slide): void
    {
        $this->slides[] = $slide;
    }

    public function removeSlide(int $index): void
    {
        unset($this->slides[$index]);
    }

    public function getSlide(int $index): Core\Slide
    {
        return $this->slides[$index];
    }

    public function setSlide(int $index, Core\Slide $slide): void
    {
        $this->slides[$index] = $slide;
    }

    public function getSlideCount(): int
    {
        return count($this->slides);
    }
}
