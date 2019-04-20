<?php

declare(strict_types=1);

namespace VOSTPT\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use LengthException;

class Occurrence extends Model
{
    /**
     * {@inheritDoc}
     */
    protected $table = 'occurrences';

    /**
     * {@inheritDoc}
     */
    protected $casts = [
        'latitude'  => 'float',
        'longitude' => 'float',
    ];

    /**
     * {@inheritDoc}
     */
    protected $dates = [
        'started_at',
        'ended_at',
    ];

    /**
     * Associated Event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Associated Parish.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parish(): BelongsTo
    {
        return $this->belongsTo(Parish::class);
    }

    /**
     * Associated source.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function source(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Set the locality.
     *
     * @param string $locality
     *
     * @throws \LengthException
     *
     * @return void
     */
    public function setNameAttribute(string $locality): void
    {
        if (\mb_strlen($locality) > 255) {
            throw new LengthException('The locality cannot exceed 255 characters');
        }

        $this->attributes['locality'] = $locality;
    }

    /**
     * Set the latitude.
     *
     * @param float $latitude
     *
     * @return void
     */
    public function setLatitudeAttribute(float $latitude): void
    {
        $this->attributes['latitude'] = $latitude;
    }

    /**
     * Set the longitude.
     *
     * @param float $longitude
     *
     * @return void
     */
    public function setLongitudeAttribute(float $longitude): void
    {
        $this->attributes['longitude'] = $longitude;
    }

    /**
     * Set the Started at value.
     *
     * @param DateTime $startedAt
     *
     * @return void
     */
    public function setStartedAtAttribute(DateTime $startedAt): void
    {
        $this->attributes['started_at'] = $startedAt;
    }

    /**
     * Set the Ended at value.
     *
     * @param DateTime $endedAt
     *
     * @return void
     */
    public function setEndedAtAttribute(DateTime $endedAt = null): void
    {
        $this->attributes['ended_at'] = $endedAt;
    }
}
