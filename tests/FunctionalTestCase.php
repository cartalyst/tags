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

namespace Cartalyst\Tags\Tests;

use Cartalyst\Tags\Tests\Stubs\Post;
use Illuminate\Support\Facades\Schema;

class FunctionalTestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom([
            '--database' => 'testbench',
            '--realpath' => realpath(__DIR__.'/../resources/migrations'),
        ]);

        Schema::create('posts', function ($table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('title');
        });
    }

    /**
     * {@inheritdoc}
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['path.base'] = __DIR__.'/../src';
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getPackageProviders($app)
    {
        return [
            'Cartalyst\Tags\TagsServiceProvider',
        ];
    }

    /**
     * Creates a new post.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function createPost()
    {
        return Post::create([ 'title' => 'My Test Post' ]);
    }
}
