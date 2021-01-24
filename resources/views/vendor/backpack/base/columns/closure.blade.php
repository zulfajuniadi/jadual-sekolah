{{-- closure function column type --}}
@php
    $column['escaped'] = $column['escaped'] ?? false;
    $column['text'] = $column['function']($entry);
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
