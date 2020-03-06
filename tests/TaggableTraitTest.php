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
 * @version    10.0.1
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2020, Cartalyst LLC
 * @link       https://cartalyst.com
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
        $post2->tag(['foo']);

        $this->assertSame(['foo'], $post1->tags->pluck('slug')->toArray());
        $this->assertSame(['foo'], $post2->tags->pluck('slug')->toArray());
    }

    /** @test */
    public function it_can_add_multiple_tags()
    {
        $post1 = $this->createPost();
        $post2 = $this->createPost();
        $post3 = $this->createPost();

        $post1->tag('foo, bar');
        $post2->tag(['foo', 'bar']);
        $post3->tag(null);

        $this->assertSame(['foo', 'bar'], $post1->tags->pluck('slug')->toArray());
        $this->assertSame(['foo', 'bar'], $post2->tags->pluck('slug')->toArray());
        $this->assertEmpty($post3->tags->pluck('slug')->toArray());
    }

    /** @test */
    public function it_can_untag()
    {
        $post = $this->createPost();

        $post->tag('foo');

        $this->assertSame(['foo'], $post->tags->pluck('slug')->toArray());

        $post->untag('foo');
        $post->untag('foo');

        $this->assertEmpty($post->tags->pluck('slug')->toArray());
    }

    /** @test */
    public function it_can_remove_all_tags()
    {
        $post = $this->createPost();

        $post->tag('foo, bar, baz');

        $this->assertCount(3, $post->tags);

        $post->untag();

        $this->assertCount(0, $post->tags);
    }

    /** @test */
    public function it_can_set_tags()
    {
        $post = $this->createPost();

        $post->tag('baz');

        $post->setTags('foo, bar');

        $this->assertSame(['foo', 'bar'], $post->tags->pluck('slug')->toArray());
    }

    /** @test */
    public function it_can_retrieve_tags()
    {
        $post = $this->createPost();

        $post->tag('foo, bar, baz');

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
    public function it_can_retrieve_without_the_given_tags()
    {
        $post1 = $this->createPost();
        $post2 = $this->createPost();

        $post1->tag('foo, bar, baz');
        $post2->tag('foo, bat');

        $this->assertcount(0, Post::withoutTag('foo')->get());

        $this->assertcount(1, Post::withoutTag('bar')->get());

        $this->assertcount(1, Post::withoutTag('bat')->get());
    }

    /** @test */
    public function it_can_get_and_set_the_tags_delimiter()
    {
        $post = new Post();

        $post->setTagsDelimiter(',');

        $this->assertSame(',', $post->getTagsDelimiter());
    }

    /** @test */
    public function it_can_get_and_set_the_tags_model()
    {
        $post = new Post();

        $post->setTagsModel(IlluminateTag::class);

        $this->assertSame(IlluminateTag::class, $post->getTagsModel());
    }

    /** @test */
    public function it_can_get_and_set_the_slug_generator_as_a_string()
    {
        $post = new Post();

        $post->setSlugGenerator('Illuminate\Support\Str::slug');

        $this->assertSame('Illuminate\Support\Str::slug', $post->getSlugGenerator());
    }

    /** @test */
    public function it_can_get_and_set_the_slug_generator_as_a_closure()
    {
        $post = new Post();

        $post->setSlugGenerator(function ($value) {
            return str_replace(' ', '_', strtolower($value));
        });

        $this->assertIsObject($post->getSlugGenerator());
    }
}
