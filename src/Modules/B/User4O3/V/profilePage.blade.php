@if(!env('MS_DEBUG'))
    @extends('MS::core.layouts.rootRaw')
@else
    @extends('MS::core.layouts.root')
@endif
@section('body')
<?php

$msData=collect($data['UserDetails']);
unset($data['UserDetails']);
$msDataExtra=collect($data);
//dd($msDataExtra);
//dd($msData);
?>

    <profile :ms-data="{{$msData}}" :ms-extra="{{$msDataExtra}}"></profile>


@endsection
