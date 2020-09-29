<?php

namespace App\Imports;

use Modules\HR\Entities\User;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        dd($row);
        return new User([
            'id' => $row[0],
        ]);
    }
}
