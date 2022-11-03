<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetencyItem extends Model
{
    use HasFactory;

    protected $table        = 'competency';
    protected $primaryKey   = 'competency_id';
    protected $guarded      = ['competency_id'];
    public $timestamps      = false;
}
