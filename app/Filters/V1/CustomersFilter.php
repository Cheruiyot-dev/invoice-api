<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class CustomersFilter extends ApiFilter
{
    protected $safeParams = [ //Defines safe parameters and their allowed operators.
        // 'equal to => eq', 'less than => lt', 'greater than => gt'
'id' => ['eq'],
        'name' => ['eq'],
        'type' => ['eq'],
        'email' => ['eq'],
        'address' => ['eq'],
        'city' => ['eq'],
        'state' => ['eq'],
        'postalCode'  => ['eq', 'gt', 'lt']
    ];
    protected $columnMap = [//Maps query parameters to database columns if they differ.
        'postalCode' => 'postal_code'
    ];

    protected $operatorMap = [ //Maps query operators to SQL/ Eloquent operators.
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>=',
    ];

    public function transform(Request $request)
    {
     $eloQuery = []; //array to pass to eloquent
     foreach($this->safeParams as $parm => $operators){
        $query = $request->query($parm);
        if(!isset($query)) {
            continue;
        }

        $column = $this->columnMap[$parm] ?? $parm;
        foreach($operators as $operator) {
            if(isset($query[$operator])) {
                $eloQuery[] = [$column, $this->operatorMap[$operator], $query[$operator]];
            }
        }

     }


     return $eloQuery;
    }
}
