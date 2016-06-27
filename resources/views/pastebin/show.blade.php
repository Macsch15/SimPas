@extends('entity')
@include('macros.breadcrumb')

@section('title', $entity->title)
@section('entity_title', $entity->title)
@section('breadcrumb')
    @macro('breadcrumb', ['add' => ['url' => route('pastebin.show', ['unique_id' => $entity->unique_id]), 'title' => $entity->title]])
@endsection
@section('entity_content')
    <pre><code {!! $entity->disable_syntax_highlighting ? 'class="nohighlight"' : null !!}>{{ $entity->content }}</code></pre>
@endsection
