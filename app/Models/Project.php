<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';

    protected $primaryKey = 'project_id';

    protected $fillable = [
        'project_name',
        'project_description',
    ];

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'project_id', 'project_id');
    }
}
