@extends('layout')

@section('content')

    <pwmanager inline-template>

        <div id="prestigeworldwide">

            <fieldset-builder fieldset-title="Prestige Worldwide"
                      save-url="{{ route('addons.pw_editor.edit') }}">
            </fieldset-builder>

        </div>

    </pwmanager>

@endsection
