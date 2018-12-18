## Setup and getting started
Prestige Worldwide requires a Statamic collection to function. So create a collection before or after installing this addon. Then go to the addons page in the control panel, click on Prestige Worldwide and select the collection you want to use for your events. Each entry in this collection will be an event.

After selecting a collection you'll see an extra tab called 'Event info' on the entry page of this collection. This tab allows you to add relevant info about this event. There's info about dates, costs, location and an organizer. You can also select a form to use for signups. And if you add a maximum number of participants then PW will check if the max number of participants is reached.

## Signup form
If you selected a form you will have to add the code for that form somewhere on the event page.

## Tags
You can use the following tags in your front-end to fully integrate PW in your front-end:

<table>
    <thead>
        <tr>
            <th colspan="3" align="left">Start date</th>
        </tr>
    </thead>
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

<table>
    <thead>
        <tr>
            <th colspan="3" align="left">End date</th>
        </tr>
    </thead>
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

<table>
    <thead>
        <tr>
            <th colspan="3" align="left">Costs</th>
        </tr>
    </thead>
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

<table>
    <thead>
        <tr>
            <th colspan="3" align="left">Location</th>
        </tr>
    </thead>
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

<table>
    <thead>
        <tr>
            <th colspan="3" align="left">Organizer</th>
        </tr>
    </thead>
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

<table>
    <thead>
        <tr>
            <th colspan="3" align="left">Maximum # of participants</th>
        </tr>
    </thead>
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

<table>
    <thead>
        <tr>
            <th colspan="3" align="left">If an event is full</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Get</td>
            <td>{{ prestige_world_wide:is_full }}</td>
            <td>Returns true</td>
        </tr>
    </tbody>
</table>

### Just give me all info
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

All info about the event is here. The html is simple, and you should be able to control the styling using the classes.
