<?php

namespace Statamic\Addons\PrestigeWorldWide;

use Statamic\Extend\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Statamic\API\Collection;

class PrestigeWorldWideController extends Controller
{
    /**
     * Maps to your route definition in routes.yaml
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        $event_storage = Storage::files('/site/storage/addons/PrestigeWorldWide');
        $events = [];

        if (!$event_storage) {
            return redirect()->route('addons.event.create');
        }

        foreach ($event_storage as $event) {
            $add = str_replace('site/storage/addons/PrestigeWorldWide/', '', $event);
            $add = str_replace('.json', '', $add);
            $events[] = $add;
        }

        return $this->view('index', [
            'events' => $events
        ]);
    }

    /**
     * Maps to your route definition in routes.yaml
     *
     * @return mixed
     */
    public function edit(Request $request)
    {
        return $this->view('edit', [
            'event' => $request->event
        ]);
    }

    /**
     * Maps to your route definition in routes.yaml
     *
     * @return mixed
     */
    public function create(Request $request)
    {
        return $this->view('create');
    }

    /**
     * Maps to your route definition in routes.yaml
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        $event_name = str_slug($request->event_title);

        $this->storage->putJSON($event_name, []);

        return [
            'success' => true,
            'message' => 'Events updated successfully.',
            'title'    => $event_name
        ];
    }
}
