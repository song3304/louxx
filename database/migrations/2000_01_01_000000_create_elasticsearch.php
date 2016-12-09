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
			'index' => $e->getConfig('index'),
			'body' => [
				'settings' => [
					'analysis' => [
						'analyzer' => [
							'pinyin' => [ //常规的拼音+汉字搜
								'tokenizer' => 'title_pinyin'
							],
							'ik_smart_pinyin' => [ //分词之后的拼音
								'type' => 'custom',
								'tokenizer' => 'ik_max_word', //先分词
								'filter' => [
									'single_pinyin' //将分词转化成拼音
								],
								'char_filter' => [
									'html_strip' //去除html代码
								]
							],
							'title_pinyin'  => [ //标题使用拼音+汉字搜
								'type' => 'custom',
								'tokenizer' => 'title_pinyin', //先转拼音
								'filter' => [
								   'title_ngram' //为了适应任何字的搜索，将每种组合都来一遍
								]
							],
						],
						'tokenizer' => [
							'title_pinyin' => [ //常规拼音 全拼/首拼
								'type' => 'pinyin',
								'keep_first_letter' => true,
								'keep_separate_first_letter' => false,
								'keep_full_pinyin' => false,
								'keep_joined_full_pinyin' => true,
								'keep_original' => true,
								'limit_first_letter_length' => 150,
								'lowercase' => true
							],
							
						],
						'filter' => [
							'single_pinyin' => [
								'type' => 'pinyin',
								'keep_first_letter' =>  true,
								'keep_separate_first_letter' => false,
								'keep_full_pinyin' => false,
								'keep_joined_full_pinyin' => true,
								'keep_original' => true,
								'limit_first_letter_length' => 150,
								'lowercase' => true
							],
							'title_ngram' => [ //主要针对不换行的标题使用，方便模糊搜索
							  'type' => 'ngram',
							  'min_gram' => 2,
							  'max_gram' => 6,
							  'token_chars' => [
								'letter',
								'digit'
							  ]
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
										'analyzer' => 'english',
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
										'search_analyzer' => 'ik_smart_pinyin',
										'analyzer' => 'ik_smart_pinyin',
									],
								],
							],
							[
								'pinyin' => [
									'match_pattern' => 'regex',
									'match_mapping_type' => 'string',
									'match' => '^(title|realname|nickname|alias)$',
									'mapping' => [
										'type' => 'text',
										'search_analyzer' => 'pinyin',
										'analyzer' => 'title_pinyin',
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
