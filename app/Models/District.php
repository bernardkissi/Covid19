<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
     /**
     * @var array
     */
    protected $fillable = ['name', 'confirmed', 'active', 'recovered', 'deceased'];

    /**
     * [$touches description]
     * @var [type]
     */
    protected $with = ['towns'];

    /**
     * [$table description]
     * @var string
     */
    protected $table = 'districts';

    /**
     * @return mixed
     */
    public function towns()
    {
        return $this->hasMany(Town::class);
    }
    
    /**
     * [region description]
     * @return [type] [description]
     */
    public function region(){

         return $this->belongsTo(Region::class);
    }
   
}
