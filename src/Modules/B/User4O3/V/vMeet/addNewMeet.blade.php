@if(!env('MS_DEBUG'))
    @extends('MS::core.layouts.rootRaw')
@else
    @extends('MS::core.layouts.root')
@endif
@section('body')

    <?php

    $jsonData=(isset($data))?collect($data)->toJson():collect([])->toJson();

    ?>

    <msvmeet :ms-data="{{$jsonData}}"></msvmeet>


@endsection
