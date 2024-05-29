<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VPayment extends Model
{
    use HasFactory;
    protected $table        = "vPayments";
    protected $primarykey   = "ID";
    protected $connection = 'mysql_2';
    public $timestamps      = false;
    protected $fillable     =  
    [
        // 'ID',
        'date',
        'payoutDate',
        'depositedDate',
        'amount',
        'payoutAmount',
        'comission',
        'tax',
        'deposited',
        'orderNo',
        'authCode',
        'operationNo',
        'inBank',
        'status',
        'UID',
        'source',
        'data',
        'customerId',
        'userId',
        'outletId',
        'companyId'
    ];
}
