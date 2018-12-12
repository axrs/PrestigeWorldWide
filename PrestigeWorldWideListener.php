<?php

namespace Statamic\Addons\PrestigeWorldWide;

use Statamic\API\Str;
use Statamic\API\File;
use Statamic\API\YAML;
use Statamic\API\Nav;
use Statamic\API\Collection;
use Statamic\Extend\Listener;
use Statamic\Events\Data\FindingFieldset;
use Illuminate\Support\Facades\Cache;
use Statamic\Addons\SeoPro\Sitemap\Sitemap;

class PrestigeWorldWideListener extends Listener
{

    /**
     * The events to be listened for, and the methods to call.
     *
     * @var array
     */
    public $events = [
        FindingFieldset::class => 'handle'
    ];

    public function handle(FindingFieldset $eventCollection)
    {
        // Get the saved events collection from the settings
        $this->eventsCollection = $this->getConfig('my_collections_field');

        // Check if the entry is in the correct collection
        if ($eventCollection->data->collectionName() == $this->eventsCollection) {

            $fieldset = $eventCollection->fieldset;
            $sections = $fieldset->sections();
            $fields = YAML::parse(File::get($this->getDirectory().'/resources/fieldsets/content.yaml'))['fields'];
            // dd($fields['event']['fields']);

            // $eventFields = collect($fields['event']['fields'])->map(function ($field, $key) use ($event) {
                // $field['placeholder'] = $this->getPlaceholder($key, $field, $event->data);
                // return $field;
            // })->all();

            // $fields['event']['fields'] = $this->translateFieldsetFields($eventFields, 'content');

            $sections['event'] = [
                'display' => 'Event info',
                'fields' => $fields
            ];

            $contents = $fieldset->contents();
            $contents['sections'] = $sections;
            $fieldset->contents($contents);

        }
    }

    protected function getPlaceholder($key, $field, $data)
    {
        if (! $data) {
            return;
        }

        $vars = (new TagData)
            ->with(Settings::load()->get('defaults'))
            ->with($data->getWithCascade('event', []))
            ->withCurrent($data)
            ->get();

        return array_get($vars, $key);
    }

}
