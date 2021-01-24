@php
    $value = data_get($entry, $column['name']);
@endphp
<div class="d-flex">
    <div>
        <img src="/avatar/{{$entry->id}}.svg" class="table-avatar" alt="">
    </div>
    <div>
        {{$value}} <br>
        <i class="la la-star" style="color: gold"></i> {{number_format($entry->points, 0, '.', ',')}}
    </div>
</div>