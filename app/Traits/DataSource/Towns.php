<?php

namespace App\Traits\DataSource;

use App\Models\District;
use App\Models\Region;
use App\Models\Town;
use App\Traits\DataSource\RegionalComplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;


trait Towns {

	use RegionalComplier;
	/**
     * [scrap_towns description]
     * @return [type] [description]
     */
    public function scrap_towns(Request $request){

    	$collection =  collect($request->all());
    	$towns =  $collection->map(function($item, $key){
    		$district = District::where('name', $item[2])->first();
    			return [

    				"uuid" =>   Uuid::uuid4(),
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


    /**
     * [check_if_towns_exist_and_update description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function check_if_towns_exist_and_update($data){

    	$collection = collect($data);
    	$data = $collection->map(function($item, $key){
			$town = Town::where('name', $item['town'])->first();
			if(!$town){
				return [

					"uuid" => $item['uuid'],
					"district_id" => $item['district'],
    				"town" => $item['town'],
    				"confirmed" => $item['confirmed'],
	    			"active" => $item['active'],
	    			"recovered" => $item['recovered'],
	    			"deceased" => $item['deceased'],
	    			"created_at" => now(),
                    "updated_at" => now()
                    
				];
			}
			return [

				"id" => $town->id,
				"uuid" => $town->uuid,
				"district_id" => $town->district_id,
				"name" => $town->name,
    			"confirmed" => $item['confirmed'],
	    		"active" => $item['active'],
	    		"recovered" => $item['recovered'],
	    		"deceased" => $item['deceased'],
	    		"local" => $town->local,
	    		"imported" => $town->imported,
	    		"counter" =>  $town->counter + $item['confirmed'] - $town->confirmed,
	    		
			];
    	});


    	$old_records = $this->getExistingData();

    	$updated = $data->filter(function ($value) {
    		if(collect($value)->has('id')){
    			return $value;
    		}
    	})->toArray();

  		$diff = $this->compareArr($updated, $old_records);
  		$ready_for_update = $this->modifyData($diff);
  		Log::info($ready_for_update);

  
    	$new = $data->filter(function ($value) {
    		if(!collect($value)->has('id')){
    			return $value;
    		}
    	});
        $this->create_towns($new->unique()->values()->all());
		$this->update_towns($ready_for_update->unique()->values()->all());
		$this->saveRegionalTotal();
		$this->saveDistrictTotal();
    }


    /**
     *	Store retrieved data into datastore
     * 
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function create_towns($data){

    		if(!empty($data)){
    			
				$instance = new Town;
	    		$columns = ['uuid', 'district_id', 'name', 'confirmed', 'active', 'recovered', 'deceased', 'created_at', 'updated_at'];
	    		$values = $data;
	    		$batchSize = 500;
	    		$result = batch()->insert($instance, $columns, $values, $batchSize);
    		}

			return;
    }


     /**
     *	Store retrieved data into datastore
     * 
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function update_towns($data){

    	if(!empty($data)){
			$instance = new Town;
		    $values = $data;
		    $index = 'id';
		    $result = batch()->update($instance, $values, $index);
		}
	
		return;
	}


	/**
	 *  compare difference between arrays
	 * 
	 * @param  [type] $arr1 [description]
	 * @param  [type] $arr2 [description]
	 * @return [type]       [description]
	 */
	public function compareArr($arr1, $arr2){

		return array_map('unserialize', array_diff_assoc(array_map('serialize', $arr1), array_map('serialize', $arr2)));

	}


	/**
	 *	Get existing data from the database. 
	 *
	 * @return [type] [description]
	 */
	public function getExistingData(){

		$old_collection =  collect(Town::all()->toArray());
    	return $old_collection->map(function($town, $index) {

 			return [

					"id" => $town['id'],
					"uuid" => $town['uuid'],
					"district_id" => $town['district_id'],
					"name" => $town['name'],
	    			"confirmed" => $town['confirmed'],
		    		"active" => $town['active'],
		    		"recovered" => $town['recovered'],
		    		"deceased" => $town['deceased'],
		    		"local" => $town['local'],
		    		"imported" => $town['imported'],
		    		"counter" =>  $town['counter']
 				];
    	})->toArray();
	}


	/**
	 * Transform data for update
	 * 
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function modifyData($data){
		$collection = collect($data);
		return $collection->map(function($town){

			  return [

			  	    "id" => $town['id'],
					"uuid" => $town['uuid'],
					"district_id" => $town['district_id'],
					"name" => $town['name'],
	    			"confirmed" => $town['confirmed'],
		    		"active" => $town['active'],
		    		"recovered" => $town['recovered'],
		    		"deceased" => $town['deceased'],
		    		"local" => $town['local'],
		    		"imported" => $town['imported'],
		    		"counter" =>  $town['counter'],
		    		"updated_at" => now()

			  ];

		});
	}


	public function saveRegionalTotal(){

		$regions = Region::all();
        $collection = collect($regions);

        $towns = [];
        foreach($regions as $region){
           $towns[] = $region->towns()->get();
        }
        $data = $towns;

        $complied = $this->regionalTotalComplier($data);
        $this->update_regions_totals($complied);

	}


	public function saveDistrictTotal(){

		$districts = District::all();
        $collection = collect($districts);

        $towns = [];
        foreach($districts as $district){
           $towns[] = $district->towns()->get();
        }
        $data = $towns;

        $complied = $this->districtTotalComplier($data);
        $this->update_districts_totals($complied);

	}


	 /**
     *	Store retrieved data into datastore
     * 
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function update_regions_totals($data){

    	if(!empty($data)){
			$instance = new Region;
		    $values = $data;
		    $index = 'id';
		    $result = batch()->update($instance, $values, $index);
		}
	
		return;
	}

	 /**
     *	Store retrieved data into datastore
     * 
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function update_districts_totals($data){

    	if(!empty($data)){
			$instance = new District;
		    $values = $data;
		    $index = 'id';
		    $result = batch()->update($instance, $values, $index);
		}
	
		return;
	}

}