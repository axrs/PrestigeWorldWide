<?php

namespace Statamic\Addons\PrestigeWorldWide;

use Statamic\Contracts\Forms\Submission;
// use Statamic\Contracts\Data\Data;
use Statamic\API\Form;
use Statamic\API\Page;
use Statamic\API\Entry;
use Statamic\Extend\Collection;
use Statamic\Extend\Tags;
// use bundles\Session\SessionTags;

class PrestigeWorldWideTags extends Tags
{
    /**
     * The {{ prestige_world_wide }} tag
     *
     * @return string|array
     */
    public function index()
    {
        //
    }

    /**
     * The {{ prestige_world_wide:has_start_date }} tag
     *
     * @return string
     */
    public function hasStartDate()
    {
        if (isset($this->context['pw_start_date'])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * The {{ prestige_world_wide:start_date }} tag
     *
     * @return string
     */
    public function startDate()
    {
        if (isset($this->context['pw_start_date'])) {
            return $this->context['pw_start_date'];
        }
    }

    /**
     * The {{ prestige_world_wide:has_end_date }} tag
     *
     * @return string
     */
    public function hasEndDate()
    {
        if (isset($this->context['pw_has_end_date'])) {
            if ($this->context['pw_has_end_date'] == true) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * The {{ prestige_world_wide:end_date }} tag
     *
     * @return string
     */
    public function endDate()
    {
        if (isset($this->context['pw_end_date'])) {
            return $this->context['pw_end_date'];
        }
    }

    /**
     * The {{ prestige_world_wide:has_costs }} tag
     *
     * @return string
     */
    public function hasCosts()
    {
        if (isset($this->context['pw_costs'])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * The {{ prestige_world_wide:costs }} tag
     *
     * @return string
     */
    public function costs()
    {
        if (isset($this->context['pw_costs'])) {
            return $this->context['pw_costs'];
        }
    }

    /**
     * The {{ prestige_world_wide:has_location }} tag
     *
     * @return string
     */
    public function hasLocation()
    {
        if (isset($this->context['pw_location'])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * The {{ prestige_world_wide:location }} tag
     *
     * @return string
     */
    public function location()
    {
        if (isset($this->context['pw_location'])) {
            return $this->context['pw_location'];
        }
    }

    /**
     * The {{ prestige_world_wide:has_url }} tag
     *
     * @return string
     */
    public function hasUrl()
    {
        if (isset($this->context['pw_url'])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * The {{ prestige_world_wide:url }} tag
     *
     * @return string
     */
    public function url()
    {
        if (isset($this->context['pw_url'])) {
            return $this->context['pw_url'];
        }
    }

    /**
     * The {{ prestige_world_wide:has_organizer }} tag
     *
     * @return string
     */
    public function hasOrganizer()
    {
        if (isset($this->context['pw_organizer'])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * The {{ prestige_world_wide:organizer }} tag
     *
     * @return string
     */
    public function organizer()
    {
        if (isset($this->context['pw_organizer'])) {
            return $this->context['pw_organizer'];
        }
    }

    /**
     * The {{ prestige_world_wide:participants }} tag
     *
     * @return string
     */
    public function participants()
    {
        if (isset($this->context['pw_max_participants'])) {
            return $this->context['pw_max_participants'];
        }
    }

    /**
     * The {{ prestige_world_wide:is_full }} tag
     *
     * @return string
     */
    public function isFull()
    {
        if (isset($this->context['pw_form'])) {
            // return 'Not full';

            $pw_form = Form::all();

            foreach ($pw_form as $pw_form) {

                if ($pw_form['name'] == $this->context['pw_form']) {

                    if ($pw_form['count'] > $this->participants()) {
                        // return $pw_form['count'];
                        return 'Full';
                    } else {
                        return 'Not full';
                    }
                }
            }
        }
    }

    /**
     * The {{ prestige_world_wide:info }} tag
     *
     * @return string|array
     */
    public function info()
    {
        //
        $html = '<div class="pw_info">';

        if ($this->hasStartDate() == true) {
            $html .= '<div class="pw_info__row">';
            $html .= '<span class="pw_info__header">Start date:</span> <span class="pw_info__data">' . $this->startDate() . '</span>';
            $html .= '</div>';
        }
        if ($this->hasEndDate() == true) {
            $html .= '<div class="pw_info__row">';
            $html .= '<span class="pw_info__header">End date:</span> <span class="pw_info__data">' . $this->endDate() . '</span>';
            $html .= '</div>';
        }
        if ($this->hasCosts() == true) {
            $html .= '<div class="pw_info__row">';
            $html .= '<span class="pw_info__header">Cost:</span> <span class="pw_info__data">' . $this->costs() . '</span>';
            $html .= '</div>';
        }
        if ($this->hasLocation() == true) {
            $html .= '<div class="pw_info__row">';
            $html .= '<span class="pw_info__header">Location:</span> <span class="pw_info__data">' . $this->location(). '</span>';
            $html .= '</div>';
        }
        if ($this->hasUrl() == true) {
            $html .= '<div class="pw_info__row">';
            $html .= '<a href="' . $this->url() .  '" class="pw_info__url">';
            if ($this->hasOrganizer() == true) {
                $html .= $this->organizer();
            } else {
                $html .= 'External url';
            }
            $html .= '</a>';
            $html .= '</div>';
        }

        $html .= '</div>';
        return $html;
    }

}
