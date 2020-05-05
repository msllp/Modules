@extends ('MS::layouts.dashboard')

@section('page_title')	Stats @stop

@section('section')
<h2>Stats</h2>

	@include('MS::widgets.stat', array('icon'=> 'whatsapp', 'header'=> 'Views', 'value'=>'71,842', 'href'=>'#', 'color'=>'primary'))
	
	
	@include('MS::widgets.stat', array('icon'=> 'archive', 'header'=> 'header', 'value'=>'19,968', 'href'=>'#', 'color'=>'info'))
	
	
	@include('MS::widgets.stat', array('icon'=> 'desktop', 'header'=> 'Header', 'value'=>'000', 'href'=>'#', 'color'=>'success'))
	
	
	@include('MS::widgets.stat', array('icon'=> 'folder', 'header'=> 'Title', 'value'=>'758,412,304', 'href'=>'#', 'color'=>'danger'))
	
@stop
