<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class Label extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class);
    }

    public static function options(): Collection
    {
        return static::orderBy('name')->pluck('name', 'id');
    }
}
