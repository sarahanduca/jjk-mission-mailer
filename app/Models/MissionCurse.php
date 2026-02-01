<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MissionCurse extends Model
{
    use HasFactory;

    protected $fillable = [
        'mission_id',
        'curse_id',
        'is_primary_target',
    ];

    protected $casts = [
        'is_primary_target' => 'boolean',
        'created_at'        => 'datetime',
        'updated_at'        => 'datetime',
    ];

    public function mission(): BelongsTo
    {
        return $this->belongsTo(Mission::class);
    }

    public function curse(): BelongsTo
    {
        return $this->belongsTo(Curse::class);
    }
}
