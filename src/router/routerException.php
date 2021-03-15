<?php

namespace App\router;

use App\Service\TwigRender;

/**
 * class call when an router have error
 */
class RouterException
{
    private $renderer;

    public function __construct()
    {
        $this->renderer = new TwigRender();
    }

    /**
     * render the 404 pages
     */
    public function error404()
    {
        $this->renderer->render('404');
    }
}
