<?php
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

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CartalystTagsCreateTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('taggables', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('taggable_type');
			$table->integer('taggable_id')->unsigned();

			$table->engine = 'InnoDB';

			$table->index([ 'taggable_type', 'taggable_id' ]);
		});

		Schema::create('tags', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('count')->unsigned();
			$table->string('slug');
			$table->string('name');

			$table->engine = 'InnoDB';
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$tables = [ 'tags', 'taggables' ];

		foreach ($tables as $table) Schema::drop($table);
	}

}
