<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait CreatedUpdatedBy
{
	public static function bootCreatedUpdatedBy()
    {
        static::creating(function ($model) {
            $model->created_by = is_object(Auth::guard(config('app.guards.web'))->user()) ? Auth::guard(config('app.guards.web'))->user()->id : 0;
            $model->updated_by = NULL;
        });

        static::updating(function ($model) {
            $model->updated_by = is_object(Auth::guard(config('app.guards.web'))->user()) ? Auth::guard(config('app.guards.web'))->user()->id : 0;
        });
    }
}