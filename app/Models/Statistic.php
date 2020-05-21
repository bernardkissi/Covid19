<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
	    'country', 
	    'confirmed_cases', 
	    'total_death', 
	    'total_recovered', 
	    'total_cases',
	    'active_cases',
	    'critical_cases',
	    'total_cases_per_mil',
	    'total_death_per_mil',
	    'total_tested',
	    'total_test_per_mil'
	];

    /**
     * [$table description]
     * @var string
     */
    protected $table = 'statistics';

}
