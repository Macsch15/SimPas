@macrodef('breadcrumb', array $breadcrumb_entities)
    <ol class="pull-left breadcrumb">
      <li class="active">Pastebin</li>
      @foreach ($breadcrumb_entities as $breadcrumb)
        <li><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a></li>
      @endforeach
    </ol>    
@endmacro
