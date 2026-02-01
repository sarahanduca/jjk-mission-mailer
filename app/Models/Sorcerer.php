<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sorcerer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'username',
        'sorcerer_grade',
        'technique',
        'affiliation',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function missionAssignments(): HasMany
    {
        return $this->hasMany(MissionAssignment::class);
    }

    public function missions()
    {
        return $this->hasManyThrough(
            Mission::class,
            MissionAssignment::class,
            'sorcerer_id',
            'id',
            'id',
            'mission_id'
        );
    }
}
