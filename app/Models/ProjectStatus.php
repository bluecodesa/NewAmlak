<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;


class ProjectStatus extends Model
{
    use Translatable;
    public $translatedAttributes = ['name'];
    protected $guarded = [];

    public function projects()
    {
        return $this->hasMany(Project::class, 'project_status_id');
    }
}


