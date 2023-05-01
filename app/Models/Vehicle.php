<?php

namespace App\Models;

use App\Observers\VehicleObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'plate_number'];

    public static function boot() {

        parent::boot();

        static::observe([VehicleObserver::class]);
    }

    public static function booted() {

        static::addGlobalScope('user', function(Builder $builder) {
            $builder->where('user_id', auth()->id());
        });
    }
}
