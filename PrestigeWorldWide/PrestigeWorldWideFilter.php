<?php

namespace Statamic\Addons\PrestigeWorldWide;

use Carbon\Carbon;
use Statamic\Extend\Filter;

class PrestigeWorldWideFilter extends Filter
{
    /**
     * Perform filtering on a collection
     *
     * @return \Illuminate\Support\Collection
     */
    public function filter()
    {
        $remove = $this->getParam('remove');
        $year = $this->getParam('year');

        if (trim($year) != "") {
            return $this->collection->filter(function ($entry) use ($year) {
                if ($entry->get('pw_start_date')) {
                    return (new Carbon($entry->get('pw_start_date')))->format('Y') == $year;
                }
            });
        } else if ($remove == 'future') {
            // Return future events
            return $this->collection->filter(function ($entry) {
                if ($entry->get('pw_start_date')) {
                    return (new Carbon($entry->get('pw_start_date')))->lt(Carbon::now());
                }
            });
        } else if ($remove == 'past') {
            // Return past events
            return $this->collection->filter(function ($entry) {
                if ($entry->get('pw_start_date')) {
                    return (new Carbon($entry->get('pw_start_date')))->gt(Carbon::now());
                }
            });
        } else {
            return $this->collection->filter(function ($entry) {
                return true;
            });
        }
    }
}
