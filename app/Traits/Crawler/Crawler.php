<?php

namespace App\Traits\Crawler;

use App\Events\CoronaGeneralEvent;
use App\Models\Statistic;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler as Crawl;



trait Crawler {


	/**
	 *	fetch page data from url
	 * 
	 * @return [type] [description]
	 */
   public function fetchPage(){
		
		$response = Http::get('https://www.worldometers.info/coronavirus/');
		$html = $response->body();

		$crawler = new Crawl($html);
		$data = $crawler->filter("table > tbody > tr");
		$nodeValues = $data->each(function (Crawl $node, $i) {
			$first = $node->text();
			return $first;
		});

		$data = collect($nodeValues)->map(function($item, $key){return explode(' ', $item);});
		$actual_value = $data->filter(function($item, $key){
			if(in_array('Ghana', $item)){return $item;}
		});

		$values = collect($actual_value)->first();

		Log::info($values);

		event(new CoronaGeneralEvent($values));

	}


	/**
	 * [save description]
	 * @param  [type] $values [description]
	 * @return [type]         [description]
	 */
	public function save($values) {

		if(count($values) >= 13) {
			$this->saveDataExtra($values);
		}else{
			$this->saveData($values);
		} 
	}

	public function convert($number){
		return (int) filter_var($number, FILTER_SANITIZE_NUMBER_INT);
	}
	/**
	 * [saveData description]
	 * @param  [type] $values [description]
	 * @return [type]         [description]
	 */
	public function saveData($values){

		Statistic::create([

			'country' => $values[0],
			'confirmed_cases' => $this->convert($values[1]),
			'total_death' =>$this->convert($values[2]),
			'total_recovered' => $this->convert($values[3]),
			'active_cases' => $this->convert($values[4]),
			'critical_cases' => $this->convert($values[5]),
			'total_cases_per_mil' => $this->convert($values[6]),
			'total_death_per_mil' => $this->convert($values[7]),
			'total_tested' =>  $this->convert($values[8]),
			'total_test_per_mil' => $this->convert($values[9])
		]);
	}

	/**
	 * [saveDataExtra description]
	 * @param  [type] $values [description]
	 * @return [type]         [description]
	 */
	public function saveDataExtra($values){

		Statistic::create([

			'country' => $values[0],
			'confirmed_cases' => $this->convert($values[1]),
			'new_cases' => $this->convert($values[2]),
			'total_death' => $this->convert($values[3]),
			'new_deaths' => $this->convert($values[4]),
			'total_recovered' => $this->convert($values[5]),
			'active_cases' => $this->convert($values[6]),
			'critical_cases' => $this->convert($values[7]),
			'total_cases_per_mil' => $this->convert($values[8]),
			'total_death_per_mil' => $this->convert($values[9]),
			'total_tested' =>  $this->convert($values[10]),
			'total_test_per_mil' => $this->convert($values[11])
		]);
	}

}