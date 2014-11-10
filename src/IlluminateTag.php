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

use Illuminate\Database\Eloquent\Model;

class IlluminateTag extends Model {

	/**
	 * {@inheritDoc}
	 */
	public $timestamps = false;

	/**
	 * {@inheritDoc}
	 */
	public $table = 'tags';

	/**
	 * {@inheritDoc}
	 */
	protected $fillable = [
		'name',
		'slug',
		'count',
		'namespace',
	];

	/**
	 * Returns the polymorphic relationship.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\MorphTo
	 */
	public function taggable()
	{
		return $this->morphTo();
	}

}
