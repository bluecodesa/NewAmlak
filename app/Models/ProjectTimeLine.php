<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTimeLine extends Model
{
    protected $guarded = [];

    public function StatusData()
    {
        return $this->belongsTo(ProjectStatus::class, 'status_id');
    }
    public function DeliveryData()
    {
        return $this->belongsTo(DeliveryCase::class, 'delivery_id');
    }
    public function ProjectData()
    {
        return $this->belongsTo(ProjectTimeLine::class, 'project_id');
    }
}
