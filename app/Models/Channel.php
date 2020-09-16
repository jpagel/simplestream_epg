<?php

namespace App\Models;

use App\Models\Programme;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Channel extends Model
{
    use HasFactory;

    public $table = 'channel';
    public $timestamps = false;

    protected $fillable = [
        'uuid',
        'visible_name',
        'icon_ref'
    ];

    public static function getByUuid(string $uuid): self
    {
        return self::where([
            'uuid' => $uuid
        ])->first();
    }

    public function programmes(): HasMany
    {
        return $this->hasMany(Programme::class, 'id', 'programme_id');
    }

    public function getProgrammesByDateTime(): Collection
    {
        return $this->programmes()->get();
    }
}
