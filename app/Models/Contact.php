<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $table = "contact";
    protected $primaryKey = "contactId";
    protected $connection = 'mysql_2';
    public $timestamps = false;
    protected $fillable =[
        // 'contactId',
        'contactRealId',
        'contactUID',
        'contactName',
        'contactSecondName',
        'contactEmail',
        'contactAddress',
        'contactAddress2',
        'contactPhone',
        'contactPhone2',
        'contactNote',
        'contactCity',
        'contactLocation',
        'contactCountry',
        'contactTIN',
        'contactCI',
        'contactDate',
        'contactBirthDay',
        'contactPassword',
        'contactLoyalty',
        'contactLoyaltyAmount',
        'contactStoreCredit',
        'contactCreditable',
        'contactCreditLine',
        'contactStatus',
        'contactGender',
        'contactColor',
        'contactInCalendar',
        'contactCalendarPosition',
        'contactTrackLocation',
        'contactLastNotificationSeen',
        'contactFixedComission',
        'contactLatLng',
        'categoryId',
        'data',
        'type',
        'debtLastNotify',
        'main',
        'role',
        'lockPass',
        'salt',
        'parentId',
        'userId',
        'outletId',
        'companyId',
        'customersLastUpdate',
    ];
}
