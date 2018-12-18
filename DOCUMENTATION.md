## Setup
Prestige Worldwide requires a Statamic collection to function. So create a collection before or after installing this addon. Then go to the addons page in the control panel, click on Prestige Worldwide and select the collection you want to use for your events. Each entry in this collection will be an event.

After selecting a collection you'll see an extra tab called 'Event info' on the entry page of this collection. This tab allows you to add relevant info about this event. There's info about dates, costs, location and an organizer. You can also select a form to use for signups. And if you add a maximum number of participants PW will check if the max number of participants is reached.

* [Using a signup form](#form)
* [Showing a list of events](#list)
* [Info for a detail page](#detail)

## Signup form <a id="form"></a>
If you selected a form you will have to add the code for that form somewhere on the event page. More info about that is [in the Statamic docs here](https://docs.statamic.com/forms#main).

## Showing a list of events <a id="list"></a>
Use these for a list of events. PW adds custom filters to a Statamic collection. [More info about collections is here](https://docs.statamic.com/tags/collection).
* [Get all future events](#future)
* [End all past events](#past)

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
The idea of PW is to give you the freedom build your eventpage the way you want to. You can use the following tags in your front-end to integrate PW in your front-end:
* [Start date](#startdate)
* [End date](#enddate)
* [Cost](#cost)
* [Location](#location)
* [Organizer](#Organizer)
* [Max number of participants](#participants)
* [Full or not?](#full)
* [I'm feeling lazy](#allinfo)

***

### Start date <a id="startdate"></a>
<table>
    <tbody>
        <tr>
            <td>Check</td>
            <td>{{ if {prestige_world_wide:has_start_date} }}{{ /if }}</td>
            <td>Returns true</td>
        </tr>
        <tr>
            <td>Get</td>
            <td>{{ prestige_world_wide:start_date }}</td>
            <td>Returns a date</td>
        </tr>
    </tbody>
</table>

**Example**   

    {{ if {prestige_world_wide:has_start_date} }}
        Start: {{ prestige_world_wide:start_date }}
    {{ else }}
        There is no start date
    {{ /if }}

### End date <a id="enddate"></a>
<table>
    <tbody>
        <tr>
            <td>Check</td>
            <td>{{ if {prestige_world_wide:has_end_date} }}{{ /if }}</td>
            <td>Returns true</td>
        </tr>
        <tr>
            <td>Get</td>
            <td>{{ prestige_world_wide:end_date }}</td>
            <td>Returns a date</td>
        </tr>
    </tbody>
</table>

**Example**   

    {{ if {prestige_world_wide:has_end_date} }}
        Start: {{ prestige_world_wide:end_date }}
    {{ else }}
        There is no end date
    {{ /if }}

### Cost <a id="cost"></a>
<table>
    <tbody>
        <tr>
            <td>Check</td>
            <td>{{ if {prestige_world_wide:has_costs} }}{{ /if }}</td>
            <td>Returns true</td>
        </tr>
        <tr>
            <td>Get</td>
            <td>{{ prestige_world_wide:costs }}</td>
            <td>Returns a number</td>
        </tr>
    </tbody>
</table>

**Example**   

    {{ if {prestige_world_wide:has_costs} }}
        Start: {{ prestige_world_wide:costs }}
    {{ else }}
        This event is free
    {{ /if }}

### Location  <a id="location"></a>
<table>
    <tbody>
        <tr>
            <td>Check</td>
            <td>{{ if {prestige_world_wide:has_location} }}{{ /if }}</td>
            <td>Returns true</td>
        </tr>
        <tr>
            <td>Get</td>
            <td>{{ prestige_world_wide:location }}</td>
            <td>Returns a string</td>
        </tr>
    </tbody>
</table>

**Example**   

    {{ if {prestige_world_wide:has_location} }}
        Start: {{ prestige_world_wide:location }}
    {{ else }}
        This event everywhere!
    {{ /if }}

### Organizer <a id="organizer"></a>
<table>
    <tbody>
        <tr>
            <td>Check</td>
            <td>{{ if {prestige_world_wide:has_organizer} }}{{ /if }}</td>
            <td>Returns true</td>
        </tr>
        <tr>
            <td>Get</td>
            <td>{{ prestige_world_wide:organizer }}</td>
            <td>Returns a string</td>
        </tr>
    </tbody>
</table>

**Example**   

    {{ if {prestige_world_wide:has_organizer} }}
        Start: {{ prestige_world_wide:organizer }}
    {{ else }}
        This event is owned by everybody!
    {{ /if }}

### Max number of participants <a id="participants"></a>
<table>
    <tbody>
        <tr>
            <td>Check</td>
            <td>{{ if {prestige_world_wide:has_max_participants} }}{{ /if }}</td>
            <td>Returns true</td>
        </tr>
        <tr>
            <td>Get</td>
            <td>{{ prestige_world_wide:max_participants }}</td>
            <td>Returns a string</td>
        </tr>
    </tbody>
</table>

**Example**   

    {{ if {prestige_world_wide:has_max_participants} }}
        Start: {{ prestige_world_wide:max_participants }}
    {{ else }}
        Just join us!
    {{ /if }}

### If the event is full <a id="full"></a>
<table>
    <tbody>
        <tr>
            <td>Get</td>
            <td>{{ prestige_world_wide:is_full }}</td>
            <td>Returns true</td>
        </tr>
    </tbody>
</table>

**Example**   

    {{ if {prestige_world_wide:is_full} }}
        It's full :-(
    {{ else }}
        It's not full! :-D
    {{ /if }}

### Just give me all info <a id="allinfo"></a>
Feeling lazy? Just add `{{ prestige_world_wide:info }}` in your front-end which will return the following html:

    <div class="pw_info">   
        <div class="pw_info__row">   
            <span class="pw_info__header">Start date:</span>   
            <span class="pw_info__data">2019-12-04 23:59</span>   
        </div>   
        <div class="pw_info__row">   
            <span class="pw_info__header">End date:</span>   
            <span class="pw_info__data">2018-12-14 12:12</span>   
        </div>   
        <div class="pw_info__row">   
            <span class="pw_info__header">Cost:</span>   
            <span class="pw_info__data">200</span>   
        </div>   
        <div class="pw_info__row">   
            <span class="pw_info__header">Location:</span>   
            <span class="pw_info__data">Kielzog Theater</span>   
        </div>   
        <div class="pw_info__row">   
            <a href="https://kielzog.nl/" class="pw_info__url">Het Kielzog</a>   
        </div>   
    </div>

All event info is here, but there's no way of altering the output. The html is simple, and you should be able to control the styling using the classes.
