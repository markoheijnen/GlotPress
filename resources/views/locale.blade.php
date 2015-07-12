@extends('layouts.master')

@section('content')

	<h2>{{ sprintf( _('Active Projects translated to %s'), $locale->english_name ) }}</h2>

	@if (count($set_list) > 1)
		<p class="actionlist secondary">
			{{ implode( ' &bull;&nbsp;', $set_list ) }}
		</p>
	@endif

	@if (empty($projects_data))
		{{ _('No active projects found.') }}
	@endif

	@foreach( $projects_data as $project_id => $sub_projects )
		<div class="locale-project">
			<h3>{{ $projects[$project_id]->name }}</h3>

			<table class="locale-sub-projects">
				<thead>
				<tr>
					@if (count($sub_projects) > 1)
						<th class="header" rowspan="{{count($sub_projects)}}">
							{{ _('Project') }}
						</th>
					@else
						<th class="header"></th>
					@endif
					</th>
					<th class="header">{{ _('Set / Sub Project') }}</th>
					<th>{{ _('Translated') }}</th>
					<th>{{ _('Fuzzy') }}</th>
					<th>{{ _('Untranslated') }}</th>
					<th>{{ _('Waiting') }}</th>
				</tr>
				</thead>
				<tbody>
					@foreach( $sub_projects as $sub_project_id => $data )
					<tr>
						<th class="sub-project" rowspan="{{ count( $data['sets'] ) }}">
							@if (count($sub_projects) > 1)
								{{ $projects[$sub_project_id]->name }}
							@endif

							<div class="stats">
								<div class="total-strings">{{ sprintf( _( '%d strings' ), $data['totals']->all_count ) }}></div>
								<div class="percent-completed">{{ sprintf( _( '%d%% translated' ), $data['totals']->current_count ? floor( intval($data['totals']->current_count ) / intval( $data['totals']->all_count ) * 100 ) : 0 ) }}</div>
							</div>
						</th>

						@foreach( $data['sets'] as $set_id => $set_data )
							<?php reset( $data['sets'] ); ?>
							
							@if ($set_id !== key($data['sets']))
								<tr>
							@endif
							<td class="set-name">
								<a href="{{ route('project', $set_data->project_path) }}">
									<strong>{{ $set_data->name }}</strong>

									<?php //gp_link( gp_url_project( $set_data->project_path, gp_url_join( $locale->slug, $set_data->slug ) ), $set_data->name ); ?>
								</a>
								<?php if ( $set_data->current_count && $set_data->current_count >= $set_data->all_count * 0.9 ):
									$percent = floor( $set_data->current_count / $set_data->all_count * 100 );
									?>
									<span class="bubble morethan90"><?php echo $percent; ?>%</span>
								<?php endif;?>
							</td>
							<td class="stats translated">
								<a href="">{{ $set_data->current_count}}</a>
								<?php //gp_link( gp_url_project( $set_data->project_path, gp_url_join( $locale->slug, $set_data->slug ), array('filters[translated]' => 'yes', 'filters[status]' => 'current') ), absint( $set_data->current_count ) ); ?>
							</td>
							<td class="stats fuzzy">
								<a href="">{{ $set_data->fuzzy_count}}</a>
								<?php //gp_link( gp_url_project( $set_data->project_path, gp_url_join( $locale->slug, $set_data->slug ), array('filters[status]' => 'fuzzy' ) ), absint( $set_data->fuzzy_count ) ); ?>
							</td>
							<td class="stats untranslated">
								<a href="">{{ $set_data->all_count - $set_data->current_count}}</a>
								<?php //gp_link( gp_url_project( $set_data->project_path, gp_url_join( $locale->slug, $set_data->slug ), array('filters[status]' => 'untranslated' ) ), absint( $set_data->all_count ) -  absint( $set_data->current_count ) ); ?>
							</td>
							<td class="stats waiting">
								<a href="">{{ $set_data->waiting_count}}</a>
								<?php //gp_link( gp_url_project( $set_data->project_path, gp_url_join( $locale->slug, $set_data->slug ), array('filters[translated]' => 'yes', 'filters[status]' => 'waiting') ), absint( $set_data->waiting_count ) ); ?>
							</td>
						</tr>
						@endforeach
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	@endforeach

	<p class="actionlist secondary">
		<a href="{{ route('projects') }}">{{ _('All projects') }}</a>
	</p>

@stop