@extends('header_admin')

@section('body')
	<?php
		$tmp=unserialize(Cookie::get('user',null));
		echo $tmp->toString();
	?>
@stop