@extends(backpack_view('layouts.top_left'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => backpack_url('dashboard'),
    $crud->entity_name_plural => url($crud->route),
    'Jadual' => false,
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
  <section class="container-fluid">
    <h2>
        <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
        <small>{!! $crud->getSubheading() ?? 'Jadual '.$crud->entity_name !!}.</small>

        @if ($crud->hasAccess('list'))
          <small><a href="{{ url($crud->route) }}" class="hidden-print font-sm"><i class="fa fa-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
        @endif
    </h2>
  </section>
@endsection

@section('content')

<form
enctype="multipart/form-data"
action="{{ url($crud->route.'/'.$entry->getKey()).'/schedule/import' }}"
>
@csrf
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="card">
        <div class="card-body row">
          <div class="form-group col-sm-12 required">    
            <label>Sila Pilih Jadual</label>
            <br>
            <input type="file" name="jadual">
          </div>
        </div>
      </div>
      </div>
      <div class="form-group col-sm-12">    
        
        <button formmethod="POST" class="btn btn-success">
          <span class="la la-upload" role="presentation" aria-hidden="true"></span> &nbsp;
          <span data-value="save_and_back">Muat naik jadual</span>
        </button>

        <a class="btn btn-info" href="schedule/get">
          <span class="la la-download" role="presentation" aria-hidden="true"></span> &nbsp;
          <span data-value="save_and_back">Muat turun contoh</span>
        </a>
      </div>
  </div>
</form>
<hr>

@endsection