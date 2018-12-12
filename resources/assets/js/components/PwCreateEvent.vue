<template>

    <div class="flex items-center mb-3">
        <h1 class="w-full text-center mb-2 md:mb-0 md:text-left md:w-auto md:flex-1">Add new event</h1>

        <div class="controls flex flex-wrap items-center w-full lg:w-auto justify-center">
            <div class="btn-group btn-group-primary my-1">
                <button type="button" class="btn btn-primary" v-on:click="saveEvent">Save</button>
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a id="publish-continue">Save &amp; Continue</a>
                    </li>
                    <li>
                        <a>Save &amp; Add Another</a>
                    </li>
                </ul>
            </div>
        </div>

    </div>

    <div class="card flush">

        <div class="form-group">
            <label class="block">
                Event Title
            </label>
            <input type="text" class="form-control mb-2" autofocus="autofocus" v-model="eventTitle">
        </div>

        <div class="form-group">

            <div class="row">

                <div class="col-md-2">

                    <pwdatefieldtype title="Start date"></pwdatefieldtype>

                </div>

                <div class="col-md-2">

                    <pwdatefieldtype title="End date"></pwdatefieldtype>

                </div>

            </div>

        </div>

        <div class="form-group">
            <label class="block">
                Location
            </label>
            <input type="text" class="form-control mb-2" autofocus="autofocus" v-model="eventLocation">
            <small class="help-block">
                Lorem ipsum
            </small>
        </div>

    </div>

</template>

<script>
// import PwDateFieldType from './PwDateFieldType.vue';
export default {

    components: {
        'pwdatefieldtype': require('./PwDateFieldType.vue'),
    },

    props: [],

    data: function() {
        return {
            eventTitle: '',
        }
    },

    methods: {
        saveEvent: function() {
            if (this.eventTitle !== '') {
                this.$http.post(
                    cp_url("addons/prestige-world-wide/store"), {
                        event_title: this.eventTitle
                    },
                    function(res) {
                        location.href = cp_url('addons/prestige-world-wide/edit/') + res.title
                    }
                )
            } else {
                this.$dispatch("setFlashError", 'Uh oh! Enter a title for this event')
            }
        }
    },

    ready: function() {}
}

</script>
