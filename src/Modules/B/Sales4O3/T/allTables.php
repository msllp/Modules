<?php

//dd(\MS\Mod\B\Sales4O3\L\Sales::getTableRaw());
$tables=array_merge(
    \MS\Mod\B\Sales4O3\L\Product::getTableRaw(),
    \MS\Mod\B\Sales4O3\L\Client::getTableRaw()

);
return $tables;
