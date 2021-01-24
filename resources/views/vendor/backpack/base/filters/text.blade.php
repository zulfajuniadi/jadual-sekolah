{{-- Text Backpack CRUD filter --}}

<li filter-name="{{ $filter->name }}"
    filter-type="{{ $filter->type }}"
    filter-key="{{ $filter->key }}"
	class="nav-item dropdown {{ Request::get($filter->name) ? 'active' : '' }}">
	<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ $filter->label }} <span class="caret"></span></a>
	<div class="dropdown-menu p-0">
		<div class="form-group backpack-filter mb-0">
			<div class="input-group">
		        <input class="form-control pull-right"
		        		id="text-filter-{{ $filter->key }}"
		        		type="text"
						@if ($filter->currentValue)
							value="{{ $filter->currentValue }}"
						@endif
		        		>
		        <div class="input-group-append text-filter-{{ $filter->key }}-clear-button">
		          <a class="input-group-text" href=""><i class="la la-times"></i></a>
		        </div>
		    </div>
		</div>
	</div>
</li>

{{-- ########################################### --}}
{{-- Extra CSS and JS for this particular filter --}}


{{-- FILTERS EXTRA JS --}}
{{-- push things in the after_scripts section --}}

@push('crud_list_scripts')
	<!-- include select2 js-->
  <script>
		jQuery(document).ready(function($) {
			$('#text-filter-{{ $filter->key }}').on('change', function(e) {

				var parameter = '{{ $filter->name }}';
				var value = $(this).val();

		    	// behaviour for ajax table
				var ajax_table = $('#crudTable').DataTable();
				var current_url = ajax_table.ajax.url();
				var new_url = addOrUpdateUriParameter(current_url, parameter, value);

				// replace the datatables ajax url with new_url and reload it
				new_url = normalizeAmpersand(new_url.toString());
				ajax_table.ajax.url(new_url).load();

				// add filter to URL
				crud.updateUrl(new_url);

				// mark this filter as active in the navbar-filters
				if (URI(new_url).hasQuery('{{ $filter->name }}', true)) {
					$('li[filter-key={{ $filter->key }}]').removeClass('active').addClass('active');
				} else {
					$('li[filter-key={{ $filter->key }}]').trigger('filter:clear');
				}
			});

			$('li[filter-key={{ $filter->key }}]').on('filter:clear', function(e) {
				$('li[filter-key={{ $filter->key }}]').removeClass('active');
				$('#text-filter-{{ $filter->key }}').val('');
			});

			// datepicker clear button
			$(".text-filter-{{ $filter->key }}-clear-button").click(function(e) {
				e.preventDefault();

				$('li[filter-key={{ $filter->key }}]').trigger('filter:clear');
				$('#text-filter-{{ $filter->key }}').val('');
				$('#text-filter-{{ $filter->key }}').trigger('change');
			})
		});
  </script>
@endpush
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
