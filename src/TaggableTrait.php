<?php

/*
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
 * @version    15.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2025, Cartalyst LLC
 * @link       https://cartalyst.com
 */

namespace Cartalyst\Tags;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/** @property Collection<IlluminateTag> $tags */
trait TaggableTrait
{
    /**
     * The tags delimiter.
     *
     * @var string
     */
    protected static $delimiter = ',';

    /**
     * The Eloquent tags model name.
     *
     * @var string
     */
    protected static $tagsModel = 'Cartalyst\Tags\IlluminateTag';

    /**
     * The Slug generator method.
     *
     * @var string
     */
    protected static $slugGenerator = 'Illuminate\Support\Str::slug';

    /**
     * {@inheritdoc}
     */
    public static function getTagsDelimiter(): string
    {
        return static::$delimiter;
    }

    /**
     * {@inheritdoc}
     */
    public static function setTagsDelimiter(string $delimiter): void
    {
        static::$delimiter = $delimiter;
    }

    /**
     * {@inheritdoc}
     */
    public static function getTagsModel(): string
    {
        return static::$tagsModel;
    }

    /**
     * {@inheritdoc}
     */
    public static function setTagsModel(string $model): void
    {
        static::$tagsModel = $model;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSlugGenerator()
    {
        return static::$slugGenerator;
    }

    /**
     * {@inheritdoc}
     */
    public static function setSlugGenerator($slugGenerator): void
    {
        static::$slugGenerator = $slugGenerator;
    }

    /**
     * {@inheritdoc}
     */
    public function tags(): MorphToMany
    {
        return $this->morphToMany(static::$tagsModel, 'taggable', 'tagged', 'taggable_id', 'tag_id');
    }

    /**
     * {@inheritdoc}
     */
    public static function allTags(): Builder
    {
        $instance = new static();

        return $instance->createTagsModel()->whereNamespace(
            $instance->getEntityClassName()
        );
    }

    /**
     * {@inheritdoc}
     */
    public static function scopeWhereTag(Builder $query, $tags, string $type = 'slug'): Builder
    {
        $tags = (new static())->prepareTags($tags);

        foreach ($tags as $tag) {
            $query->whereHas('tags', function ($query) use ($type, $tag) {
                $query->where($type, $tag);
            });
        }

        return $query;
    }

    /**
     * {@inheritdoc}
     */
    public static function scopeWithTag(Builder $query, $tags, string $type = 'slug'): Builder
    {
        $tags = (new static())->prepareTags($tags);

        return $query->whereHas('tags', function ($query) use ($type, $tags) {
            $query->whereIn($type, $tags);
        });
    }

    /**
     * {@inheritdoc}
     */
    public static function scopeWithoutTag(Builder $query, $tags, string $type = 'slug'): Builder
    {
        $tags = (new static())->prepareTags($tags);

        return $query->whereDoesntHave('tags', function ($query) use ($type, $tags) {
            $query->whereIn($type, $tags);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function tag($tags): bool
    {
        foreach ($this->prepareTags($tags) as $tag) {
            $this->addTag($tag);
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function untag($tags = null): bool
    {
        if (empty($tags)) {
            $tags = $this->tags;
            if (!empty($tags)) {
                $this->tags()->detach();
                foreach ($tags as $tag) {
                    $tag->update(['count' => $tag->count - 1]);
                }
                $this->tags = new Collection();
            }
        } else {
            foreach ($this->prepareTags($tags) as $tag) {
                $this->removeTag($tag);
            }
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function setTags($tags, string $type = 'name'): bool
    {
        // Prepare the tags
        $tags = $this->prepareTags($tags);

        // Get the current entity tags
        $entityTags = $this->tags->pluck($type)->all();

        // Prepare the tags to be added and removed
        $tagsToAdd = array_diff($tags, $entityTags);
        $tagsToDel = array_diff($entityTags, $tags);

        // Detach the tags
        if (! empty($tagsToDel)) {
            $this->untag($tagsToDel);
        }

        // Attach the tags
        if (! empty($tagsToAdd)) {
            $this->tag($tagsToAdd);
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function addTag(string $name): void
    {
        /** @var IlluminateTag $tag */
        $tag = $this->createTagsModel()->firstOrCreate([
            'slug'      => $this->generateTagSlug($name),
            'namespace' => $this->getEntityClassName(),
        ],  [
            'count' => 1,
            'name' => $name,
        ]);

        if ($tag->wasRecentlyCreated || !$this->tags()->whereKey($tag)->exists()) {
            if (!$tag->wasRecentlyCreated) {
                $tag->update(['count' => $tag->count + 1]);
            }
            $this->tags()->attach($tag);
            if ($this->relationLoaded('tags')) {
                $this->tags->add($tag);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeTag(string $name): void
    {
        $slug = $this->generateTagSlug($name);

        $namespace = $this->getEntityClassName();

        /** @var IlluminateTag $tag */
        $tag = $this->tags()
            ->whereNamespace($namespace)
            ->where(function ($query) use ($name, $slug) {
                $query
                    ->orWhere('name', '=', $name)
                    ->orWhere('slug', '=', $slug)
                ;
            })
            ->first()
        ;

        if ($tag) {
            $tag->update(['count' => $tag->count - 1]);
            $this->tags()->detach($tag);

            if ($this->relationLoaded('tags')) {
                foreach($this->tags as $key => $loadedTag) {
                    if ($loadedTag->getKey() === $tag->getKey()) {
                        unset($this->tags[$key]);
                        break;
                    }
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function prepareTags($tags): array
    {
        if (is_null($tags)) {
            return [];
        }

        if (is_string($tags)) {
            $delimiter = preg_quote($this->getTagsDelimiter(), '#');

            $tags = array_map('trim',
                preg_split("#[{$delimiter}]#", $tags, null, PREG_SPLIT_NO_EMPTY)
            );
        }

        return array_unique(array_filter($tags));
    }

    /**
     * {@inheritdoc}
     */
    public static function createTagsModel(): Model
    {
        return new static::$tagsModel();
    }

    /**
     * Generate the tag slug using the given name.
     *
     * @param string $name
     *
     * @return string
     */
    protected function generateTagSlug(string $name): string
    {
        return call_user_func(static::$slugGenerator, $name);
    }

    /**
     * Returns the entity class name.
     *
     * @return string
     */
    protected function getEntityClassName(): string
    {
        if (isset(static::$entityNamespace)) {
            return static::$entityNamespace;
        }

        return $this->tags()->getMorphClass();
    }
}
