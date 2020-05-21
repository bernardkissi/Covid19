<?php

namespace App\Traits\DataSource;

use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;



trait Regions {

    /**
     * [scrap_regions description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function scrap_regions(Request $request){

    	$collection =  collect($request->all());
    	$regions =  $collection->map(function($item, $key){
    		return [

    			"uuid" =>   Uuid::uuid4(),
    			"region" => $item[0],
    		];
    	});

    	$data = $regions->unique('region')->values()->all();
    	$this->check_if_group_exists($data);
    }

     /**
     * [check_if_exists description]
     * 
     * @param  Model  $model [description]
     * @param  [type] $data  [description]
     * @return [type]        [description]
     */
    public function check_if_group_exists($data){

    	$collection = collect($data);
    	$validated = $collection->map(function($item, $key){
    		$check = Region::where('name', $item['region'])->first();
    		if(!$check) {
				return [
                            "uuid" => $item['uuid'],
                            "region" => $item['region'],
                            "created_at" => now(),
                    		"updated_at" => now()
                        ];
    		}
    	});
    	$results = $validated->filter(function ($value) { return !is_null($value); });
    	$final = $results->unique()->values()->all();
    	$this->create_groups($final);

    }

    /**
     *	persist regions to datastore
     * 
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    protected function create_groups(array $regions = null){

    		if(!empty($regions)){
				$instance = new Region;
	    		$columns = ['uuid', 'name','created_at', 'updated_at'];
	    		$values = $regions;
	    		$batchSize = 500;
	    		$result = batch()->insert($instance, $columns, $values, $batchSize);
    		}

			return;
    }
}