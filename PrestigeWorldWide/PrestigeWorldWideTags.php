<?php

namespace Statamic\Addons\PrestigeWorldWide;

use Carbon\Carbon;
use Recurr\Transformer;
use Spatie\CalendarLinks\Link;
use Statamic\API\Config;
use Statamic\API\Form;
use Statamic\API\Page;
use Statamic\API\Str;
use Statamic\API\URL;
use Statamic\Extend\Collection;
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

    private function extractStartDate(): callable
    {
        return function ($event) {
            $date = $event->get('pw_start_date');
            return (new \DateTime($date));
        };
    }

    private function year(): callable
    {
        return function ($dateTime) {
            return $dateTime->format('Y');
        };
    }

    public function archive()
    {
        $locale = $this->get('locale', site_locale());
        $from = $this->get(['from', 'folder', 'url'], URL::getCurrent());
        $from = Str::ensureLeft($from, '/');
        $from = URL::getDefaultUri($locale, $from);
        $collection = Page::whereUri($from)->entries();
        $years = $collection->map($this->extractStartDate())
            ->map($this->year())
            ->unique()
            ->sort()
            ->reverse()
            ->map(function ($year) {
                return ['year' => $year];
            });
        return $this->parseLoop($years);
    }

    /**
     * The {{ prestige_world_wide:start_date }} tag
     *
     * @return string
     */
    private function startDate()
    {
        if (isset($this->context['pw_start_date'])) {
            return $this->context['pw_start_date'];
        } else  {
            return NULL;
        }
    }

    /**
     * The {{ prestige_world_wide:end_date }} tag
     *
     * @return string
     */
    private function endDate()
    {
        if (isset($this->context['pw_end_date'])) {
            return $this->context['pw_end_date'];
        } else  {
            return NULL;
        }
    }

    /**
     * The {{ prestige_world_wide:recurring }} tag
     *
     * @return array
     */
    public function recurring()
    {

        if ($this->context['pw_recurring'] == true) {

            if ($this->context['pw_recurring_frequency'] != 'CUSTOM') {

                $timezone  = $this->context['settings']['system']['timezone'];
                $startdate = new \DateTime($this->startDate());
                $enddate = new \DateTime($this->endDate());

                if (isset($this->context['pw_recurring_ends'])) {
                    $ends = $this->context['pw_recurring_ends'];
                }
                if (isset($this->context['pw_recurring_frequency'])) {
                    $frequency = $this->context['pw_recurring_frequency'];
                }
                if (isset($this->context['pw_recurring_count'])) {
                    $count = $this->context['pw_recurring_count'];
                }
                if (isset($this->context['pw_recurring_until'])) {
                    $until = new \DateTime($this->context['pw_recurring_until']);
                }
                if (isset($this->context['pw_recurring_interval'])) {
                    $interval = $this->context['pw_recurring_interval'];
                }

                $transformer = new Transformer\ArrayTransformer();

                if ($ends == 'after') {

                    $rule = (new \Recurr\Rule)
                        ->setStartDate($startdate)
                        ->setEndDate($enddate)
                        ->setTimezone($timezone)
                        ->setCount($count)
                        ->setInterval($interval)
                        ->setFreq($frequency);

                } else {

                    $rule = (new \Recurr\Rule)
                        ->setStartDate($startdate)
                        ->setEndDate($enddate)
                        ->setTimezone($timezone)
                        ->setFreq($frequency)
                        ->setInterval($interval)
                        ->setUntil($until);

                }

                $ruledates = $transformer->transform($rule);
                $dates = [];

                foreach ($ruledates as $date) {

                    $startdate = $date->getStart();
                    $carbon_start = $this->dtCarbon($startdate);
                    $enddate = $date->getEnd();
                    $carbon_end = $this->dtCarbon($enddate);

                    $item = array(
                        'start' => $carbon_start->toDateTimeString(),
                        'end' => $carbon_end->toDateTimeString()
                    );
                    $dates[] = $item;

                }
                return $this->parseLoop($dates);

            } else {

                $customdates = $this->context['pw_recurring_manual'];
                $dates = [];

                // Add the start & end date of the current event
                $dates[] = array(
                    'start' => $this->startDate(),
                    'end' => $this->endDate()
                );

                foreach ($customdates as $date) {

                    $startdate = $date['pw_recurring_manual_start'];
                    $enddate = $date['pw_recurring_manual_end'];

                    $item = array(
                        'start' => $startdate,
                        'end' => $enddate
                    );
                    $dates[] = $item;

                }
                return $this->parseLoop($dates);

            }
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
     * The {{ prestige_world_wide:icalendar }} tag
     *
     * @return string
     */
    public function icalendar()
    {
        return $this->calendarLink('ics');
    }

    /**
     * The {{ prestige_world_wide:google_calendar }} tag
     *
     * @return string
     */
    public function googleCalendar()
    {
        return $this->calendarLink('google');
    }

    /**
     * Return a link
     *
     * @return string
     */
    private function calendarLink($type)
    {
        // Use the system or the event timezone
        if ($this->getConfig('event_timezone') == false) {
            $tz = new \DateTimeZone(Config::get('system.timezone'));
        } else {
            $tz = new \DateTimeZone($this->context['pw_timezone']);
        }

        // Format the start & end dates
        $from = \DateTime::createFromFormat('Y-m-d H:i', $this->startDate(), $tz);
        $to = \DateTime::createFromFormat('Y-m-d H:i', $this->endDate(), $tz);

        // Get the description
        $description = isset($this->context['pw_description']) ? $this->context['pw_description'] : "";

        // Add an optional location
        if (isset($this->context['pw_location'])) {
            $link = Link::create(urlencode($this->context['title']), $from, $to)
            ->description($description)
            ->address($this->context['pw_location']);
        } else {
            $link = Link::create(urlencode($this->context['title']), $from, $to)
            ->description($description);
        }

        if ($type == 'ics') {
            return $link->ics();
        } elseif ($type == 'google') {
            return $link->google();
        }
    }

    /**
     * Transform a datetime object to Carbon
     *
     * @return string
     */
    private function dtCarbon($date)
    {
        return Carbon::instance($date);
    }

    /**
     * The {{ prestige_world_wide:has_form }} tag
     *
     * @return true/false
     */
    public function hasForm()
    {
        if (isset($this->context['pw_has_form']) && isset($this->context['pw_form'])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * The {{ prestige_world_wide:max_participants }} tag
     *
     * @return string
     */
    private function maxParticipants()
    {
        if (isset($this->context['pw_max_participants'])) {
            return $this->context['pw_max_participants'];
        }
    }

    /**
     * The {{ prestige_world_wide:is_full }} tag
     *
     * @return true/false
     */
    public function isFull()
    {
        if ($this->hasForm()) {

            $entry_id       = $this->context['id'];
            $pw_formname    = $this->context['pw_form'];
            $pw_form        = Form::all();
            $pw_submissions = $this->submissions($pw_formname, $entry_id);
            $pw_max         = $this->maxParticipants();

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
            return false;
        }
    }

    /**
     * Return the number of submissions for a form connected to an entry
     *
     * @return mixed
     */
    private function submissions($formname, $entry_id)
    {
        // $substorage = Folder::getFilesByType('/site/storage/forms/' . $formname, 'yaml');
        // $c = 0;
        //
        // foreach ($substorage as $sub) {
        //     $file = File::get($sub);
        //     $yaml = Yaml::parse($file);
        //
        //     if ($yaml['pw_id'] == $entry_id) {
        //         $c++;
        //     }
        // }
        // return $c;
    }

}
