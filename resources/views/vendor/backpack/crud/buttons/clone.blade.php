@if ($crud->hasAccess('clone'))
  <a href="{{ url($crud->route.'/'.$entry->getKey().'/clone') }}" onclick="return confirm('Are you sure you want to duplicate this entry?')" class="btn btn-sm btn-link" data-button-type="clone"><i class="la la-copy"></i> Duplicate</a>
@endif