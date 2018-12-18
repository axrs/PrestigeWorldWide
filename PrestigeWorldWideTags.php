<?php

namespace Statamic\Addons\PrestigeWorldWide;

use Statamic\Contracts\Forms\Submission;
use Statamic\API\Form;
use Statamic\API\Entry;
use Statamic\Extend\Collection;
use Statamic\Extend\Tags;
use Statamic\API\Folder;
use Illuminate\Support\Facades\Storage;
use Statamic\Data\DataCollection;
use Statamic\API\File;
use Statamic\API\Yaml;
use Illuminate\Http\Request;

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
     * The {{ prestige_world_wide:max_participants }} tag
     *
     * @return string
     */
    public function maxParticipants()
    {
        if (isset($this->context['pw_max_participants'])) {
            return $this->context['pw_max_participants'];
        }
    }

    /**
     * The {{ prestige_world_wide:participants }} tag
     *
     * @return string
     */
    public function participants()
    {
        if (isset($this->context['pw_form'])) {

            $entry_id       = $this->context['id'];
            $pw_formname    = $this->context['pw_form'];
            return $this->submissions($pw_formname, $entry_id);

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

            $entry_id       = $this->context['id'];
            $pw_formname    = $this->context['pw_form'];
            $pw_form        = Form::all();
            $pw_submissions = $this->submissions($pw_formname, $entry_id);
            $pw_max         = $this->maxParticipants();
            // dd($pw_max);

            foreach ($pw_form as $pw_form) {

                if ($pw_form['name'] == $pw_formname) {

                    if ($pw_max !== NULL) {

                        if ($pw_submissions >= $pw_max) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                }
            }
        } else {
            return "You haven't selected a signup form yet.";
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

        $html .= '<div class="pw_info__row pw_info__row--startdate">';
        $html .= '<span class="pw_info__header pw_info__header--startdate">Start date:</span> <span class="pw_info__data pw_info__data--startdate">' . $this->startDate() . '</span>';
        $html .= '</div>';
        if ($this->hasEndDate() == true) {
            $html .= '<div class="pw_info__row pw_info__row--enddate">';
            $html .= '<span class="pw_info__header pw_info__header--enddate">End date:</span> <span class="pw_info__data pw_info__data--enddate">' . $this->endDate() . '</span>';
            $html .= '</div>';
        }
        if ($this->costs()) {
            $html .= '<div class="pw_info__row pw_info__row--cost">';
            $html .= '<span class="pw_info__header pw_info__header--cost">Cost:</span> <span class="pw_info__data pw_info__data--cost">' . $this->costs() . '</span>';
            $html .= '</div>';
        }
        if ($this->location()) {
            $html .= '<div class="pw_info__row pw_info__row--location">';
            $html .= '<span class="pw_info__header pw_info__header--location">Location:</span> <span class="pw_info__data pw_info__data--startdate--location">' . $this->location(). '</span>';
            $html .= '</div>';
        }
        if (!$this->isFull()) {
            if ($this->participants()) {
                $html .= '<div class="pw_info__row pw_info__row--participants">';
                $html .= '<span class="pw_info__header pw_info__header--participants">Signups:</span> <span class="pw_info__data pw_info__data--startdate--participants">' . $this->participants(). '</span>';
                $html .= '</div>';
            }
        }
        if (!$this->isFull()) {
            if ($this->maxParticipants()) {
                $html .= '<div class="pw_info__row pw_info__row--maxparticipants">';
                $html .= '<span class="pw_info__header pw_info__header--maxparticipants">Max # of participants:</span> <span class="pw_info__data pw_info__data--startdate--maxparticipants">' . $this->maxParticipants(). '</span>';
                $html .= '</div>';
            }
        }
        if ($this->url()) {
            $html .= '<div class="pw_info__row pw_info__row--url">';
            $html .= '<a href="' . $this->url() .  '" class="pw_info__url">';
            if ($this->organizer() == true) {
                $html .= $this->organizer();
            }
            $html .= '</a>';
            $html .= '</div>';
        }
        if ($this->isFull()) {
            $html .= '<div class="pw_info__row pw_info__row--full">';
            $html .= "<span class='pw_info__header pw_info__header--full'>Sorry, it's full!</span";
            $html .= '</div>';
        }

        $html .= '</div>';
        return $html;
    }

    /**
     * Return the number of submissions for a form connected to an entry
     *
     * @return mixed
     */
    private function submissions($formname, $entry_id)
    {
        $substorage     = Folder::getFilesByType('/site/storage/forms/' . $formname, 'yaml');
        $c              = 0;

        foreach ($substorage as $sub) {
            $file = File::get($sub);
            $yaml = Yaml::parse($file);

            if ($yaml['pw_id'] == $entry_id) {
                $c++;
            }
        }
        return $c;
    }

}
