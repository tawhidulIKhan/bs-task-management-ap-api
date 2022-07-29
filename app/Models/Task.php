<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'assigned_to',
        'assigned_by',
        'assigned_at',
        'created_at',
        'updated_at'
    ];

    public function assigner()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function assigned()
    {
        return $this->belongsTo(Member::class, 'assigned_to');
    }

}
