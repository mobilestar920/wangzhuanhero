<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apps extends Model
{
    protected $table = 'apps';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'version', 'package_name'
    ];

    public function rAppResources() {
        return $this->hasMany(AppResources::class, 'app_id');
    }
}
