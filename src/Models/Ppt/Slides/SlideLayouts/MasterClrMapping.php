<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides\SlideLayouts;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class MasterClrMapping extends Model
{
    public string $tag = 'a:masterClrMapping';
}
