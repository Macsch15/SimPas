@extends('layout')

@section('title', trans('auth.register'))

@section('content')
    <div class="row row-border">
        <div class="col-md-12 col-md-offset-2">
            <h4>{{ trans('auth.register') }}</h5>

            {{ Form::open(['url' => route('auth.register')]) }}
                <div class="form-group row{{ $errors->has('name') ? ' has-warning' : '' }}">
                    {{ Form::label('name', trans('auth.name'), [
                        'class' => 'col-sm-2 col-form-label'
                    ]) }}
                    <div class="col-sm-10">
                        {{ Form::text('name', null, [
                            'class' => 'form-control' . ($errors->has('name') ? ' form-control-warning' : ''),
                            'placeholder' => trans('auth.name_example_placeholder'),
                            'id' => 'name'
                        ]) }}

                        @if ($errors->has('name'))
                            <div class="form-control-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group row{{ $errors->has('email') ? ' has-warning' : '' }}">
                    {{ Form::label('email', trans('auth.email'), [
                        'class' => 'col-sm-2 col-form-label'
                    ]) }}
                    <div class="col-sm-10">
                        {{ Form::email('email', null, [
                            'class' => 'form-control' . ($errors->has('email') ? ' form-control-warning' : ''),
                            'placeholder' => trans('pastebin.email_example_placeholder'),
                            'id' => 'email'
                        ]) }}

                        @if ($errors->has('email'))
                            <div class="form-control-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group row{{ $errors->has('password') ? ' has-warning' : '' }}">
                    {{ Form::label('password', trans('auth.password'), [
                        'class' => 'col-sm-2 col-form-label'
                    ]) }}
                    <div class="col-sm-10">
                        {{ Form::password('password', [
                            'class' => 'form-control' . ($errors->has('password') ? ' form-control-warning' : ''),
                            'placeholder' => '************',
                            'id' => 'password'
                        ]) }}

                        <p class="form-text text-muted">
                            {{ trans('auth.password_help_text') }}
                        </p>

                        @if ($errors->has('password'))
                            <div class="form-control-feedback">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group row{{ $errors->has('password_confirmation') ? ' has-warning' : '' }}">
                    {{ Form::label('password_confirmation', trans('auth.password_confirmation'), [
                        'class' => 'col-sm-2 col-form-label'
                    ]) }}
                    <div class="col-sm-10">
                        {{ Form::password('password_confirmation', [
                            'class' => 'form-control' . ($errors->has('password_confirmation') ? ' form-control-warning' : ''),
                            'placeholder' => '************',
                            'id' => 'password_confirmation'
                        ]) }}

                        @if ($errors->has('password_confirmation'))
                            <div class="form-control-feedback">
                                {{ $errors->first('password_confirmation') }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group row{{ $errors->has('tos') ? ' has-warning' : '' }}">
                    <label class="col-sm-2"></label>
                    <div class="col-sm-10">
                        <div class="form-check">
                            {{ Form::customCheckbox('tos', trans('auth.tos', ['tos_url' => route('auth.tos')])) }}

                            @if ($errors->has('tos'))
                                <div class="form-control-feedback">
                                    {{ $errors->first('tos') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>                

                <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                        {{ Form::button('<i class="fa fa-user-plus" aria-hidden="true"></i> ' . trans('auth.register'), [
                            'class' => 'btn btn-outline-primary',
                            'type' => 'submit'
                        ])}}

                        <a class="btn btn-outline-secondary" href="{{ route('auth.login.form') }}">
                            <i class="fa fa-key" aria-hidden="true"></i> {{ trans('auth.login') }}
                        </a>                        
                    </div>
                </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
