<?php

namespace App\Filters;

use App\Filters\ApiFilter;
use Illuminate\Http\Request;


class PropertyFilter extends ApiFilter {

    protected $safeParams = [
        'propertyName' => ['eq'],
        'deedofAssignment' => ['eq'],
        'cofo' => ['eq'],
        'location' => ['eq'],
        'actualPrice' => ['eq','lt','gt'],
        'promoPrice' => ['eq','lt','gt'],
        'surveyPrice' => ['eq','lt','gt']
    ];


    protected $columnMap = [
        'actualPrice' => 'actual_price',
        'promoPrice' => 'promo_price',
        'surveyPrice' => 'survey_price',
        'propertyName' => 'property_name',
        'cofo' => 'c_of_o',
        'deedofAssignment' => 'deed_of_assignment'
    ];

    protected $operationMap = [
        'eq' => '=',
        'lt' => '<',
        'gt' => '>',
        'lte' => '<=',
        'gte' => '>='
    ];

}