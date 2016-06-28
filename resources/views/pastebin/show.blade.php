@extends('entity')

@section('title', $entity->title)
@section('entity_title', $entity->title)
@section('breadcrumb')
    {!! Breadcrumb::push($entity->title, route('pastebin.show', ['unique_id' => $entity->unique_id])) !!}
@endsection
@section('entity_content')
    <pre><code {!! $entity->disable_syntax_highlighting ? 'class="nohighlight"' : null !!}>{{ $entity->content }}</code></pre>
@endsection
