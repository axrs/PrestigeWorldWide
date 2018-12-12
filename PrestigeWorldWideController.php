<?php

namespace Statamic\Addons\PrestigeWorldWide;

use Statamic\Extend\Controller;

class PrestigeWorldWideController extends Controller
{
    /**
     * Maps to your route definition in routes.yaml
     *
     * @return mixed
     */
    public function getFoo()
    {
        return $this->view('foo', [
            'title' => 'Karma'
        ]);
    }
}
