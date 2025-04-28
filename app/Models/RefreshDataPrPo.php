<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

use App\Models\SalesPoint;

class RefreshDataPrPo extends Model
{
    use SoftDeletes;
    protected $table = 'refresh_data_log';
    protected $primaryKey = 'id';
}
