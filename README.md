
   public function getPageData(){


   		$response = Http::get('https://www.worldometers.info/coronavirus/');
		$html = $response->body();

		$crawler = new Crawler($html);
		$data = $crawler->filter("table > tbody > tr");

		$nodeValues = $data->each(function (Crawler $node, $i) {
		$first = $node->text();
		return array($first);
		});
		
		print_r($nodeValues[96]);

   }


   public function trimData($data){

   	  $data->filter(function($value){

   	  	if($this->startsWith('Ghana', $value)){
   	  		return $value;
   	  	}

   	  });
   		
   }


 	public function saveData(){


 	}


 	public function exportData(){


 	}
