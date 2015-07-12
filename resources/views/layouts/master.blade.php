<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	{!! Head::render() !!}

	{!! Assets::css() !!}
	{!! Assets::js() !!}
</head>
<body>
	<script type="text/javascript">document.body.className = document.body.className.replace('no-js','js');</script>
	<div class="gp-content">
		<div id="gp-js-message"></div>

		<h1>
			<a class="logo" href="{!! URL::to('') !!}" rel="home">
				<img alt="GlotPress" src="{!! asset('img/glotpress-logo.png') !!}" />
			</a>
			<?php //echo gp_breadcrumb(); ?>
			<span id="hello">
			@if (Auth::check())

				printf( __('Hi, %s.'), '<a href="{!! URL::to('profile') !!}">'.$user->user_login.'</a>' );

				<a href="{!! URL::to('logout') !!}">{{ _('Log out') }}</a>
			@else
				<strong><a href="{!! URL::to('login') !!}">{{ _('Log in') }}</a></strong>
			@endif

			<?php //do_action( 'after_hello' ); ?>
			</span>
			<div class="clearfix"></div>
		</h1>
		<div class="clear after-h1"></div>
		<?php if ( 1 == 2 && gp_notice('error')): ?>
			<div class="error">
				<?php echo gp_notice( 'error' ); //TODO: run kses on notices ?>
			</div>
		<?php endif; ?>
		<?php if ( 1 == 2 && gp_notice()): ?>
			<div class="notice">
				<?php echo gp_notice(); ?>
			</div>
		<?php endif; ?>
		<?php //do_action( 'after_notices' ); ?>


		@yield('content')


	</div><!-- .gp-content -->

	<p id="gp-footer" class="secondary">
		<?php printf( _('Proudly powered by <a href="%s" title="Found in translation">GlotPress</a>.'), 'http://glotpress.org/' ); ?>
	</p>

</body>
</html>
