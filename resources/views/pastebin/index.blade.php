@extends('layout')

@section('title', trans('pastebin.index_page_title'))

@section('content')
    {{ Form::open(['url' => route('pastebin.store'), 'method' => 'post']) }}
        <div class="entity-head">
            {{ trans_choice('pastebin.max_length', config('pastebin.max_content_length'), [
                'length' => config('pastebin.max_content_length')
            ]) }}

            <div class="pull-right">
                {{ Form::customCheckbox('disable_syntax_highlighting', trans('pastebin.disable_syntax_highlighting')) }}
            </div>
        </div>
        <div class="row entity-row">
            <div class="col-md-12 col-md-offset-1">
                <div class="form-group row{{ $errors->has('title') ? ' has-warning' : '' }}">
                    <div class="col-sm-12">
                        {{ Form::text('title', null, [
                                'id' => 'input-title',
                                'class' => 'form-control' . ($errors->has('title') ? ' form-control-warning' : ''),
                                'placeholder' => trans('pastebin.pastebin_title_placeholder')
                            ])
                        }}

                        @if ($errors->has('title'))
                            <div class="form-control-feedback">
                                {{ $errors->first('title') }}
                            </div>
                        @endif                        
                    </div>
                </div>
                <div class="form-group row{{ $errors->has('content') ? ' has-warning' : '' }}">
                    <div class="col-sm-12">
                        {{ Form::textarea('content', null, [
                                'id' => 'input-content',
                                'class' => 'form-control' . ($errors->has('content') ? ' form-control-warning' : ''),
                                'placeholder' => trans('pastebin.pastebin_content_placeholder')
                            ])
                        }}

                        @if ($errors->has('content'))
                            <div class="form-control-feedback">
                                {{ $errors->first('content') }}
                            </div>
                        @endif                          
                    </div>
                </div>

                {{ Form::button(trans('pastebin.pastebin_button_public'), [
                        'name' => 'visibility[public]',
                        'value' => trans('pastebin.pastebin_button_public'),
                        'class' => 'btn btn-primary btn-lg pull-right',
                        'type' => 'submit'
                    ])
                }}
                {{ Form::button('<i class="fa fa-lock" aria-hidden="true"></i> ' . (Auth::check() ? trans('pastebin.pastebin_button_private') : 'Not listed'), [
                        'name' => 'visibility[private]',
                        'value' => trans('pastebin.pastebin_button_private'),
                        'class' => 'btn btn-success btn-lg pull-right',
                        'style' => 'margin-right: 10px',
                        'type' => 'submit'
                    ])
                }}

                @if (Auth::guest())
                    <div class="pull-right btn btn-lg">
                        <i data-toggle="tooltip" data-placement="top" title="Only logged in users can create private pastebin" class="fa fa-question-circle" aria-hidden="true"></i>                   
                    </div>
                @endif

                {{ Form::button('<i class="fa fa-cloud-upload" aria-hidden="true"></i> ' . trans('pastebin.save_as'), [
                        'disabled',
                        'class' => 'btn btn-lg btn-link-trasparent pull-right'
                    ])
                }}
            </div>
        </div>
    {{ Form::close() }}
@endsection
