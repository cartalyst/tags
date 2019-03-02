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

use Cartalyst\Tags\IlluminateTag;
use Cartalyst\Tags\IlluminateTagged;
use Cartalyst\Tags\Tests\Stubs\Post;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class IlluminateTagTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_delete_a_tag_and_its_tagged_relations()
    {
        $post = $this->createPost();

        $post->tag('foo, bar');

        $this->assertCount(2, $post->tags);

        $tag = IlluminateTag::first();

        $tag->delete();

        $post = $post->fresh();

        $this->assertCount(1, $post->tags);
    }

    /** @test */
    public function it_has_a_taggable_relationship()
    {
        $tag = new IlluminateTag;

        $this->assertInstanceOf(MorphTo::class, $tag->taggable());
    }

    /** @test */
    public function it_has_a_tag_relationship()
    {
        $tag = new IlluminateTag;

        $this->assertInstanceOf(HasMany::class, $tag->tagged());
    }

    /** @test */
    public function it_has_a_name_scope()
    {
        IlluminateTag::create([ 'name' => 'Foo', 'slug' => 'foo', 'namespace' => 'foo' ]);

        $this->assertCount(1, IlluminateTag::name('Foo')->get());
    }

    /** @test */
    public function it_has_a_slug_scope()
    {
        IlluminateTag::create([ 'name' => 'Foo', 'slug' => 'foo', 'namespace' => 'foo' ]);

        $this->assertCount(1, IlluminateTag::slug('foo')->get());
    }

    /** @test */
    public function it_can_get_and_set_the_tagged_model()
    {
        $tag = new IlluminateTag;

        $tag->setTaggedModel(IlluminateTagged::class);

        $this->assertEquals(IlluminateTagged::class, $tag->getTaggedModel());
    }
}
