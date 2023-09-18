<?php

namespace App\Filters;


use Illuminate\Http\Request;


class ApiFilter {

    protected $safeParams = [];

    protected $columnMap = [];

    protected $operationMap = [];

    public function transform(Request $request) {
        $eloQuery = [];

        foreach ($this->safeParams as $param => $operators){
            $query = $request->query($param);

            if (!isset($query)){
                continue;
            }

            $column = $this->columnMap[$param] ?? $param;

            foreach ($operators as $operator) {
                if (isset($query[$operator])) {
                    $eloQuery[] = [$column, $this->operationMap[$operator], $query[$operator]];
                }
            }
        }
        return $eloQuery;
    }
}