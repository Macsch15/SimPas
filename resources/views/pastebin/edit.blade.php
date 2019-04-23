@extends('entity')

@section('title', trans('pastebin.editing_title', ['title' => $entity->title]))
@section('entity_title', $entity->title)
@section('breadcrumb')
    {!! Breadcrumb::push($entity->title, route('pastebin.show', ['unique_id' => $entity->unique_id])) !!}
    {!! Breadcrumb::push(trans('pastebin.breadcrumb_edit'), route('pastebin.edit', ['unique_id' => $entity->unique_id])) !!}
@endsection
@section('entity_content')
    <form action="{{ route('pastebin.update', ['unique_id' => $uniqueId]) }}" method="POST">
        <div class="form-group">
            <input type="text" name="title" value="{{ old('title', $entity->title) }}" id="input-title" class="form-control input-lg" placeholder="{{ trans('pastebin.pastebin_title_placeholder') }}" />
        </div>

        <div class="form-group">
            <textarea name="content" rows="10" id="input-content" class="form-control input-lg" placeholder="{{ trans('pastebin.pastebin_content_placeholder') }}">{{ old('content', $entity->content) }}</textarea>
        </div>

        @csrf
        @method('PATCH')

        <button type="submit" class="btn btn-success btn-lg pull-right ml-1 mt-1"><i class="fa fa-check" aria-hidden="true"></i> {{ trans('pastebin.edit_button') }}</button>
        <a class="btn btn-danger btn-lg mt-1 pull-right" href="{{ route('pastebin.show', ['unique_id' => $uniqueId]) }}">
            <i class="fa fa-times" aria-hidden="true"></i> {{ trans('pastebin.edit_abort_button') }}
        </a>
    </form>
@endsection
