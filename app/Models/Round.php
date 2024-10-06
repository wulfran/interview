<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Round extends Model
{
    use HasFactory;

    protected $fillable = [
        'home_team_id',
        'guest_team_id',
        'home_team_goals',
        'guest_team_goals',
    ];

    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
    public function questTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
