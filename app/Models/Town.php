<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Town extends Model
{
     /**
     * @var array
     */
    protected $fillable = ['confirmed', 'active', 'recovered', 'local', 'imported'];

    /**
     * [$touches description]
     * @var [type]
     */
    protected $touches = ['district', 'region'];

    /**
     * [$table description]
     * @var string
     */
    protected $table = 'towns';

    /**
     * @return mixed
     */
    public function district()
    {
        return $this->belongsTo(District::class);
    }
    
    /**
     * [region description]
     * @return [type] [description]
     */
    public function region(){

         return $this->belongsTo(Region::class);
    }
   
}
