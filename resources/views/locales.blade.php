<?php Assets::add('tablesorter'); ?>
@extends('layouts.master')

@section('content')

	<h2>{{ _('Locales and Languages') }}</h2>
	<div class="locales-filter">
		{{ _('Filter:') }} <input id="locales-filter" type="text" placeholder="{{ _('search') }}" />
	</div>

	<table class="tablesorter locales">
		<thead>
		<tr>
			<th class="header">{{ _('Name (in English)') }}</th>
			<th class="header">{{ _('Native name') }}</th>
			<th class="header">{{ _('Language code') }}</th>

		</tr>
		</thead>
		<tbody>
		@foreach( $locales as $locale )
			<tr>
				<td><a href="{{ route('locale', $locale->slug) }}">{{ $locale->english_name }}</a></td>
				<td><a href="{{ route('locale', $locale->slug) }}">{{ $locale->native_name }}</a></td>
				<td><a href="{{ route('locale', $locale->slug) }}">{{ $locale->slug }}</a></td>
			</tr>
		@endforeach
		</tbody>
	</table>

	<script type="text/javascript" charset="utf-8">
		jQuery(document).ready(function($) {
			$('.locales').tablesorter({
				headers: {
					0: {
						sorter: 'text'
					}
				},
				widgets: ['zebra']
			});

			$('.locales').width($('.locales').width());

			$rows = $('.locales tbody').find('tr');
			$('#locales-filter').bind("change keyup input",function() {
				var words = this.value.toLowerCase().split(' ');

				if ( '' == this.value.trim() ) {
					$rows.show();
				} else {
					$rows.hide();
					$rows.filter(function (i, v) {
						var $t = $(this);
						for ( var d = 0; d < words.length; ++d ) {
							if ( $t.text().toLowerCase().indexOf( words[d] )  != -1 ) {
								return true;
							}
						}
						return false;
					}).show();
				}
			});
		});
	</script>

@stop