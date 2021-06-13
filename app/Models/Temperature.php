<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class Temperature extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'temperature';
    
}
