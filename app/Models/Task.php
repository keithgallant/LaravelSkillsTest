<?php

namespace App\Models;

use Database\Factories\TaskFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{

    public $timestamps = true;
    /** @use HasFactory<TaskFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'priority',
        'project_id'
    ];

    protected $with = [
        'project'
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    protected static function booted()
    {
        static::addGlobalScope('order', function ($builder) {
            $builder->orderBy('priority', 'asc');
        });
    }
}
