<?php

namespace Statamic\Addons\PrestigeWorldWide;

use Statamic\API\Page;
use Statamic\API\Collection;
use Statamic\API\Entry;
use Statamic\API\Content;
use Statamic\Extend\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrestigeWorldWideController extends Controller
{
    /**
     * Maps to your route definition in routes.yaml
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->view('index');
    }

    /**
     * Maps to your route definition in routes.yaml
     *
     * @return mixed
     */
    public function edit(Request $request)
    {
        return $this->view('edit', [
            'items' => $this->getItems($request),
            'menu' => $request->menu
        ]);
    }
}
