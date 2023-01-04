<?php

use Src\Support\Flash\Flash;

if (!function_exists('flash')) {
	function flash(): Flash
	{
		return app(Flash::class);
	}
}
