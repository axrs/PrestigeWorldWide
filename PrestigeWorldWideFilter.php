<?php

namespace Statamic\Addons\PrestigeWorldWide;

use Statamic\API\Collection;
use Statamic\API\Data;
use Statamic\API\Entry;
use Statamic\Data\Entries\EntryCollection;
use Statamic\Extend\Filter;
use Carbon\Carbon;

class PrestigeWorldWideFilter extends Filter
{

    /**
     * Perform filtering on a collection
     *
     * @return \Illuminate\Support\Collection
     */
    public function filter()
    {
        //
        $to                 = $this->getParam('to');
        $eventsCollection   = $this->getConfig('my_collections_field');
        $collection         = Entry::whereCollection($eventsCollection);

        if ($to == 'future') {
            // Return future events
            return $collection->filter(function ($entry) {
                return (new Carbon($entry->get('pw_start_date')))->gt(Carbon::now());
            });

        } else if ($to == 'past') {
            // Return past events
            return $collection->filter(function ($entry) {
                return (new Carbon($entry->get('pw_start_date')))->lt(Carbon::now());
            });

        }

    }
}
