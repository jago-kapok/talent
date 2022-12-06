<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Str;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->getKey())
            {
                $model->{$model->getKeyName()} = (string) Str::random(10);
            }
        });
    }

    protected $table        = 'employee';
    protected $keyType      = 'string';
    protected $primaryKey   = 'employee_id';
    protected $guarded      = ['employee_id'];
    public $timestamps      = false;

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id', 'position_id');
    }
}
