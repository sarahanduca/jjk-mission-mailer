<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Curse extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'curse_level',
        'curse_type',
        'abilities',
        'known_weaknesses',
        'status',
        'first_sighted_at',
    ];

    protected $casts = [
        'first_sighted_at' => 'datetime',
        'created_at'       => 'datetime',
        'updated_at'       => 'datetime',
    ];

    public function missions(): BelongsToMany
    {
        return $this->belongsToMany(Mission::class, 'mission_curses')
            ->withPivot('is_primary_target')
            ->withTimestamps();
    }

    public function missionCurses(): HasMany
    {
        return $this->hasMany(MissionCurse::class);
    }
}
