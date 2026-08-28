<?php

namespace App\Models\Concerns;

use Illuminate\Support\Collection;

trait HasOptions
{
    /** @return Collection<int, string> */
    public static function options(): Collection
    {
        return static::orderBy('name')->pluck('name', 'id');
    }
}
