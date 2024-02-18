<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BeLongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Carbon\Carbon;
use App\Models\Label;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status_id',
        'created_by_id',
        'assigned_to_id'
    ];

    public function status(): BeLongsTo
    {
        return $this->belongsTo(TaskStatus::class, 'status_id');
    }

    public function creator(): BeLongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function executor(): BeLongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }

    public function labels(): BelongsToMany
    {
        return $this->belongsToMany(Label::class);
    }

    protected function formattedDate(): Attribute
    {
        return Attribute::make(
            get: fn() => Carbon::parse($this->created_at)->format('d.m.Y'),
        );
    }
}
