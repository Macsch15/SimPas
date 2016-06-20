@extends('entity')

@section('title', trans('pastebin.editing_title', ['title' => $entity->title]))
@section('entity_title', $entity->title)
@section('entity_content')
    {{ Form::model($entity, ['route' => ['pastebin.update', $unique_id], 'method' => 'patch']) }}
        {{ Form::text('title', null, [
                'id' => 'input-title',
                'class' => 'form-control input-lg',
                'placeholder' => trans('pastebin.pastebin_title_placeholder')
            ])
        }}
        <br />
        {{ Form::textarea('content', null, [
                'id' => 'input-content',
                'class' => 'form-control input-lg',
                'placeholder' => trans('pastebin.pastebin_content_placeholder')
            ])
        }}
        <br />
        {{ Form::button('<i class="fa fa-check" aria-hidden="true"></i> ' . trans('pastebin.edit_button'), [
                'class' => 'btn btn-success btn-lg pull-right',
                'style' => 'margin-left: 10px',
                'type' => 'submit'
            ])
        }}

        <a class="btn btn-danger btn-lg pull-right" href="{{ route('pastebin.show', ['unique_id' => $unique_id]) }}">
            <i class="fa fa-times" aria-hidden="true"></i> {{ trans('pastebin.edit_abort_button') }}
        </a>
    {{ Form::close() }}
@endsection
