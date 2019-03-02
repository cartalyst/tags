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

class IlluminateTagged extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'tagged';

    /**
     * {@inheritdoc}
     */
    public $timestamps = false;
}
