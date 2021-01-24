<!-- view field -->
@include('crud::fields.inc.wrapper_start')
  @include($field['view'], ['crud' => $crud, 'entry' => $entry ?? null, 'field' => $field])
@include('crud::fields.inc.wrapper_end')
