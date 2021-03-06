<?php

namespace Screeenly;

use Screeenly\Screenshot\Screenshot;

class ApiLog extends \Eloquent
{
    protected $fillable = ['images'];

    protected $table = 'api_log';

    public static function store(Screenshot $screenshot, User $user, ApiKey $apiKey)
    {
        $log = new self();
        $log->images = $screenshot->storagePath;
        $log->user()->associate($user);

        if (! is_null($apiKey)) {
            $log->apiKey()->associate($apiKey);
        }

        $log->save();

        return $log;
    }

    /**
     * Relationships.
     **/
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship with the ApiKey model.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function apiKey()
    {
        return $this->belongsTo(ApiKey::class);
    }
}
