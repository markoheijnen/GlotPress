{{Head::setTitle( _('Login') )}}

@extends('layouts.master')


@section('content')

	<h2>{{ _('Login') }}</h2>

	<form action="{!! URL::to('login') !!}" method="post">
		<dl>
			<dt><label for="user_login">{{ _('Username') }}</label></dt>
			<dd><input type="text" value="{{ old('username') }}" id="user_login" name="username" /></dd>

			<dt><label for="user_pass">{{ _('Password') }}</label></dt>
			<dd><input type="password" value="" id="user_pass" name="password" /></dd>
		</dl>
		<p>
			<input type="submit" name="submit" value="{{ _('Login') }}" id="submit">
			<a href="{!! URL::to('/password/email') !!}">{{ _('Forgot Your Password?') }}</a>
		</p>

		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" value="{{ Input::get('redirect_to') }}" id="redirect_to" name="redirect_to" />
	</form>

	<script type="text/javascript" charset="utf-8">
		document.getElementById('user_login').focus();
	</script>

@endsection
