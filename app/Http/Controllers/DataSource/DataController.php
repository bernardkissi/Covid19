<?php

namespace App\Http\Controllers\DataSource;

use App\Events\CoronaRegionalEvent;
use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Traits\DataSource\Districts;
use App\Traits\DataSource\RegionalComplier;
use App\Traits\DataSource\Regions;
use App\Traits\DataSource\Towns;
use Illuminate\Http\Request;

class DataController extends Controller
{
    use Regions, Districts, Towns, RegionalComplier;

    public $request;

    /**
     * constructor
     * 
     * @param Request $request [description]
     */
	public function __construct(Request $request){
		
		$this->request = $request;
	}

	/**
	 *	Fetch data from external source
	 * 
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
    public function fetch(){

    	$this->scrap_regions($this->request);
    	$this->scrap_districts($this->request);
    	$this->scrap_towns($this->request);
    	
    	$this->show();
    }

    /**
     * Dispatch regions event
     * 
     * @return [type] [description]
     */
    public function show(){

		$regions = collect([Region::all()])->all();
		event(new CoronaRegionalEvent($regions));
    }


}
