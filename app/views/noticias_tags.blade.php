@extends('master')

@section('content')			
<h2>TAGS</h2>
<ul>
<PRE>
	<?php
		foreach ($tags as $tag) {
			 echo "<LI>$tag</LI>";
		}
	?> 
</PRE>
</ul>

@stop

