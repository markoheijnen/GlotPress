@extends('layouts.master')

@section('content')

	<h2>{{ _('Projects') }}</h2>

	<ul>
		@foreach( $projects as $project )
			<li>
				<a href="{{ route('project', $project->slug) }}" title="Project: {{ $project->name }}">{{ $project->name }}</a>
			</li>
		@endforeach
	</ul>

	<p class="actionlist secondary">
		@permission('new.projects')
			<a href="{{ route('projects') }}-new">{{ _('Create a New Project') }}</a> &bull;&nbsp;
		@endpermission

		<a href="{{ route('locales') }}">{{ _('Projects by locale') }}</a>
	</p>

@stop