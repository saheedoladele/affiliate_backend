<?php

namespace App\Filters;

use App\Filters\ApiFilter;
use Illuminate\Http\Request;


class UserFilter extends ApiFilter {

    protected $safeParams = [
        'firstName' => ['eq'],
        'lastName' => ['eq'],
        'email' => ['eq'],
        'location' => ['eq'],
        'bankName' => ['eq'],
        'phoneNumber' => ['eq'],
        // 'amount_paid' => ['eq','lt','gt']
    ];

    protected $columnMap = [
        'firstName' => 'first_name',
        'lastName' => 'last_name',
        'bankName' => 'bank_name',
        'phoneNumber' => 'phone_number'
    ];

    protected $operationMap = [
        'eq' => '=',
        'lt' => '<',
        'gt' => '>',
        'lte' => '<=',
        'gte' => '>='
    ];

}