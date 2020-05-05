<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 24-03-2019
 * Time: 05:04 AM
 */
$inputClass=$data['inputClass'];
$inputValue=$data['inputValue'];
?>
<input type="text" class="{{  $inputClass  }}" value="{{$inputValue }}" disabled>
<input type="hidden" name="{{$data['name']}}" class="{{  $inputClass  }}" value="{{$inputValue }}" disabled>
