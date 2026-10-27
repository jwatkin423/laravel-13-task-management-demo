<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property $task_id
 * @method static find(int $taskId)
 */
class Task extends Model
{
    use hasFactory;

    protected $table = 'tasks';

    protected $primaryKey = 'task_id';

    protected $fillable = [
        'name',
        'description',
        'priority',
        'status',
    ];

    public function projects(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id', 'project_id');
    }
}
