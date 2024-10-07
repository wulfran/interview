<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Team
 *
 * @property int $id
 * @property string $name
 * @property int $points
 * @property int $matches_played
 * @property int $wins
 * @property int $draws
 * @property int $loses
 * @property int $goal_balance
 */
class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'points',
        'matches_played',
        'wins',
        'draws',
        'loses',
        'goal_balance',
    ];

    public $timestamps = false;
}
