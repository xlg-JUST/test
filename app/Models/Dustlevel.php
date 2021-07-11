<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class Dustlevel extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'dustlevel';

    public function gaslevel()
    {
        return $this->hasOne(Gaslevel::class, 'id');
    }

    public function temperature()
    {
        return $this->hasOne(Temperature::class, 'id');
    }

    public function windspeed()
    {
        return $this->hasOne(Windspeed::class, 'id');
    }

}
