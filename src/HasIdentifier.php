<?php
namespace Brainstud\HasIdentifier;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

/**
 * @property string $short_identifier
 * @property string $identifier_value
 * @method static Builder identifiedBy(string $identifier)
 */
trait HasIdentifier
{
    protected static function bootHasIdentifier()
    {
        // Clear the uuid attribute when the model is replicating to force a new uuid
        static::replicating(function ($model) {
            if (isset($model->identifierAttribute) && !empty($model->identifierAttribute)) {
                $model->{$model->identifierAttribute} = null;
            } else {
                $model->identifier = null;
            }
        });

        static::creating(function ($model) {
            if (empty($model->identifier_value)) {
                if (isset($model->identifierAttribute) && !empty($model->identifierAttribute)) {
                    $model->{$model->identifierAttribute} = Str::uuid();
                } else {
                    $model->identifier = Str::uuid();
                }
            }
        });
    }

    /**
     * @param Builder $query
     * @param string $identifier
     * @return Builder
     */
    public function scopeIdentifiedBy(Builder $query, string $identifier): Builder
    {
        $identifierAttribute = $this->identifierAttribute ?? 'identifier';

        return $query->where($identifierAttribute, $identifier);
    }

    public static function findByIdentifier(string $identifier)
    {
        return (new self)->identifiedBy($identifier)->first();
    }

    public static function findOrFailByIdentifier(string $identifier)
    {
        return (new self)->identifiedBy($identifier)->firstOrFail();
    }

    public function getIdentifierValueAttribute()
    {
        if (isset($this->identifierAttribute) && !empty($this->identifierAttribute)) {
            return $this->{$this->identifierAttribute};
        } else {
            return $this->identifier;
        }
    }

    public function getShortIdentifierAttribute(): string
    {
        return substr($this->getIdentifierValueAttribute(), 0, 8);
    }

    public function getRouteKeyName(): string
    {
        return $this->identifierAttribute ?? 'identifier';
    }
}
