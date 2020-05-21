<?php

namespace App\Traits\DataSource;

use App\Models\District;
use App\Models\Region;
use App\Models\Town;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


trait Data {


	/**
     *	persist regions to datastore
     * 
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public function save($model, array $data = null, array $columns){

    		$model_name = app("App\Models\\$model");
    		
    		Log::info($columns);	

    		if(!empty($values)){
				$instance = new $model_name();
	    		$columns = $columns;
	    		$values = $data;
	    		$batchSize = 500;
	    		$result = batch()->insert($instance, $columns, $values, $batchSize);
	    		Log::info($result);	
    		}

			return;
    }

    /**
     *	Store retrieved data into datastore
     * 
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public  function update($model, array $data = null){

    		$model_name = app("App\Models\\$model");

			$instance = new $model_name;
	    	$values = $data;
	    	$index = 'id';
	    	$result = batch()->update($instance, $values, $index);
			Log::info($result);	
    }


   /**
     * [scrap_regions description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function scrap_regions(Request $request){

    	$collection =  collect($request->all());
    	$regions =  $collection->map(function($item, $key){
    		return [
    			"region" => $item[0],
    		];
    	});

    	$data = $regions->unique()->values()->all();
    	return $this->check_if_region_exists($data);
    }

     /**
     * [check_if_exists description]
     * 
     * @param  Model  $model [description]
     * @param  [type] $data  [description]
     * @return [type]        [description]
     */
    public function check_if_region_exists($data){

    	$collection = collect($data);
    	$validated = $collection->map(function($item, $key){
    		$check = Region::where('name', $item['region'])->first();
    		if(!$check) {
				return ["region" => $item['region']];
    		}
    	});
    	$results = $validated->filter(function ($value) { return !is_null($value); });
    	return $results->unique()->values()->all();

    }

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
    			"region_id" => $region->id,
    			"district" => $item[2]
    		];
    	});
    	$data = $districts->unique()->values()->all();
    	return $this->check_if_districts_exists($data);
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
				return ["region" => $item['region_id'], "district" => $item['district']];
    		}
    	});
    	$results = $validated->filter(function ($value) { return !is_null($value); });
    	return $results->unique()->values()->all();

    }

    /**
     * 
     * [scrap_towns description]
     * 
     * @return [type] [description]
     */
    public function scrap_towns(Request $request){

    	$collection =  collect($request->all());
    	$towns =  $collection->map(function($item, $key){
    		$district = District::where('name', $item[2])->first();
    			return [

    				"district" => $district->id,
    				"town" => $item[1],
    				"confirmed" => $item[3],
	    			"active" => $item[4],
	    			"recovered" => $item[5],
	    			"deceased" => $item[6]
    			];
    		});

    	$data = $towns->unique()->values()->all();
		$this->check_if_towns_exist_and_update($data);
    	
    }


    public function check_if_towns_exist_and_update($data){

    	$updates = array();
    	$new = array();
    	$collection = collect($data);
    	$data = $collection->map(function($item, $key){
			$town = Town::where('name', $item['town'])->first();
			if(!$town){
				return [

					"district_id" => $item['district'],
    				"town" => $item['town'],
    				"confirmed" => $item['confirmed'],
	    			"active" => $item['active'],
	    			"recovered" => $item['recovered'],
	    			"deceased" => $item['deceased']

				];
			}
			return [

				"id" => $town->id,
				"district_id" => $town->district_id,
				"name" => $town->name,
    			"confirmed" => $item['confirmed'],
	    		"active" => $item['active'],
	    		"recovered" => $item['recovered'],
	    		"deceased" => $item['deceased'],
			];
    	});

    	return $data;
    }

    /**
     * [get_new_town_updated_values description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function get_new_town_updated_values($data){

    	$data->filter(function ($value) {
    		if(collect($value)->has('id')){
    			return $value;
    		}
    	});
    }

    /**
     * [get_town_new_values description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function get_town_new_values($data){

    	$data->filter(function ($value) {
    		if(!collect($value)->has('id')){
    			return $value;
    		}
    	});
    	
    }

    /**
     * [saveRegions description]
     * @return [type] [description]
     */
    public function saveRegions($request){

    	$columns = ['name'];
    	$data = $this->scrap_regions($request);
    	$this->save('Region', $data, $columns);
    }

    /**
     * [saveDistrict description]
     * @param  [type] $model [description]
     * @return [type]        [description]
     */
    public function saveDistrict($request){

    	$data = $this->scrap_districts($request);
    	$this->save('District', $data);
    }

    /**
     * [saveTowns description]
     * @param  [type] $model [description]
     * @return [type]        [description]
     */
    public function saveTowns($request){
    	$data = $this->scrap_regions($request);
    	$values = $this->get_town_new_values($data);
    	$this->save('Town', $values);
    }


    /**
     * [updateTowns description]
     * @param  [type] $model [description]
     * @param  [type] $data  [description]
     * @return [type]        [description]
     */
    public function updateTowns($request){

    	$data = $this->scrap_regions($request);
    	$values = $this->get_new_town_updated_values($data);
    	$this->update('Town', $values);
    }

}