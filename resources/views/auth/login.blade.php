@extends('layout')

@section('title', trans('auth.login_page_title'))

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('auth.login') }}</div>
                <div class="panel-body">
                    {{ Form::open(['url' => route('auth.login.form')]) }}
                        {{ Form::label('email', trans('auth.email')) }}
                        {{ Form::text('email', null, [
                            'class' => 'form-control input-lg',
                            'id' => 'email'
                        ]) }}

                        <br />

                        {{ Form::label('password', trans('auth.password')) }}
                        {{ Form::password('password', [
                            'class' => 'form-control input-lg',
                            'id' => 'password'
                        ]) }}

                        <div class="checkbox checkbox-success checkbox-circle">
                            {{ Form::checkbox('remember', null, false, ['id' => 'remember_me']) }}
                            {{ Form::label('remember_me', trans('auth.remember_me')) }}
                        </div>

                        {{ Form::button('<i class="fa fa-btn fa-sign-in"></i> Login', [
                            'class' => 'btn btn-primary',
                            'type' => 'submit'
                        ])}}
                    {{ Form::close() }}
                </div>

                  <ul class="list-group">
                    <li class="list-group-item pull-right">
                        <a href="{{ route('auth.password_reset.form') }}">{{ trans('auth.reset_password_link_title') }}</a>
                    </li>
                  </ul>
            </div>
        </div>
    </div>
@endsection
