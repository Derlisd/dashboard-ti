<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemSold extends Model
{
    use HasFactory;
    protected $connection = 'mysql_2';

    protected $table        = "itemSold";
    protected $primaryKey   = "itemSoldId";
    protected $fillable      =  
    [
    'itemSoldId',
    'itemSoldTotal',
    'itemSoldTax',
    'itemSoldDate',
    'itemSoldUnits',
    'itemSoldDiscount',
    'itemSoldCOGS',
    'itemSoldComission',
    'itemSoldDescription',
    'itemSoldParent',
    'itemSoldCategory',
    'itemId',
    'userId',
    'transactionId',
    ];
    public $timestamps      = false;
}
