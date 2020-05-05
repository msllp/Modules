@extends('MS::layouts.dashboard')
@section('page_heading','Icons')
@section('section')
	<div class="col-sm-12">
		@section ('icons_panel_title','Icons')
		@section ('icons_panel_body')
		<div class="row">
			<div class="fa col-lg-3">
				<p>@include('MS::widgets.icon', array('class'=>'glass')) fa-glass

				<p>@include('MS::widgets.icon', array('class'=>'music')) fa-music

				<p>@include('MS::widgets.icon', array('class'=>'search')) fa-search

				<p>@include('MS::widgets.icon', array('class'=>'envelope-o')) fa-envelope-o

				<p>@include('MS::widgets.icon', array('class'=>'heart')) fa-heart

				<p>@include('MS::widgets.icon', array('class'=>'star')) fa-star

				<p>@include('MS::widgets.icon', array('class'=>'star-o')) fa-star-o

				<p>@include('MS::widgets.icon', array('class'=>'user')) fa-user

				<p>@include('MS::widgets.icon', array('class'=>'film')) fa-film

				<p>@include('MS::widgets.icon', array('class'=>'th-large')) fa-th-large

				<p>@include('MS::widgets.icon', array('class'=>'th')) fa-th

				<p>@include('MS::widgets.icon', array('class'=>'th-list')) fa-th-list

				<p>@include('widgets.icon', array('class'=>'check')) fa-check

				<p>@include('MS::widgets.icon', array('class'=>'times')) fa-times

				<p>@include('MS::widgets.icon', array('class'=>'search-plus')) fa-search-plus

				<p>@include('MS::widgets.icon', array('class'=>'search-minus')) fa-search-minus

				<p>@include('MS::widgets.icon', array('class'=>'power-off')) fa-power-off

				<p>@include('MS::widgets.icon', array('class'=>'signal')) fa-signal

				<p>@include('MS::widgets.icon', array('class'=>'gear')) fa-gear

				<p>@include('MS::widgets.icon', array('class'=>'cog')) fa-cog

				<p>@include('MS::widgets.icon', array('class'=>'trash-o')) fa-trash-o

				<p>@include('MS::widgets.icon', array('class'=>'home')) fa-home

				<p>@include('MS::widgets.icon', array('class'=>'file-o')) fa-file-o

				<p>@include('MS::widgets.icon', array('class'=>'clock-o')) fa-clock-o

				<p>@include('MS::widgets.icon', array('class'=>'road')) fa-road

				<p>@include('MS::widgets.icon', array('class'=>'download')) fa-download

				<p>@include('MS::widgets.icon', array('class'=>'arrow-circle-o-down')) fa-arrow-circle-o-down

				<p>@include('MS::widgets.icon', array('class'=>'arrow-circle-o-up')) fa-arrow-circle-o-up

				<p>@include('MS::widgets.icon', array('class'=>'inbox')) fa-inbox

				<p>@include('MS::widgets.icon', array('class'=>'play-circle-o')) fa-play-circle-o

				<p>@include('MS::widgets.icon', array('class'=>'rotate-right')) fa-rotate-right

				<p>@include('MS::widgets.icon', array('class'=>'repeat')) fa-repeat

				<p>@include('MS::widgets.icon', array('class'=>'refresh')) fa-refresh

				<p>@include('MS::widgets.icon', array('class'=>'list-alt')) fa-list-alt
				</p>

			</div>
		
		@endsection
		@include('MS::widgets.panel', array('header'=>true, 'as'=>'icons'))
	
	
@stop