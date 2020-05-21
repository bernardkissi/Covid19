<?php

namespace App\Traits\Cache;

use Illuminate\Support\Facades\Cache as Caching;


trait Cache {


	public function compareArr(Array $one, Array $two){

	   $result = array_diff($one, $two);
	   if(count($result) > 0){
	   	 return true;
	   }
	   return false;
	}



	public function shouldCache($key, $callback, $data = null){

		if(!$condition){
			return Caching::remember($key, $callback);
		}
		
		Caching::forget($key);
		Caching::put($key, $value);
	}
}