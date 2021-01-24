{{-- relationship_count (works for n-n relationships) --}}
@php
   $column['text'] = data_get($entry, $column['name'])->count();
   $column['prefix'] = $column['prefix'] ?? '';
   $column['suffix'] = $column['suffix'] ?? '  items';
   $column['text'] = $column['prefix'].$column['text'].$column['suffix'];
@endphp

<span>
    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_start')
        {{ $column['text'] }}
    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_end')
</span>