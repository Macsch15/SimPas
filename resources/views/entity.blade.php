@extends('layout')

@section('content')
    <div class="entity-head">
        <img class="user-avatar" width="20" src="//www.gravatar.com/avatar/{{ md5($entity->user['email']) }}.jpg" alt="Avatar" />
        {{ $entity->user['id'] != null ? $entity->user['name'] : 'Guest' }}
        <span title="{{ $entity->created_at }}" class="date">{{ $entity->created_at->diffForHumans() }}</span>

        @if ($entity->isEdited() === true)
            <span title="{{ $entity->updated_at }}" class="date">(Updated {{ $entity->updated_at->diffForHumans() }})</span>
        @endif

        <div class="pull-right">
            <ul>
                <li><i class="fa fa-lg fa-code" aria-hidden="true"></i></li>
                <li><i class="fa fa-lg fa-retweet" aria-hidden="true"></i></li>
                <li><span class="glyphicon glyphicon-cloud-download fa-lg"></span></li>
                <li class="favorite"><i class="fa fa-lg fa-heart" aria-hidden="true"></i></li>
                <li>
                    @if (Auth::check() and Auth::id() === $entity->user_id)
                        <a href="{{ route('pastebin.edit', ['unique_id' => $entity->unique_id]) }}">
                            <i class="fa fa-lg fa-pencil" aria-hidden="true"></i>
                        </a>
                    @endif
                </li>
                <li class="trash">
                    @if (Auth::check() and Auth::id() === $entity->user_id)
                        {{ Form::open(['url' => route('pastebin.delete', ['unique_id' => $entity->unique_id]), 'method' => 'delete']) }}
                            {{ Form::button('<i class="fa fa-lg fa-trash" aria-hidden="true"></i>', [
                                    'data-toggle' => 'confirmation',
                                    'data-placement' => 'bottom',
                                    'type' => 'submit',
                                    'class' => 'form-control'
                                ]) 
                            }}
                        {{ Form::close() }}
                    @endif
                </li>
            </ul>
        </div>
    </div>

    <div class="row entity-row">
        <div class="col-md-10 col-md-offset-1">
            <h2 class="entity-title"> 
                <span class="visibility">
                    <i class="fa {{ $entity->is_private ? 'fa-lock' : 'fa-unlock-alt' }}" aria-hidden="true"></i>
                </span>
                @yield('entity_title')
            </h2>
            @yield('entity_content')
        </div>
    </div>
@endsection
