<?php

namespace Statamic\Addons\PrestigeWorldWide;

use Statamic\API\Str;
use Statamic\API\File;
use Statamic\API\YAML;
use Statamic\API\Nav;
use Statamic\API\Entry;
use Statamic\Data\Data;
use Statamic\API\Collection;
use Statamic\Extend\Listener;
use Statamic\Events\Data\FindingFieldset;
use Illuminate\Support\Facades\Cache;
use Statamic\Contracts\Forms\Submission;
use Illuminate\Http\Response;

class PrestigeWorldWideListener extends Listener
{

    /**
     * The events to be listened for, and the methods to call.
     *
     * @var array
     */
    public $events = [
        FindingFieldset::class => 'handle',
        'Form.submission.creating' => 'handleSubmission',
        'response.created' => 'handleResponse'
    ];

    /**
     * Add the events tab to the chosen entry
     *
     * @var array
     */
    public function handle(FindingFieldset $eventCollection)
    {
        // Get the saved events collection from the settings
        $this->eventsCollection = $this->getConfig('my_collections_field');

        // Check if the entry is in the correct collection
        if ($eventCollection->data->collectionName() == $this->eventsCollection) {

            $fieldset = $eventCollection->fieldset;
            $sections = $fieldset->sections();
            $fields = YAML::parse(File::get($this->getDirectory().'/resources/fieldsets/content.yaml'))['fields'];

            $sections['event'] = [
                'display' => 'Event info',
                'fields' => $fields
            ];

            $contents = $fieldset->contents();
            $contents['sections'] = $sections;
            $fieldset->contents($contents);

        }
    }

    /**
     * Get the entry id from the session and add to the form submission
     *
     * @var array
     */
    public function handleSubmission(Submission $submission)
    {
        $entry_id = session()->pull('pw_id', 'default');
        $submission->set('pw_id', $entry_id);

        return [
            'submission' => $submission
        ];
    }

    /**
     * Add the entry id to the session
     *
     * @var array
     */
    public function handleResponse(Response $response)
    {
        $view       = $response->getOriginalContent();
        $entry_id   = $view->getData()['id'];

        if ($view->getData()['id'] !== NULL) {
            session(['pw_id' => $entry_id]);
        }
    }

}
