<?php

namespace App\Http\Controllers\DataSource;

use App\Http\Controllers\Controller;
use App\Http\Resources\RegionCollection;
use App\Models\Region;
use App\Models\Statistic;
use App\Traits\DataSource\RegionalComplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class APIController extends Controller
{
    use RegionalComplier;
	/**
	 * Regional Data 
	 * 
	 * @return [type] [description]
	 */
    public function getRegionalData(){
	 	$value = Cache::remember('regional', 1800, function () {
   			 return Region::all();
		});
	    
        return $value;
    }

    /**
     * [getSummary description]
     * @return [type] [description]
     */
    public function getSummary(){
		$value = Cache::remember('summary', 1800, function () {
   			 return DB::table('statistics')->latest()->first();
		});
		return response()->json(['data' => $value], 200);
		
    }


    /**
     * [getDailyUpdates description]
     * @return [type] [description]
     */
    public function getDailyUpdates(){
    
    	$value = Cache::remember('daily', 1800, function () {
   			 return Http::get('https://api.quarantine.country/api/v1/summary/region?region=ghana')->json();
		});
		return $value;
    }


    /**
     * [getWeeklyUpdates description]
     * @return [type] [description]
     */
    public function getWeeklyUpdates(){
		
		$value = Cache::remember('weekly', 1800, function () {
   			 return Http::get('https://api.quarantine.country/api/v1/spots/week?region=ghana')->json();
		});
		return $value;
		
	}


    /**
     * [statusFromDayOne description]
     * @return [type] [description]
     */
    public function recoveredFromDayOne(){

    	$value = Cache::remember('recoveredFromDayOne', 1800, function () {
   			 return Http::get('https://api.covid19api.com/dayone/country/ghana/status/recovered')->json();
		});
		return response()->json(['data' => $value], 200);
    }


    /**
     * [statusFromDayOne description]
     * @return [type] [description]
     */
    public function deceasedFromDayOne(){

    	$value = Cache::remember('deathFromDayOne', 1800, function () {
   			 return Http::get('https://api.covid19api.com/dayone/country/ghana/status/deaths')->json();
		});
		return response()->json(['data' => $value], 200);
    }



    /**
     * [statusFromDayOne description]
     * @return [type] [description]
     */
    public function confirmedFromDayOne(){

    	$value = Cache::remember('confirmedFromDayOne', 1800, function () {
   			 return Http::get('https://api.covid19api.com/dayone/country/ghana/status/confirmed')->json();
		});
		return response()->json(['data' => $value], 200);
    }


    /**
     * [totalFromDayOne description]
     * @return [type] [description]
     */
    public function world(){

    	$value = Cache::remember('world',1800, function () {
   			 $data = Http::get('https://coronavirus-19-api.herokuapp.com/all')->json();
             $collection = collect($data);
             $merged = $collection->merge(['updated' => now()]);
             return $merged->all();
		});
		return $value;
    }

    /**
     * getRegional Totals
     * 
     * @return [type] [description]
     */
    protected function getRegionalTotals(){

       $regions = Region::all();
       $towns = [];
       foreach($regions as $region){
           $towns[] = $region->towns()->get();
       }
       $data = $towns;

       return $this->regionalTotalComplier($data);
    }

}


