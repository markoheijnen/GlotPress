{{Head::setTitle( _('Reset Password') )}}

@extends('layouts.master')

@section('content')


	<h2>{{ _('Reset Password') }}</h2>

	@if (session('status'))
		<div class="alert alert-success">
			{{ session('status') }}
		</div>
	@endif

	@include('errors.list')

	<form action="{!! URL::to('password/email') !!}" method="post">
		<dl>
			<dt><label for="user_login">{{ _('Username') }}</label></dt>
			<dd><input type="text" value="{{ old('username') }}" id="user_login" name="username" /></dd>
		</dl>
		<p>
			<input type="submit" name="submit" value="{{ _('Send Password Reset Link') }}" id="submit">
		</p>

		<input type="hidden" name="_token" value="{{ csrf_token() }}">
	</form>

	<script type="text/javascript" charset="utf-8">
		document.getElementById('user_login').focus();
	</script>

@endsection
