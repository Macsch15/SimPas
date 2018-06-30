@extends('layout')

@section('title', trans('pastebin.index_page_title'))

@section('content')
    <form action="{{ route('pastebin.store') }}" method="POST">
        <div class="entity-head">
            {{ trans_choice('pastebin.max_length', config('pastebin.max_content_length'), [
                'length' => config('pastebin.max_content_length')
            ]) }}

            <div class="pull-right">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="disable_syntax_highlighting">
                  @lang('pastebin.disable_syntax_highlighting')
                </label>
              </div>
            </div>
        </div>
        <div class="row entity-row">
            <div class="col-md-12 col-md-offset-1">
                <div class="form-group row{{ $errors->has('title') ? ' has-warning' : '' }}">
                    <div class="col-sm-12">
                        <input type="text" name="title" class="form-control {{ !$errors->has('title') ?: 'form-control-warning' }}" id="input-title" placeholder="@lang('pastebin.pastebin_title_placeholder')">

                        @if ($errors->has('title'))
                            <div class="form-control-feedback">
                                {{ $errors->first('title') }}
                            </div>
                        @endif                        
                    </div>
                </div>
                <div class="form-group row{{ $errors->has('content') ? ' has-warning' : '' }}">
                    <div class="col-sm-12">
                        <textarea name="content" id="input-content" class="form-control {{ !$errors->has('title') ?: 'form-control-warning' }}" rows="12" placeholder="@lang('pastebin.pastebin_content_placeholder')"></textarea>

                        @if ($errors->has('content'))
                            <div class="form-control-feedback">
                                {{ $errors->first('content') }}
                            </div>
                        @endif                          
                    </div>
                </div>

                <button type="submit" value="@lang('pastebin.pastebin_button_public')" name="visibility[public]" class="btn btn-primary btn-lg pull-right">@lang('pastebin.pastebin_button_public')</button>
                <button type="submit" value="@lang('pastebin.pastebin_button_private')" name="visibility[private]" class="btn btn-success btn-lg mr-1 pull-right"><i class="fa fa-lock" aria-hidden="true"></i> {{ Auth::check() ? __('pastebin.pastebin_button_private') : 'Not listed' }}</button>

                @if (Auth::guest())
                    <div class="pull-right btn btn-lg">
                        <i data-toggle="tooltip" data-placement="top" title="Only logged in users can create private pastebin" class="fa fa-question-circle" aria-hidden="true"></i>                   
                    </div>
                @endif

                <button type="submit" disabled value="@lang('pastebin.pastebin_button_public')" class="btn btn-lg btn-link-trasparent pull-right"><i class="fa fa-cloud-upload" aria-hidden="true"></i> @lang('pastebin.save_as')</button>
            </div>
        </div>

        @csrf
        @method('post')
    </form>
@endsection
