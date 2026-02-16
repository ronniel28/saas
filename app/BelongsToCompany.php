<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;

trait BelongsToCompany
{
    protected static function bootBelongsToCompany()
    {
        static::creating(function ($model) {
            if (auth()->check() && empty($model->company_id)) {
                $model->company_id = auth()->user()->company_id;
            }
        });

        static::addGlobalScope('company', function (Builder $builder) {
            if (auth()->check() && ! auth()->user()->is_super_admin) {
                $builder->where(
                    $builder->getModel()->getTable() . '.company_id',
                    auth()->user()->company_id
                );
            }
        });

    }

}
