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
		if (!env('SCOUT_DRIVER')) return;
		$e = app('elasticsearch');
		$params = [
			'index' => $e->getConfig('index'),
			'body' => [
				'settings' => [
					'analysis' => [
						'analyzer' => [
							'pinyin_standard' => [ //常规的拼音+汉字搜
								'tokenizer' => 't_pinyin'
							],
							'ik_smart_standard' => [ //适合正文
								'type' => 'custom',
								'tokenizer' => 'ik_max_word', //先分词
								'filter' => [
									'unique'
								],
								'char_filter' => [
									'html_strip' //去除html代码
								]
							],
							'ik_smart_pinyin' => [ //适合标题
								'type' => 'custom',
								'tokenizer' => 'ik_max_word', //先分词
								'filter' => [
									'f_pinyin', 'f_ngram', 'unique' //将分词转化成拼音，并且一律ngram
								],
								'char_filter' => [
									'html_strip' //去除html代码
								]
							],
							'title_standard' => [
								'type' => 'custom',
								'tokenizer' => 'standard',
								'filter' => [
									'lowercase', 'asciifolding', 'f_ngram', 'unique' //为了适应任何字的搜索，将每种组合都来一遍
								]
							],
						],
						'tokenizer' => [
							't_pinyin' => [
								'type' => 'pinyin',
								'keep_first_letter' => true,
								'keep_separate_first_letter' => false,
								'keep_full_pinyin' => false,
								'keep_joined_full_pinyin' => true,
								'keep_original' => true,
								'limit_first_letter_length' => 25,
								'lowercase' => true
							],
						],
						'filter' => [
							'f_pinyin' => [
								'type' => 'pinyin',
								'keep_first_letter' => true,
								'keep_separate_first_letter' => false,
								'keep_full_pinyin' => false,
								'keep_joined_full_pinyin' => true,
								'keep_original' => true,
								'limit_first_letter_length' => 25,
								'lowercase' => true
							],
							'f_ngram' => [ //主要针对不换行的标题使用，方便模糊搜索
								'type' => 'edgeNGram',
								'min_gram' => 2,
								'max_gram' => 25,
								'side' => 'front',
							],
						],
					],
				],
				'mappings' => [

					'_default_' => [
						/*'_all' => [
							'enabled' => true
						],*/
						'dynamic_templates' => [
							[
								'whole_words' => [
									'match_pattern' => 'regex',
									'match_mapping_type' => 'string',
									'match' => '^(name|username)$',
									'mapping' => [
										'type' => 'text',
										'search_analyzer' => 'standard',
										'analyzer' => 'title_standard',
									],
									
								],
							],
							[
								'fulltext' => [
									'match_pattern' => 'regex',
									'match_mapping_type' => 'string',
									'match' => '^.*?(content|text)$',
									'mapping' => [
										'type' => 'text',
										'search_analyzer' => 'ik_smart_standard',
										'analyzer' => 'ik_smart_standard',
									],
								],
							],
							[
								'pinyin' => [
									'match_pattern' => 'regex',
									'match_mapping_type' => 'string',
									'match' => '^.*?(name|title|alias)$', //realname nickname title subtitle
									'mapping' => [
										'type' => 'text',
										'search_analyzer' => 'pinyin_standard',
										'analyzer' => 'ik_smart_pinyin',
									],
								],
							],
							[
								'dates' => [
									'match_mapping_type' => 'string',
									'match' => '*_at',
									'mapping' => [
										'type' => 'date',
										'format' => 'yyy-MM-dd HH:mm:ss||yyyy-MM-dd||HH:mm:ss'
									],
								],
							],
							[
								'timestamp' => [
									'match_mapping_type' => 'integer',
									'match' => '*_at',
									'mapping' => [
										'type' => 'date',
										'format' => 'seconds-since-the-epoch||milliseconds-since-the-epoch',
									],
								],
							],
							[
								'urls' => [
									'match_pattern' => 'regex',
									'match_mapping_type' => 'string',
									'match' => '^.*?(mail|link|url)s?$',
									'mapping' => [
										'type' => 'text',
										'tokenizer' => 'uax_url_email',
									],
								],
							],
							[
								'paths' => [
									'match_pattern' => 'regex',
									'match_mapping_type' => 'string',
									'match' => '^.*?(path)s?$',
									'mapping' => [
										'type' => 'text',
										'tokenizer' => 'uax_url_email',
									],
								],
							],
						],
					],
				],
			],
		];
		if ($e->indices()->exists(array_only($params, 'index')))
			$e->indices()->delete(array_only($params, 'index'));
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
