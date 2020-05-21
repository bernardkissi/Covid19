<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
     /**
     * @var array
     */
    protected $fillable = ['name', 'confirmed', 'active', 'recovered', 'deceased'];

    /**
     * [$table description]
     * @var string
     */
    protected $table = 'regions';

     /**
     * @var array
     */
    protected $with = ['districts'];


    /**
     * @return mixed
     */
    public function districts()
    {
        return $this->hasMany(District::class);
    }

    public function towns()
    {
        return $this->hasManyThrough(Town::class, District::class);
    }
}
