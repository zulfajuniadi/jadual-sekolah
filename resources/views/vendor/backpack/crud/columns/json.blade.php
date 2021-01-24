@php
    $value = is_string($entry->{$column['name']}) ? 
                json_decode($entry->{$column['name']}, true) : 
                $entry->{$column['name']};
    $column['text'] = json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    $column['escaped'] = $column['escaped'] ?? true;
    $column['wrapper']['element'] = $column['wrapper']['element'] ?? 'pre';
@endphp

@includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_start')
    @if($column['escaped'])
        {{ $column['text'] }}
    @else
        {!! $column['text'] !!}
    @endif
@includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_end')
