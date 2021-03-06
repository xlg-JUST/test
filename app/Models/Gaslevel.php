<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class Gaslevel extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'gaslevel';

    public function dustlevel()
    {
        return $this->belongsTo(Dustlevel::class,'id');
    }

}
