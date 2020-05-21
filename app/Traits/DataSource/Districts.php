<?php

namespace App\Traits\DataSource;

use App\Models\District;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

trait Districts {

	/**
     * [scrap_districts description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function scrap_districts(Request $request){

    	$collection =  collect($request->all());
    	$districts =  $collection->map(function($item, $key){
    		$region =  Region::where('name', $item[0])->first();
    		return [

    			"uuid" =>  Uuid::uuid4(),
    			"region_id" => $region->id,
    			"district" => $item[2]
    		];
    	});
    	$data = $districts->unique('district')->values()->all();
    	$this->check_if_districts_exists($data);
    	
    }

       /**
     * [check_if_exists description]
     * 
     * @param  Model  $model [description]
     * @param  [type] $data  [description]
     * @return [type]        [description]
     */
    public function check_if_districts_exists($data){

    	$collection = collect($data);
    	$validated = $collection->map(function($item, $key){
    		$check = District::where('name', $item['district'])->first();
    		if(!$check) {
				return [

						"uuid" =>  $item['uuid'],
                        "region" => $item['region_id'], 
                        "district" => $item['district'],
                        "created_at" => now(),
                        "updated_at" => now()
                    ];
    		}
    	});
    	$results = $validated->filter(function ($value) { return !is_null($value); });
    	$final = $results->unique()->values()->all();
    	$this->create_districts($final);
    }


    /**
     *	persist regions to datastore
     * 
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    protected function create_districts(array $districts = null){

    		if(!empty($districts)){
				$instance = new District;
	    		$columns = ['uuid','region_id','name', 'created_at', 'updated_at'];
	    		$values = $districts;
	    		$batchSize = 500;
	    		$result = batch()->insert($instance, $columns, $values, $batchSize);
    		}
			return;
    }



}