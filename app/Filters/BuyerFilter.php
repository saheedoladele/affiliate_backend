<?php

namespace App\Filters;

use App\Filters\ApiFilter;
use Illuminate\Http\Request;


class BuyerFilter extends ApiFilter {

protected $safeParams = [
'userId' => ['eq'],
'propertyId' => ['eq'],
'clientId' => ['eq'],
'amountPaid' => ['eq','lt','gt'],
'purchaseDate' => ['eq','lt','gt'],

];


protected $columnMap = [
'clientId' => 'client_id',
'userId' => 'user_name',
'propertyId' => 'property_name',
'amountPaid' => 'amount_paid',
'purchaseDate' => 'purchase_date',

];

protected $operationMap = [
'eq' => '=',
'lt' => '<',
'gt'=> '>',
'lte' => '<=',
 'gte'=> '>='
];

}