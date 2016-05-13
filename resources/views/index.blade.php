@extends('layout')

@section('title', 'Homepage')

@section('content')
    <div class="entity-head">
        Maximum length of content: 50 000 characters

        <div class="pull-right">
            <ul>
                <li><input type="checkbox"> Disable syntax highlighting</li>
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

            {{ Form::open(['url' => route('pastebin.store'), 'method' => 'post']) }}
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

                {{ Form::submit('Public', [
                        'name' => 'visibility[public]',
                        'class' => 'btn btn-primary btn-lg pull-right'
                    ])
                }}
                {{ Form::submit('Private', [
                        'name' => 'visibility[private]',
                        'class' => 'btn btn-success btn-lg pull-right',
                        'style' => 'margin-right: 10px'
                    ])
                }}
                {{ Form::button('<span class="glyphicon glyphicon-cloud-upload"></span> Save as...', [
                        'disabled',
                        'class' => 'btn btn-lg pull-right'
                    ])
                }}
            {{ Form::close() }}
        </div>
    </div>
@endsection
