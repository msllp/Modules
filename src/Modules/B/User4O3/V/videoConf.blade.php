@extends((env('MS_DEBUG'))? 'MS::core.layouts.root':'MS::core.layouts.rootRaw')

@section('body')

<?php

$jsonData=(isset($data))?collect($data)->toJson():collect([])->toJson();

?>

    <msvideoconf :ms-data="{{$jsonData}}"></msvideoconf>


@endsection
