<?php Assets::add('tablesorter'); ?>
@extends('layouts.master')

@section('content')

	<h2>{{ $project->name }}</h2>
	<p class="description">
		{!! $project->description !!}
	</p>

	@permission('write.projects')

	<div class="actionlist">
		<a href="#" class="project-actions" id="project-actions-toggle">{{ _('Project actions &darr;') }}</a>
		<div class="project-actions hide-if-js">
			<?php //gp_project_actions( $project, $translation_sets ); ?>
		</div>
	</div>
	@endpermission

	<div id="project" @if ( ! $sub_projects->isEmpty() ) {!! 'class="with-sub-projects"' !!} @endif>

	@if (! $translation_sets->isEmpty())
	<div id="translation-sets">
		<h3>{{ _('Translations') }}</h3>
		<table class="translation-sets tablesorter">
			<thead>
				<tr>
					<th>{{ _('Locale') }}</th>
					<th>%x</th>
					<th>{{ _('Translated' ) }}</th>
					<th>{{ _('Fuzzy' ) }}</th>
					<th>{{ _('Untranslated' ) }}</th>
					<th>{{ _('Waiting' ) }}</th>
					<?php //if ( has_action( 'project_template_translation_set_extra' ) ) : ?>
					<th class="extra">{{ _('Extra') }}</th>
					<?php //endif; ?>
				</tr>
			</thead>
			<tbody>
			@foreach( $translation_sets as $set )
				<tr>
					<td>
						<strong><a href="{{ route('translation-set', [$project->slug, $set->locale, $set->slug]) }}">
							{{ $set->name_with_locale() }}
						</a></strong>
						@if ( $set->current_count && $set->current_count >= $set->all_count * 0.9 )
							<span class="bubble morethan90">{{ floor( $set->current_count / $set->all_count * 100 ) }}%</span>
						@endif
					</td>
					<td class="stats percent">{{ $set->percent_translated }}%</td>
					<td class="stats translated" title="translated">
						<a href="{{ route('translation-set', [$project->slug, $set->locale, $set->slug]) . '?filters[translated]=yes&filters[status]=current' }}">
							{{ $set->current_count }}
						</a>
					</td>
					<td class="stats fuzzy" title="fuzzy">
						<a href="{{ route('translation-set', [$project->slug, $set->locale, $set->slug]) . '?filters[status]=fuzzy' }}">
							{{ $set->fuzzy_count }}
						</a>
					</td>
					<td class="stats untranslated" title="untranslated">
						<a href="{{ route('translation-set', [$project->slug, $set->locale, $set->slug]) . '?filters[status]=untranslated' }}">
							{{ $set->untranslated_count }}
						</a>
					</td>
					<td class="stats waiting" title="waiting">
						<a href="{{ route('translation-set', [$project->slug, $set->locale, $set->slug]) . '?filters[translated]=yes&filters[status]=waiting' }}">
							{{ $set->untranslated_count }}
						</a>
					</td>
					<?php //if ( has_action( 'project_template_translation_set_extra' ) ) : ?>
					<td class="extra">
						<?php //do_action( 'project_template_translation_set_extra', $set, $project ); ?>
					</td>
					<?php //endif; ?>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
	@elseif (! $sub_projects)
		<p>{{ _('There are no translations of this project.') }}</p>
	@endif


	@if (! $sub_projects->isEmpty())
	<div id="sub-projects">
	<h3>{{ _('Sub-projects') }}</h3>
	<dl>
	@foreach( $sub_projects as $sub_project )
		<dt>
			<a href="{{ route('project', $sub_project->path) }}">
				{{ $sub_project->name }}
			</a>
			<?php //gp_link_project_edit( $sub_project, null, array( 'class' => 'bubble' ) ); ?>
			<?php //if ( $sub_project->active ) echo "<span class='active bubble'>" . __('Active') . "</span>"; ?>
		</dt>
		<dd>
			<?php //esc_html( gp_html_excerpt( apply_filters( 'sub_project_description', $sub_project->description, $sub_project ), 111 ) ); ?>
		</dd>
	@endforeach
	</dl>
	</div>
	@endif

	</div>

	<div class="clear"></div>

	<script type="text/javascript" charset="utf-8">
		$gp.showhide('a.personal-options', 'div.personal-options', {
			show_text: '{{ _('Personal project options &darr;') }}',
			hide_text: '{{ _('Personal project options &uarr;') }}',
			focus: '#source-url-template',
			group: 'personal'
		});
		jQuery('div.personal-options').hide();
		$gp.showhide('a.project-actions', 'div.project-actions', {
			show_text: '{{ _('Project actions &darr;') }}',
			hide_text: '{{ _('Project actions &uarr;') }}',
			focus: '#source-url-template',
			group: 'project'
		});
		jQuery(document).ready(function($) {
			$(".translation-sets").tablesorter({
				headers: {
					0: {
						sorter: 'text'
					}
				},
				widgets: ['zebra']
			});
		});
	</script>

@stop
