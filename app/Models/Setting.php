<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $connection = 'mysql_2';
    protected $table        = "setting";
    protected $primarykey   = "settingId";
    public $timestamps      = false;

}
