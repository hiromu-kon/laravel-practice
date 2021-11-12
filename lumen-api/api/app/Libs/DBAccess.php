<?php

namespace App\Libs;

use Illuminate\Http\Request;

class DBAccess
{

    public function execSelect(string $query, $binds = []) {

        return \DB::select($query, $binds);
    }
}
