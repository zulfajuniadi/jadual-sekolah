@php
    $value = data_get($entry, $column['name']);
@endphp
<img src="/avatar/{{$entry->id}}.svg" class="table-avatar" alt="">
{{$value}}