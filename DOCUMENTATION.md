# About Prestige Worldwide
The idea of Prestige Worldwide isn't to be a full fledged event system within Statamic, but to add functionality to Statamic so you can use a collection for events.

## Setup
Prestige Worldwide requires __1 thing__: a Statamic collection. So create a collection before or after installing this addon. Then go to the addons page in the control panel, click on Prestige Worldwide and select the collection you want to use for your events. Each entry in this collection will be an event.

After selecting a collection you'll see an extra tab called 'Event info' on the entry page of this collection. This tab allows you to add relevant info about this event. There's info about dates, costs, location, an external url and an organizer.


You can also select which form to use for signups. And if you add a maximum number of participants PW will check if the max number of participants is reached. PW doesn't add things like titles or images, those are up to you.

* [Showing a list of events](#list)
* [Showing info on a detail page](#detail)
* [Using a signup form](#form)

## Showing a list of events <a id="list"></a>
Use these for a list of events. PW adds custom filters to a Statamic collection, the rest is pure Statamic. [More info about collections is here](https://docs.statamic.com/tags/collection).

### Get all future events <a id="future"></a>
See what we've done there?

    {{ collection:events filter="prestige_world_wide" remove="past" paginate="true" as="posts" limit="10" }}
        {{ posts scope="pw_start_date" }}
        {{ partial:block }}
        {{ /posts }}
        {{ partial:pagination }}
    {{ /collection:events }}

### Get all past events <a id="past"></a>
    {{ collection:events filter="prestige_world_wide" remove="future" paginate="true" as="posts" limit="10" }}
        {{ posts scope="pw_start_date" }}
        {{ partial:block }}
        {{ /posts }}
        {{ partial:pagination }}
    {{ /collection:events }}

## Detail page tags <a id="detail"></a>
The idea of PW is to give you the freedom to build your eventpage the way you want to. You can use the following tags:
* [Start date](#startdate)
* [End date](#enddate)
* [Cost](#cost)
* [Location](#location)
* [Organizer](#Organizer)
* [Number of signups](#participants)
* [Max number of participants](#maxparticipants)
* [Full or not?](#full)
* [Form or not?](#form)
* [I'm feeling lazy](#allinfo)

***

### Start date <a id="startdate"></a>
Start date is a required field. Otherwise there would never be an event.
<table>
    <tbody>
        <tr>
            <td>Get</td>
            <td>`{{ prestige_world_wide:start_date }}`</td>
            <td>Returns a date</td>
        </tr>
    </tbody>
</table>

**Example**   

    Start: {{ prestige_world_wide:start_date }}

### End date <a id="enddate"></a>
<table>
    <tbody>
        <tr>
            <td>Check</td>
            <td>`{{ if {prestige_world_wide:has_end_date} }}{{ /if }}`</td>
            <td>Returns true/false</td>
        </tr>
        <tr>
            <td>Get</td>
            <td>`{{ prestige_world_wide:end_date }}`</td>
            <td>Returns a date</td>
        </tr>
    </tbody>
</table>

**Example**   

    {{ if {prestige_world_wide:has_end_date} }}
        Ends: {{ prestige_world_wide:end_date }}
    {{ else }}
        There is no end date
    {{ /if }}

### Cost <a id="cost"></a>
<table>
    <tbody>
        <tr>
            <td>Get</td>
            <td>`{{ prestige_world_wide:costs }}`</td>
            <td>Returns a string</td>
        </tr>
    </tbody>
</table>

**Example**   

    {{ if {prestige_world_wide:costs} }}
        How much? {{ prestige_world_wide:costs }}
    {{ else }}
        This event is free
    {{ /if }}

### Location <a id="location"></a>
Maybe use this to geocode a google map?
<table>
    <tbody>
        <tr>
            <td>Get</td>
            <td>`{{ prestige_world_wide:location }}`</td>
            <td>Returns a string</td>
        </tr>
    </tbody>
</table>

**Example**   

    {{ if {prestige_world_wide:location} }}
        Location: {{ prestige_world_wide:location }}
    {{ else }}
        Catalina
    {{ /if }}

### Organizer <a id="organizer"></a>
<table>
    <tbody>
        <tr>
            <td>Get</td>
            <td>`{{ prestige_world_wide:organizer }}`</td>
            <td>Returns a string</td>
        </tr>
    </tbody>
</table>

**Example**   

    {{ if {prestige_world_wide:organizer} }}
        Who? {{ prestige_world_wide:organizer }}
    {{ else }}
        Prestige Worldwide!
    {{ /if }}

### Number of signups <a id="participants"></a>
<table>
    <tbody>
        <tr>
            <td>Get</td>
            <td>`{{ prestige_world_wide:participants }}`</td>
            <td>Returns a string</td>
        </tr>
    </tbody>
</table>

**Example**   

    {{ prestige_world_wide:participants }}

### Max number of participants <a id="participants"></a>
<table>
    <tbody>
        <tr>
            <td>Get</td>
            <td>`{{ prestige_world_wide:max_participants }}`</td>
            <td>Returns a string</td>
        </tr>
    </tbody>
</table>

**Example**   

    {{ if {prestige_world_wide:max_participants} }}
        This event is limited to: {{ prestige_world_wide:max_participants }}
    {{ else }}
        Just join us!
    {{ /if }}

### If the event is full <a id="full"></a>
<table>
    <tbody>
        <tr>
            <td>Check</td>
            <td>`{{ if {prestige_world_wide:is_full} }}{{ /if }}`</td>
            <td>Returns true/false</td>
        </tr>
    </tbody>
</table>

**Example**   

    {{ if {prestige_world_wide:is_full} }}
        It's full :-(
    {{ else }}
        It's not full! :-D
    {{ /if }}

### If people can sign up and a form was selected <a id="form"></a>
<table>
    <tbody>
        <tr>
            <td>Check</td>
            <td>`{{ if {prestige_world_wide:has_form} }}{{ /if }}`</td>
            <td>Returns true/false</td>
        </tr>
    </tbody>
</table>

**Example**   

    {{ if {prestige_world_wide:has_form} }}
        `form tag`
    {{ /if }}

### Just give me all info <a id="allinfo"></a>
Feeling lazy? Just add `{{ prestige_world_wide:info }}` in your front-end which will return the following html:

    <div class="pw_info">   
        <div class="pw_info__row pw_info__row--startdate">   
            <span class="pw_info__header pw_info__header--startdate">Start date:</span>   
            <span class="pw_info__data pw_info__data--startdate">2018-12-04 12:00</span>   
        </div>   
        <div class="pw_info__row pw_info__row--enddate">   
            <span class="pw_info__header pw_info__header--enddate">End date:</span>   
            <span class="pw_info__data pw_info__data--enddate">2018-12-05 12:00</span>   
        </div>   
        <div class="pw_info__row pw_info__row--cost">   
            <span class="pw_info__header pw_info__header--cost">Cost:</span>   
            <span class="pw_info__data pw_info__data--cost">200 Dollars</span>   
        </div>   
        <div class="pw_info__row pw_info__row--location">   
            <span class="pw_info__header pw_info__header--location">Location:</span>   
            <span class="pw_info__data pw_info__data--location">Catalina</span>   
        </div>   
        <div class="pw_info__row pw_info__row--participants">   
            <span class="pw_info__header pw_info__header--participants">Signups:</span>   
            <span class="pw_info__data pw_info__data--participants">50</span>   
        </div>   
        <div class="pw_info__row pw_info__row--maxparticipants">   
            <span class="pw_info__header pw_info__header--maxparticipants">Max # of participants:</span>   
            <span class="pw_info__data pw_info__data--maxparticipants">100</span>   
        </div>   
        <div class="pw_info__row pw_info__row--url">   
            <a href="https://www.urbandictionary.com/define.php?term=Prestige%20Worldwide" class="pw_info__url">Prestige Worldwide</a>   
        </div>   
        <div class="pw_info__row pw_info__row--full">   
            <span class="pw_info__header pw_info__header--full">Sorry, it's full!</span>   
        </div>   
    </div>

All event info is here, but there's no way of altering the output. The html is simple, and you should be able to control the styling using the classes. This tag doesn't output a signup form. If you wrap the form in `{{ if {prestige_world_wide:has_form} }}{{ if !{prestige_world_wide:is_full} }}` the form won't show when the event is full.

## Signup form <a id="form"></a>
If you selected a form you will have to add the code for that form on the event page. More info about adding a form is [in the Statamic docs here](https://docs.statamic.com/forms#main). You don't have to add any extra fields for PW, it does that by itself. __The only requirement is that the form must exist on the event page__. You can use 1 form for all events, or use 1 form for each event. It's up to you. Wrap the form in `{{ if {prestige_world_wide:has_form} }}{{ if !{prestige_world_wide:is_full} }}` to hide it when the event is full.
