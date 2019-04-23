@extends('layout')

@section('title', trans('pastebin.last_activity'))

@section('breadcrumb')
    {!! Breadcrumb::push(trans('pastebin.last_activity'), route('pastebin.activity')) !!}
@endsection

@section('content')
    <div class="row row-border">
        <div class="col-md-12 col-md-offset-2">
            <h4>{{ trans('pastebin.last_activity') }}</h5>

            @foreach ($entity as $record)
                {{ $record->title }}<br />
            @endforeach

            {{ $entity->links() }}
        </div>
    </div>
@endsection
