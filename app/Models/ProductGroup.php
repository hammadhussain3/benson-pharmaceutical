<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductGroup
 *
 * @property $id
 * @property $name
 * @property $company_id
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class ProductGroup extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'company_id'];


}
