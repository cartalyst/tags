<?php

/**
 * Part of the Tags package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Tags
 * @version    8.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2019, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Tags;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class IlluminateTag extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'tags';

    /**
     * {@inheritdoc}
     */
    public $timestamps = false;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'name',
        'slug',
        'count',
        'namespace',
    ];

    /**
     * The tagged entities model.
     *
     * @var string
     */
    protected static $taggedModel = 'Cartalyst\Tags\IlluminateTagged';

    /**
     * {@inheritdoc}
     */
    public function delete()
    {
        if ($this->exists) {
            $this->tagged()->delete();
        }

        return parent::delete();
    }

    /**
     * Returns the polymorphic relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function taggable()
    {
        return $this->morphTo();
    }

    /**
     * Returns this tag tagged entities.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tagged()
    {
        return $this->hasMany(static::$taggedModel, 'tag_id');
    }

    /**
     * Finds a tag by its name.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $name
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeName(Builder $query, $name)
    {
        return $query->whereName($name);
    }

    /**
     * Finds a tag by its slug.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $slug
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSlug(Builder $query, $slug)
    {
        return $query->whereSlug($slug);
    }

    /**
     * Returns the tagged entities model.
     *
     * @return string
     */
    public static function getTaggedModel()
    {
        return static::$taggedModel;
    }

    /**
     * Sets the tagged entities model.
     *
     * @param  string  $taggedModel
     * @return void
     */
    public static function setTaggedModel($taggedModel)
    {
        static::$taggedModel = $taggedModel;
    }
}
