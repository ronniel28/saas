<?php

namespace App\Models;

use App\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes, BelongsToCompany;

    protected $guarded = [];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
