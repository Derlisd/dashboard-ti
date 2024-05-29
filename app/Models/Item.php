<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $connection = 'mysql_2';
    protected $table = "item";
    protected $primaryKey = "itemId";
    public $timestamps = false;
    protected $fillable = 
    [
        'itemId',
        'itemName',
        'itemDate',
        'itemSKU',
        'itemCost',
        'itemPrice',
        'itemDescription',
        'itemIsParent',
        'itemParentId',
        'itemType',
        'itemImage',
        'itemStatus',
        'itemTrackInventory',
        'itemCanSale',
        'itemTaxExcluded',
        'itemDiscount',
        'itemProcedure',
        'itemProduction',
        'itemComissionPercent',
        'itemComissionType',
        'itemPricePercent',
        'itemPriceType',
        'itemUOM',
        'itemWaste',
        'itemSessions',
        'itemDuration',
        'itemComboAddons',
        'itemUpsellDescription',
        'itemEcom',
        'itemFeatured',
        'itemDateHour',
        'itemCurrencies',
        'autoReOrder',
        'autoReOrderLevel',
        'data',
        'taxId',
        'brandId',
        'categoryId',
        'supplierId',
        'locationId',
        'outletId',
        'companyId',
        'updated_at',
        'itemSort',
        'inventoryMethod'
    ];

}
