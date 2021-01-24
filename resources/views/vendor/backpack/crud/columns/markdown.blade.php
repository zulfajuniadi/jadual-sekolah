@php
    $column['text'] = Illuminate\Mail\Markdown::parse($entry->{$column['name']} ?? '');
    $column['escaped'] = $column['escaped'] ?? false;
@endphp

@includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_start')
    @if($column['escaped'])
        {{ $column['text'] }}
    @else
        {!! $column['text'] !!}
    @endif
@includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_end')

