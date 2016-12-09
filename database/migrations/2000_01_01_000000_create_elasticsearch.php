<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElasticsearch extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!env('ELASTICSEARCH_HOST')) return;
		$e = app('elasticsearch');
		$params = [
			'index' => config('elasticsearch.default.index'),
			'body' => [
				'settings'=> [
					'analysis' => [
						'analyzer' => [
							'pinyin_analyzer' => [
								'tokenizer' => 'my_pinyin',
							],
							'ik_smart_pinyin'=> [
								'type'=> 'custom',
								'tokenizer'=> 'ik_max_word',
								'filter'=> ['single_pinyin'],
								"char_filter" => ["html_strip"],
							],
						],
						'tokenizer' => [
							'my_pinyin' => [
								'type' => 'pinyin',
								'keep_first_letter'=> true,
								'keep_separate_first_letter' => true,
								'keep_full_pinyin' => true,
								'keep_joined_full_pinyin'=> true,
								'keep_original' => true,
								'limit_first_letter_length' => 16,
								'lowercase' => true,
							],
						],
						'filter'=> [
							'single_pinyin' => [
								'type'=> 'pinyin',
								'keep_first_letter'=> true,
								'keep_separate_first_letter' => true,
								'keep_full_pinyin'=> true,
								'keep_joined_full_pinyin'=> true,
								'limit_first_letter_length' => 16,
								'keep_original' => true,
								'lowercase' => true,
							],
						],
					],
				],
				'mappings' => [
					'_default_' => [
						'_all' => [
							'enabled' => false
						],
						'properties' => [
							'name' => [
								'type' => 'text',
								'search_analyzer' => 'standard',
								'analyzer' => 'english',
								'filter' => [
									'lowercase'
								],
							],
						],
					],
				],
			],
		];
		$e->indices()->delete($params);
		$e->indices()->create($params);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

	}
}
