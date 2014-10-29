<?php namespace Cartalyst\Tags;
/**
 * Part of the Tags package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the license.txt file.
 *
 * @package    Tags
 * @version    1.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2014, Cartalyst LLC
 * @link       http://cartalyst.com
 */

trait TaggableTrait {

	/**
	 * The Eloquent tags model name.
	 *
	 * @var string
	 */
	protected static $tagsModel = 'Cartalyst\Tags\IlluminateTag';

	/**
	 * The tags delimiter.
	 *
	 * @var string
	 */
	protected static $delimiter = ',';

	/**
	 * {@inheritDoc}
	 */
	public static function getTagsModel()
	{
		return static::$tagsModel;
	}

	/**
	 * {@inheritDoc}
	 */
	public static function setTagsModel($model)
	{
		static::$tagsModel = $model;
	}

	/**
	 * {@inheritDoc}
	 */
	public function tags()
	{
		return $this->morphToMany(static::$tagsModel, 'taggable', 'taggables', 'taggable_id', 'tag_id');
	}

	/**
	 * {@inheritDoc}
	 */
	public function tag($tags)
	{
		foreach ($this->prepareTags($tags) as $tag)
		{
			$this->addTag($tag);
		}

		return $this;
	}

	/**
	 * {@inheritDoc}
	 */
	public function untag($tags)
	{
		foreach ($this->prepareTags($tags) as $tag)
		{
			$this->removeTag($tag);
		}

		return $this;
	}

	/**
	 * {@inheritDoc}
	 */
	public static function getTagsDelimiter()
	{
		return static::$delimiter;
	}

	/**
	 * {@inheritDoc}
	 */
	public static function setTagsDelimiter($delimiter)
	{
		static::$delimiter = $delimiter;

		return get_called_class();
	}

	/**
	 * Attach a tag to the entity.
	 *
	 * @param  string  $name
	 * @return void
	 */
	protected function addTag($name)
	{
		$tag = $this->createTagsModel()->firstOrCreate(compact('name'));

		if ( ! $this->tags->contains($tag->id))
		{
			$tag->update([ 'count' => $tag->count + 1 ]);

			$this->tags()->attach($tag);
		}
	}

	/**
	 * Detach a tag from the entity.
	 *
	 * @param  string  $name
	 * @return void
	 */
	protected function removeTag($name)
	{
		if ($tag = $this->createTagsModel()->findByName($name))
		{
			$tag->update([ 'count' => $tag->count - 1 ]);

			$this->tags()->detach($tag);
		}
	}

	/**
	 * Prepares the given tags before being saved.
	 *
	 * @param  string|array  $tags
	 * @return array
	 */
	protected function prepareTags($tags)
	{
		if (is_string($tags))
		{
			$delimiter = preg_quote($this->getTagsDelimiter(), '#');

			$tags = array_map('trim',
				preg_split("#[{$delimiter}]#", $tags, null, PREG_SPLIT_NO_EMPTY)
			);
		}

		return (array) array_unique(array_filter($tags));
	}

	/**
	 * Creates a new model instance.
	 *
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	protected function createTagsModel()
	{
		return new static::$tagsModel;
	}

}
