@extends('MS::core.layouts.root')
@section('body')

<?php

$jsonData=(isset($data))?collect($data)->toJson():collect([])->toJson();

?>

    <msvideoconf :ms-data="{{$jsonData}}"></msvideoconf>


@endsection
