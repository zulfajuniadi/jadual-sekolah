{{-- converts 1/true or 0/false to yes/no/lang --}}
@php
    $value = data_get($entry, $column['name']);

    if ($value === true || $value === 1 || $value === '1') {
        $related_key = 1;
        if ( isset( $column['options'][1] ) ) {
            $column['text'] = $column['options'][1];
            $column['escaped'] = false;
        } else {
            $column['text'] = Lang::has('backpack::crud.yes')?trans('backpack::crud.yes'):'Yes';
        }
    }else {
        $related_key = 0;
        if ( isset( $column['options'][0] ) ) {
            $column['text'] = $column['options'][0];
            $column['escaped'] = false;
        } else {
            $column['text'] = Lang::has('backpack::crud.no')?trans('backpack::crud.no'):'No';
        }
    }
    $column['escaped'] = $column['escaped'] ?? true;

@endphp

<span data-order="{{ $value }}">
	@includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_start')
        @if($column['escaped'])
            {{ $column['text'] }}
        @else
            {!! $column['text'] !!}
        @endif
    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_end')
</span>
