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
 * @version    2.0.2
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2016, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Tags\Tests;

use Cartalyst\Tags\IlluminateTag;
use Cartalyst\Tags\Tests\Stubs\Post;
use Cartalyst\Tags\Tests\Stubs\Post2;

class TaggableTraitTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_add_a_single_tag()
    {
        $post1 = $this->createPost();
        $post2 = $this->createPost();

        $post1->tag('foo');
        $post2->tag([ 'foo' ]);

        $post1 = $post1->fresh();
        $post2 = $post2->fresh();

        $this->assertSame([ 'foo' ], $post1->tags->lists('slug')->toArray());
        $this->assertSame([ 'foo' ], $post2->tags->lists('slug')->toArray());
    }

    /** @test */
    public function it_can_add_multiple_tags()
    {
        $post1 = $this->createPost();
        $post2 = $this->createPost();
        $post3 = $this->createPost();

        $post1->tag('foo, bar');
        $post2->tag([ 'foo', 'bar' ]);
        $post3->tag(null);

        $post1 = $post1->fresh();
        $post2 = $post2->fresh();
        $post3 = $post3->fresh();

        $this->assertSame([ 'foo', 'bar' ], $post1->tags->lists('slug')->toArray());
        $this->assertSame([ 'foo', 'bar' ], $post2->tags->lists('slug')->toArray());
        $this->assertSame([ ], $post3->tags->lists('slug')->toArray());
    }

    /** @test */
    public function it_can_untag()
    {
        $post = $this->createPost();

        $post->tag('foo');

        $post = $post->fresh();

        $this->assertSame([ 'foo' ], $post->tags->lists('slug')->toArray());

        $post->untag('foo');

        $post = $post->fresh();

        $this->assertSame([  ], $post->tags->lists('slug')->toArray());
    }

    /** @test */
    public function it_can_remove_all_tags()
    {
        $post = $this->createPost();

        $post->tag('foo, bar, baz');

        $post = $post->fresh();

        $this->assertCount(3, $post->tags);

        $post->untag();

        $post = $post->fresh();

        $this->assertCount(0, $post->tags);
    }

    /** @test */
    public function it_can_set_tags()
    {
        $post = $this->createPost();

        $post->tag('baz');

        $post = $post->fresh();

        $post->setTags('foo, bar');

        $post = $post->fresh();

        $this->assertSame([ 'foo', 'bar' ], $post->tags->lists('slug')->toArray());
    }

    /** @test */
    public function it_can_retrieve_tags()
    {
        $post = $this->createPost();

        $post->tag('foo, bar, baz');

        $post = $post->fresh();

        $this->assertCount(3, $post->tags);
    }

    /** @test */
    public function it_can_retrieve_all_tags()
    {
        $post1 = $this->createPost();
        $post2 = $this->createPost();

        $post1->tag('foo, bar, baz');
        $post2->tag('fooo');

        $this->assertCount(4, Post::allTags()->get());
        $this->assertCount(0, Post2::allTags()->get());
    }

    /** @test */
    public function it_can_retrieve_by_the_given_tags()
    {
        $post1 = $this->createPost();
        $post2 = $this->createPost();

        $post1->tag('foo, bar, baz');
        $post2->tag('foo, bat');


        $this->assertcount(1, Post::whereTag('foo, bar')->get());

        $this->assertcount(2, Post::withTag('foo')->get());

        $this->assertcount(1, Post::withTag('bat')->get());
    }

    /** @test */
    public function it_can_get_and_set_the_tags_delimiter()
    {
        $post = new Post;

        $post->setTagsDelimiter(',');

        $this->assertSame(',', $post->getTagsDelimiter());
    }

    /** @test */
    public function it_can_get_and_set_the_tags_model()
    {
        $post = new Post;

        $post->setTagsModel(IlluminateTag::class);

        $this->assertSame(IlluminateTag::class, $post->getTagsModel());
    }

    /** @test */
    public function it_can_get_and_set_the_slug_generator()
    {
        $post = new Post;

        $post->setSlugGenerator('Illuminate\Support\Str::slug');

        $this->assertSame('Illuminate\Support\Str::slug', $post->getSlugGenerator());
    }
}
