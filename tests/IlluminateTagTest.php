<?php namespace Cartalyst\Tags\Tests;

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
 * @version    1.0.2
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Mockery as m;
use PHPUnit_Framework_TestCase;
use Cartalyst\Tags\IlluminateTag;

class IlluminateTagTest extends PHPUnit_Framework_TestCase
{
    /**
     * Close mockery.
     *
     * @return void
     */
    public function tearDown()
    {
        m::close();
    }

    /** @test */
    public function it_can_delete_a_tag_and_its_tagged_relations()
    {
        $tag = m::mock('Cartalyst\Tags\IlluminateTag[tagged]');

        $this->addMockConnection($tag);

        $tag->exists = true;
        $tag->shouldReceive('tagged')
            ->once()
            ->andReturn($relationship = m::mock('Illuminate\Database\Eloquent\Relations\HasMany'));

        $relationship->shouldReceive('delete')
            ->once();

        $tag->getConnection()
            ->getQueryGrammar()
            ->shouldReceive('compileDelete');

        $tag->getConnection()
            ->shouldReceive('delete')
            ->once();

        $tag->delete();
    }

    /** @test */
    public function it_has_a_taggable_relationship()
    {
        $tag = new IlluminateTag;

        $this->addMockConnection($tag);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\MorphTo', $tag->taggable());
    }

    /** @test */
    public function it_has_a_tag_relationship()
    {
        $tag = new IlluminateTag;

        $this->addMockConnection($tag);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\HasMany', $tag->tagged());
    }

    /** @test */
    public function it_has_a_name_scope()
    {
        $tag = new IlluminateTag;

        $this->addMockConnection($tag);

        $query = m::mock('Illuminate\Database\Eloquent\Builder');

        $query
            ->shouldReceive('whereName')
            ->with('foo')
            ->once();

        $tag->scopeName($query, 'foo');

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\MorphTo', $tag->taggable());
    }

    /** @test */
    public function it_has_a_slug_scope()
    {
        $tag = new IlluminateTag;

        $this->addMockConnection($tag);

        $query = m::mock('Illuminate\Database\Eloquent\Builder');

        $query
            ->shouldReceive('whereSlug')
            ->with('foo')
            ->once();

        $tag->scopeSlug($query, 'foo');

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\MorphTo', $tag->taggable());
    }

    /** @test */
    public function it_can_get_and_set_the_tagged_model()
    {
        $tag = new IlluminateTag();

        $this->assertEquals('Cartalyst\Tags\IlluminateTagged', $tag->getTaggedModel());

        $tag->setTaggedModel('App\Models\TaggedModel');

        $this->assertEquals('App\Models\TaggedModel', $tag->getTaggedModel());
    }

    /**
     * Adds a mock connection to the object.
     *
     * @param  mixed  $model
     * @return void
     */
    protected function addMockConnection($model)
    {
        $model->setConnectionResolver(
            $resolver = m::mock('Illuminate\Database\ConnectionResolverInterface')
        );

        $resolver
            ->shouldReceive('connection')
            ->andReturn(m::mock('Illuminate\Database\Connection'));

        $model->getConnection()
            ->shouldReceive('getQueryGrammar')
            ->andReturn(m::mock('Illuminate\Database\Query\Grammars\Grammar'));

        $model->getConnection()
            ->shouldReceive('getPostProcessor')
            ->andReturn(m::mock('Illuminate\Database\Query\Processors\Processor'));
    }
}
