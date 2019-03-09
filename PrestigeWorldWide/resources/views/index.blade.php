@extends('layout')

@section('content')

    <pwmanager inline-template>

        <div id="prestigeworldwide">

            <fieldset-builder fieldset-title="Prestige Worldwide"
                      save-url="{{ route('addons.pw_editor.store') }}">
            </fieldset-builder>

            {{-- <pw-fieldset-builder fieldset-title="Prestige Worldwide"
                      save-url="{{ route('addons.pw_editor.store') }}">
            </pw-fieldset-builder> --}}

        </div>

    </pwmanager>

@endsection
