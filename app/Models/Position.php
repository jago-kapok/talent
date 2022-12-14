<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $table        = 'position';
    protected $primaryKey   = 'position_id';
    protected $guarded      = ['position_id'];
    public $timestamps      = false;

    public function employee()
    {
        return $this->hasMany(Employee::class, 'position_id', 'position_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }
}
