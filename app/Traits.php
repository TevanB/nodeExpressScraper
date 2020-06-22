<?php

namespace App\Traits;

trait Uuids
{
    /**
     *
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->uuid} =
            str_replace('-', '', \Uuid::generate(4)->string);
        });
    }
}
