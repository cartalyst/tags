<?php namespace Cartalyst\Tags\Tests;
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

use Mockery as m;
use PHPUnit_Framework_TestCase;
use Cartalyst\Tags\TaggableTrait;
use Cartalyst\Tags\TaggableInterface;
use Illuminate\Database\Eloquent\Model;

class TaggableTraitTest extends PHPUnit_Framework_TestCase {

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
	public function it_can_retrieve_tags()
	{
		$taggable = new Taggable;

		$this->addMockConnection($taggable);

		$this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\MorphToMany', $taggable->tags());
	}

	/** @test */
	public function it_can_retrieve_all_tags()
	{
		$taggable = new Taggable;

		$this->addMockConnection($taggable);

		$this->assertInstanceOf('Illuminate\Database\Eloquent\Builder', $taggable->allTags());
	}

	/** @test */
	public function it_can_tag()
	{
		$taggable = new Taggable;

		$taggable = $this->addMockConnection($taggable, true);

		$taggable->getConnection()->getQueryGrammar()
			->shouldReceive('compileSelect');

		$taggable->getConnection()
			->shouldReceive('select');

		$taggable->getConnection()->getPostProcessor()
			->shouldReceive('processSelect')
			->twice()
			->andReturn([]);

		$taggable->getConnection()->getQueryGrammar()
			->shouldReceive('compileInsertGetId')
			->once();

		$taggable->getConnection()->getPostProcessor()
			->shouldReceive('processInsertGetId')
			->once();

		$taggable->getConnection()
			->shouldReceive('update');

		$taggable->getConnection()->getQueryGrammar()
			->shouldReceive('compileUpdate');

		$taggable->getConnection()
			->shouldReceive('insert');

		$taggable->getConnection()->getQueryGrammar()
			->shouldReceive('compileInsert')
			->once();

		$taggable->tag('foo');
	}

	/** @test */
	public function it_can_untag()
	{
		$taggable = new Taggable;

		$taggable = $this->addMockConnection($taggable, true);

		$taggable->getConnection()->getQueryGrammar()
			->shouldReceive('compileSelect');

		$taggable->getConnection()
			->shouldReceive('select');

		$taggable->getConnection()->getPostProcessor()
			->shouldReceive('processSelect')
			->once()
			->andReturn(['foo']);

		$taggable->getConnection()
			->shouldReceive('update');

		$taggable->getConnection()->getQueryGrammar()
			->shouldReceive('compileUpdate');

		$taggable->getConnection()
			->shouldReceive('delete');

		$taggable->getConnection()->getQueryGrammar()
			->shouldReceive('compileDelete')
			->once();

		$taggable->untag('foo');
	}

	/**
	 * @test
	 * @runInSeparateProcess
	 */
	public function test_static_setters_and_getters()
	{
		$taggable = new Taggable;

		// Delimiter
		$this->assertEquals(',', $taggable->getTagsDelimiter());

		$taggable->setTagsDelimiter('#');

		$this->assertEquals('#', $taggable->getTagsDelimiter());

		// Model
		$this->assertEquals('Cartalyst\Tags\IlluminateTag', $taggable->getTagsModel());

		$taggable->setTagsModel('Foo');

		$this->assertEquals('Foo', $taggable->getTagsModel());

		// Slug generator
		$this->assertEquals('Illuminate\Support\Str::slug', $taggable->getSlugGenerator());

		$taggable->setSlugGenerator('Foo');

		$this->assertEquals('Foo', $taggable->getSlugGenerator());
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

		return $model;
	}

}

class Taggable extends Model implements TaggableInterface {

	use TaggableTrait;

}
