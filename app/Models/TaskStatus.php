<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class TaskStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'status_id', 'id');
    }

    public static function options(): Collection
    {
        return static::orderBy('name')->pluck('name', 'id');
    }
}
