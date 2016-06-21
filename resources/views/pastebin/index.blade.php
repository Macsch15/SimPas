@extends('layout')

@section('title', trans('pastebin.index_page_title'))

@section('content')
    {{ Form::open(['url' => route('pastebin.store'), 'method' => 'post']) }}
        <div class="entity-head">
            {{ trans_choice('pastebin.max_length', config('pastebin.max_content_length'), ['length' => config('pastebin.max_content_length')]) }}

            <div class="pull-right">
                <ul>
                    <li class="checkbox checkbox-success checkbox-circle">
                        {{ Form::checkbox('disable_syntax_highlighting', null, false, ['id' => 'disable_syntax_highlighting']) }}
                        {{ Form::label('disable_syntax_highlighting', trans('pastebin.disable_syntax_highlighting')) }}
                    </li>
                </ul>
            </div>
        </div>
        <div class="row entity-row">
            <div class="col-md-10 col-md-offset-1">
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

                {{ Form::button(trans('pastebin.pastebin_button_public'), [
                        'name' => 'visibility[public]',
                        'value' => trans('pastebin.pastebin_button_public'),
                        'class' => 'btn btn-primary btn-lg pull-right',
                        'type' => 'submit'
                    ])
                }}
                {{ Form::button('<i class="fa fa-lock" aria-hidden="true"></i> ' . trans('pastebin.pastebin_button_private'), [
                        'name' => 'visibility[private]',
                        'value' => trans('pastebin.pastebin_button_private'),
                        'class' => 'btn btn-success btn-lg pull-right',
                        'style' => 'margin-right: 10px',
                        'type' => 'submit'
                    ])
                }}
                {{ Form::button('<span class="glyphicon glyphicon-cloud-upload" aria-hidden="true"></span> ' . trans('pastebin.save_as'), [
                        'disabled',
                        'class' => 'btn btn-lg pull-right'
                    ])
                }}
            </div>
        </div>
    {{ Form::close() }}
@endsection
