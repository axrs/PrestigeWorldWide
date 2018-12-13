<?php

namespace Statamic\Addons\PrestigeWorldWide;

use Statamic\Contracts\Forms\Submission;
use Statamic\API\Form;
use Statamic\Extend\Tags;

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
     * The {{ prestige_world_wide:price }} tag
     *
     * @return string
     */
    public function price()
    {
        if (isset($this->context['pw_price'])) {
            return $this->context['pw_price'];
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
     * The {{ prestige_world_wide:form }} tag
     *
     * @return string
     */
    public function form()
    {
        if (isset($this->context['pw_form'])) {
            $form = Form::get($this->context['pw_form']);
            // dd($form);
            return $this->context['pw_form'];
        }
    }

    public $events = ['Form.submission.creating' => 'handle'];

    public function handle(Submission $submission)
    {
        return [
            'submission' => $submission,
            'errors' => []
        ];
    }
}
