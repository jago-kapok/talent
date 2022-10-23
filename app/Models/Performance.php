<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Performance extends Model
{
    use HasFactory, SoftDeletes;

    protected $table        = 'performance_result';
    protected $primaryKey   = 'performance_id';
    protected $guarded      = ['performance_id'];
}
