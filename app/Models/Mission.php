<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mission extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'required_sorcerer_grade',
        'curse_level',
        'category',
        'location',
        'urgency_level',
        'status',
        'deadline',
    ];

    protected $casts = [
        'deadline'   => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function assignments(): HasMany
    {
        return $this->hasMany(MissionAssignment::class);
    }

    public function sorcerers(): BelongsToMany
    {
        return $this->belongsToMany(Sorcerer::class, 'mission_assignments')
            ->withPivot(['assigned_at', 'started_at', 'completed_at', 'result_status', 'casualties', 'mission_report'])
            ->withTimestamps();
    }

    public function curses(): BelongsToMany
    {
        return $this->belongsToMany(Curse::class, 'mission_curses')
            ->withPivot('is_primary_target')
            ->withTimestamps();
    }

    public function missionCurses(): HasMany
    {
        return $this->hasMany(MissionCurse::class);
    }
}
