<?php

namespace App\Filters;

use App\Filters\ApiFilter;
use Illuminate\Http\Request;


class ClientFilter extends ApiFilter {

protected $safeParams = [
'clientName' => ['eq'],
'email' => ['eq'],
'phoneNumber' => ['eq'],
'gender' => ['eq'],
'amountPaid' => ['eq','lt','gt'],
'purchaseDate' => ['eq','lt','gt'],

];


protected $columnMap = [
'clientName' => 'client_name',
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