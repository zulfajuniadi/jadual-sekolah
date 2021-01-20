<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class MyChildScope implements Scope
{
    public function apply(Builder $builder, Model $model) { 
        $id = backpack_user() ? backpack_user()->id : null;
        $builder->where('user_id', $id);
    }
}