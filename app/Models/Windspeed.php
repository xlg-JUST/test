<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class Windspeed extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'windspeed';

    public function windspeed()
    {
        return $this->belongsTo(Dustlevel::class, 'id');
    }
}
