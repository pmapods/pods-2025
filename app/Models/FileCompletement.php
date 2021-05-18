<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileCompletement extends Model
{
    protected $table = 'file_completement';
    protected $primaryKey = 'id';

    public function file_category(){
        return $this->belongsTo(FileCategory::class);
    }
}
