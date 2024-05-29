<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $connection = 'mysql_2';
    protected $table = "transaction";
    protected $primaryKey = "transactionId";
    public $timestamps = false;

    protected $fillable = 
    [
        'transactionDate',
        'transactionDiscount',
        'transactionTax',
        'transactionTotal',
        'transactionDetails',
        'transactionUnitsSold',
        'transactionPaymentType',
        'transactionType',
        'transactionName',
        'transactionNote',
        'transactionParentId',
        'transactionComplete',
        'transactionLocation',
        'transactionDueDate',
        'transactionStatus',
        'transactionUID',
        'transactionCurrency',
        'fromDate',
        'toDate',
        'invoiceNo',
        'invoicePrefix',
        'tags',
        'tableno',
        'timestamp',
        'packageId',
        'categoryTransId',
        'customerId',
        'registerId',
        'userId',
        'responsibleId',
        'supplierId',
        'outletId',
        'companyId',
        'orderLastUpdate',
    ];
}
