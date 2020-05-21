<?php

namespace App\Traits\DataSource;

use App\Models\District;
use App\Models\Region;

trait RegionalComplier {

   /**
     * metrics complier
     * 
     * @param  [type] $towns [description]
     * @return [type]        [description]
     */
    public function regionalTotalComplier($towns){
       $final =  collect($towns);
       return $final->map(function($data){
           return 
           [
             // 'region' => Region::where('id', $data->pluck('laravel_through_key'))->first()->name,
             'id' => Region::where('id', $data->pluck('laravel_through_key'))->first()->id,
             'confirmed' => $data->sum('confirmed'),
             'active' => $data->sum('active'),
             'recovered' => $data->sum('recovered'),
             'deceased'  => $data->sum('deceased'),
             'updated_at' => $this->getDate($data->pluck("updated_at"))
             // 'last_updated' => 
           ];
       })->all();
    }

     /**
     * metrics complier
     * 
     * @param  [type] $towns [description]
     * @return [type]        [description]
     */
    public function districtTotalComplier($towns){
       $final = collect($towns);
       return $final->map(function($data){
           return 
           [
             // 'region' => Region::where('id', $data->pluck('laravel_through_key'))->first()->name,
             'id' => District::where('id', $data->pluck('district_id'))->first()->id,
             'confirmed' => $data->sum('confirmed'),
             'active' => $data->sum('active'),
             'recovered' => $data->sum('recovered'),
             'deceased'  => $data->sum('deceased'),
             'updated_at' => $this->getDate($data->pluck("updated_at"))
             // 'last_updated' => 
           ];
       })->all();
    }

    public function getDate($dates){
       $arr = $dates->toArray(); 
       $max = max(array_map('strtotime', $arr));
       return date('Y-m-j H:i:s', $max);
    }


}