<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [''];

    protected $casts = [
        'title'       => 'string',
        'description' => 'string',
        'status'      => 'string',
        'due_date'    => 'date',
    ];

    public function scopeSearchTitle($query, ?string $search)
    {
        return $query->when(
            filled($search),
            fn ($q) => $q->where('title', 'LIKE', "%{$search}%")
        );
    }

    public function scopeFilterDueDate($query, ?string $date)
    {
        return $query->when(
            filled($date),
            fn ($q) => $q->whereDate('due_date', $date)
        );
    }

    public function scopeFilterStatus($query, ?string $status)
    {
        return $query->when(
            filled($status),
            fn ($q) => $q->where('status', $status)
        );
    }

}
