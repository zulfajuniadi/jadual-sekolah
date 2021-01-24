@php
	$column['key'] = $column['key'] ?? $column['name'];
    $column['text'] = $column['options'][data_get($entry, $column['key'])] ?? '';
    $column['escaped'] = $column['escaped'] ?? true;
@endphp

<span>
    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_start')
        @if($column['escaped'])
            {{ $column['text'] }}
        @else
            {!! $column['text'] !!}
        @endif
    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_end')
</span>
