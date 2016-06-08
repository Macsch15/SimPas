@extends('layout')

@section('title', 'Homepage')

@section('content')
    {{ Form::open(['url' => route('pastebin.store'), 'method' => 'post']) }}
    <div class="entity-head">
        Maximum length of content: {{ config('pastebin.max_content_length') }} characters

        <div class="pull-right">
            <ul>
                <li class="checkbox checkbox-success checkbox-circle">
                    {{ Form::checkbox('disable_syntax_highlighting', null, false, ['id' => 'disable_syntax_highlighting']) }}
                    {{ Form::label('disable_syntax_highlighting', 'Disable syntax highlighting') }}
                </li>
            </ul>
        </div>
    </div>
    <div class="row entity-row">
        <div class="col-md-10 col-md-offset-1">
            @if (count($errors))
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Error encountered!</strong> {{ $error }}
                    </div>
                @endforeach
            @endif

            {{ Form::text('title', null, [
                    'id' => 'input-title',
                    'class' => 'form-control input-lg',
                    'placeholder' => 'Enter title of the paste...'
                ])
            }}
            <br />
            {{ Form::textarea('content', null, [
                    'id' => 'input-content',
                    'class' => 'form-control input-lg',
                    'placeholder' => 'Enter content of the paste...'
                ])
            }}
            <br />

            {{ Form::button('Public', [
                    'name' => 'visibility[public]',
                    'class' => 'btn btn-primary btn-lg pull-right',
                    'type' => 'submit'
                ])
            }}
            {{ Form::button('<i class="fa fa-lock" aria-hidden="true"></i> Private', [
                    'name' => 'visibility[private]',
                    'class' => 'btn btn-success btn-lg pull-right',
                    'style' => 'margin-right: 10px',
                    'type' => 'submit'
                ])
            }}
            {{ Form::button('<span class="glyphicon glyphicon-cloud-upload" aria-hidden="true"></span> Save as...', [
                    'disabled',
                    'class' => 'btn btn-lg pull-right'
                ])
            }}
        </div>
    </div>
    {{ Form::close() }}
@endsection
