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

    public $timestamps = false;

    private const MATCHES_SETUP = [
        0 => [
            [0, 1],
            [2, 3],
        ],
        1 => [
            [0, 2],
            [1, 3],
        ],
        2 => [
            [0, 3],
            [1, 2],
        ],
        3 => [
            [1, 0],
            [3, 2],
        ],
    ];

    public const TOTAL_ROUNDS = 12;

    private const ROUNDS_LIMIT = 4;

    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function guestTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'guest_team_id');
    }

    public static function getMatchesSetup(): array
    {
        return self::MATCHES_SETUP;
    }

    public static function getSetupByRound(int $round): array
    {
        return self::MATCHES_SETUP[$round];
    }

    public static function getRoundsLimit(): int
    {
        return self::ROUNDS_LIMIT;
    }
}
