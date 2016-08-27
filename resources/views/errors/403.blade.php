@extends('layout')

@section('title', trans('pastebin.error_encountered_title'))

@section('content')
    <div class="row row-border">
        <div class="col-md-8 offset-md-2">
            <div class="error">
                <div class="error-warning">
                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                </div>

                <div class="error-message">
                    {{ trans('auth.unauthorized_action') }}
                </div>

                <h5>{{ trans('auth.unauthorized_action_message') }}</h5>

                <a href="{{ url('/') }}" class="btn btn-outline-primary">
                    <i class="fa fa-undo" aria-hidden="true"></i> {{ trans('pastebin.go_to_index') }}
                </a>
            </div>
        </div>
    </div>
@endsection
