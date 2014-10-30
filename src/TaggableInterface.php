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

interface TaggableInterface {

	/**
	 * Returns the Eloquent tags model name.
	 *
	 * @return string
	 */
	public static function getTagsModel();

	/**
	 * Sets the Eloquent tags model name.
	 *
	 * @param  string  $model
	 * @return void
	 */
	public static function setTagsModel($model);

	/**
	 * Returns the slug generator.
	 *
	 * @return string
	 */
	public static function getSlugGenerator();

	/**
	 * Sets the slug generator.
	 *
	 * @param  string  $name
	 * @return void
	 */
	public static function setSlugGenerator($name);

	/**
	 * Returns the entity Eloquent tag model object.
	 *
	 * @return \Cartalyst\Tags\IlluminateTag
	 */
	public function tags();

	/**
	 * Returns the tags delimiters.
	 *
	 * @return string
	 */
	public function getTagsDelimiters();

	/**
	 * Sets the tags delimiters.
	 *
	 * @param  string  $delimiters
	 * @return $this
	 */
	public function setTagsDelimiters($delimiters);

	/**
	 *
	 *
	 * @param  mixed  $tags
	 * @return array
	 */
	protected function prepareTags($tags);

}
