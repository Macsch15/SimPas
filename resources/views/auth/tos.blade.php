@extends('layout')

@section('title', trans('auth.tos_title'))

@section('content')
    <div class="row row-border">
        <div class="col-md-12 col-md-offset-2">
            {!! trans('rules.tos', [
                'site_url' => config('app.url'),
                'site_name' => config('app.name')
            ]) !!}
        </div>
    </div>
@endsection
