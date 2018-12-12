<?php

namespace Statamic\Addons\PrestigeWorldWide;

use Statamic\API\Nav;
use Statamic\Extend\Listener;

class PrestigeWorldWideListener extends Listener
{
    /**
     * The events to be listened for, and the methods to call.
     *
     * @var array
     */
    public $events = [
        'cp.nav.created' => 'addNavItems',
        'cp.add_to_head' => 'injectMenuStyles'
    ];

    public function addNavItems($nav)
    {
        // Create the first level navigation item
        // Note: by using route('store'), it assumes you've set up a route named 'store'.
        $events = Nav::item('Events')->route('addons.events')->icon('calendar');

        // Finally, add our first level navigation item
        // to the navigation under the 'tools' section.
        $nav->addTo('tools', $events);
    }

    /**
     * Return a <link> tag containing the addon stylesheet
     * @return string
     */
    public function injectMenuStyles()
    {
        $html = $this->css->tag('styles');
        return $html;
    }
}
