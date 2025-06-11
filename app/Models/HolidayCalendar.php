<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HolidayCalendar extends Model
{
    use SoftDeletes;
    protected $table = 'holiday_calendar';
    protected $primaryKey = 'id';
}
