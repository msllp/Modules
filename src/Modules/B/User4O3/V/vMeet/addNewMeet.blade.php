@extends('MS::core.layouts.rootRaw')
@section('body')

    <?php

    $jsonData=(isset($data))?collect($data)->toJson():collect([])->toJson();

    ?>

    <msvmeet :ms-data="{{$jsonData}}"></msvmeet>


@endsection
