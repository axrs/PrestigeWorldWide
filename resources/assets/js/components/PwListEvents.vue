<template>

    <div class="flex items-center mb-3">
        <h1 class="w-full text-center mb-2 md:mb-0 md:text-left md:w-auto md:flex-1">Events</h1>
        <a href="{{ route('addons.events.create') }}" class="btn btn-primary">New Event</a>
    </div>

    <div class="card flush">

        <div class="dossier-table-wrapper">

            <table class="dossier">
                
                <tbody>

                    <tr v-for="event in events">
                        <td class="cell-title first-cell">
                            <span class="column-label">Title</span>
                            <a href="{{ route('addons.events.edit', 'Test event') }}" title="Edit event title">
                                Event title
                            </a>
                        </td>
                        <td class="cell-slug">
                            <span class="column-label">Start date</span>
                            18 November 2018 - 19:30
                        </td>
                        <td class="cell-slug">
                            <span class="column-label">End date</span>
                            18 November 2018 - 19:30
                        </td>
                        <td class="cell-slug">
                            <span class="column-label">Location</span>
                            Groningen
                        </td>
                        <td class="column-actions">
                            <div class="btn-group action-more">
                                <button type="button" class="btn-more dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon icon-dots-three-vertical"></i> </button>
                                    <ul class="dropdown-menu">
                                        <li class="warning">
                                            <a href="#" title="Delete this menu">Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</template>

<script>

export default {

    props: [],

    data: function() {
        return {
            events: []
        }
    },

    methods: {
    },

    ready: function() {
    }
}

</script>
