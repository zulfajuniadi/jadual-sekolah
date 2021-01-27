@if ($crud->hasAccess('schedule'))
    <a href="{{ url($crud->route.'/'.$entry->getKey().'/schedule') }}" class="btn btn-sm btn-link"><i class="la la-table"></i> Jadual</a>
@endif