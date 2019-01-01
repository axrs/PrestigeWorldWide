<?php

namespace Statamic\Addons\PrestigeWorldWide\Commands;

use Statamic\API\Helper;
use Statamic\API\Stache;
use Statamic\API\Collection;
use Statamic\API\Entry;
use Statamic\API\File;
use Carbon\Carbon;
use Statamic\Data\Entries\EntryFactory;
use Statamic\Extend\Command;

class RecurringCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prestigeworldwide:recurring';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate files for recurring events';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $eventsCollection   = $this->getConfig('my_collections_field');
        $collection         = Entry::whereCollection($eventsCollection);

        foreach ($collection as $entry) {

            if ($entry->has('pw_recurring')) {

                // Get the entry to duplicate
                $original_entry = Entry::find($entry->id());

                // Work out the slug, if the current slug doesn't already end with a timestamp, add one, if it does, update it
                // $slug = $original_entry->slug();
                // if ( ! preg_match( '~[0-9]{10}$~', $slug ) ) {
                //   $slug .= '-'.time();
                // } else {
                //   $slug = preg_replace( '~[0-9]{10}$~', time(), $slug );
                // }

                // Create duplicate entry - modify the slug with the current timestamp to ensure it is unique
                $duplicate_entry = Entry::create('event-recurring-test')
                    ->collection( $entry->collectionName() )
                    ->with( $original_entry->data() )
                    ->date('2016-05-10')
                    ->get();

                // Set the order
                $duplicate_entry->order( $original_entry->order() );

                // Add `(copy)` after the title
                $duplicate_entry->set( 'title', 'test' );

                // Make a new ID (clear the old one first)
                $duplicate_entry->set( 'id', '' );
                $duplicate_entry->id( Helper::makeUuid() );

                // And finally... save it
                $duplicate_entry->save();

                // Update the stache
                Stache::update();

            }

        }
    }

    // This should be smarter and consider the names of other entries, and not just the one being
    // duplicated, i.e. if the entry is called `My Entry (copy)`, it should check to see if there is
    // already an entry called `My Entry (copy 2)` before blindy calling the duplicated entry this.
    private function getTitle( $title )
    {

      $suffix = $this->trans('settings.copy');

      // does the title already contain the suffix? if so then increment it to 2
      if( preg_match( "~ \({$suffix}\)$~", $title ) ) {

        $just_title = preg_replace( "~^(.+) \({$suffix}\)$~", "$1", $title );

        return "{$just_title} ({$suffix} 2)";

      // does the title already contain the suffix with an increment? if so then increment it by 1
      } else if( preg_match( "~\({$suffix} (\d)\)$~", $title, $matches ) ) {

        $just_title = preg_replace( "~^(.+) \({$suffix} \d\)$~", "$1", $title );

        return "{$just_title} ({$suffix} ".( $matches[1] + 1 ).")";

      // else, just add the suffix
      } else {

        return "{$title} ({$suffix})";

      }

    }
}
