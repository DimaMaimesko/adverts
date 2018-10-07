<?php

namespace App\Console\Commands\Search;

use Elasticsearch\Common\Exceptions\Missing404Exception;
use Illuminate\Console\Command;
use Elasticsearch\Client;

class InitCommand extends Command
{
    protected $signature = 'search:init';

    private $client;

    public function __construct(Client $client)
    {
        parent::__construct();
        $this->client = $client;
    }
    
    public function handle(): bool
    {
        try {
            $this->client->indices()->delete([
                'index' => 'adverts'
            ]);
        } catch (Missing404Exception $e) {}

        $this->client->indices()->create([
            'index' => 'adverts',
            'body' => [
                'mappings' => [//можно mapping не указывать, тогда поля будут парсится автоматически
                    'advert' => [
                        '_source' => [//если _source не указать - нам вернуться только айдишники
                            'enabled' => true,//а если указать - то айдишники  + контент
                        ],
                        'properties' => [
                            'id' => [
                                'type' => 'integer',
                            ],
                            'published_at' => [
                                'type' => 'date',
                            ],
                            'title' => [
                                'type' => 'text',// text - это поле будет парсится для полнотекстового поиска
                            ],
                            'content' => [
                                'type' => 'text',
                            ],
                            'price' => [
                                'type' => 'integer',
                            ],
                            'status' => [
                                'type' => 'keyword',//keyword - поле не будет индексироваться, просто хранить значение
                            ],
                            'categories' => [
                                'type' => 'integer',//будем передавать сюда массив с айдишниками подкатегорий
                            ],
                            'regions' => [
                                'type' => 'integer',
                            ],
                            'values' => [
                                'type' => 'nested',
                                'properties' => [
                                    'attribute' => [
                                        'type' => 'integer'
                                    ],
                                    'value_string' => [
                                        'type' => 'keyword',
                                    ],
                                    'value_int' => [
                                        'type' => 'integer',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                'settings' => [
                    'analysis' => [
                        'char_filter' => [
                            'replace' => [
                                'type' => 'mapping',
                                'mappings' => [
                                    '&=> and '
                                ],
                            ],
                        ],
                        'filter' => [
                            'word_delimiter' => [
                                'type' => 'word_delimiter',
                                'split_on_numerics' => false,
                                'split_on_case_change' => true,
                                'generate_word_parts' => true,
                                'generate_number_parts' => true,
                                'catenate_all' => true,
                                'preserve_original' => true,
                                'catenate_numbers' => true,
                            ],//по умолчанию ES ищет слова целиком,
                            'trigrams' => [
                                'type' => 'ngram', //этот фильтр берет текст и разбивает на кусочки по 3 буквы
                                'min_gram' => 4,
                                'max_gram' => 6,
                            ],
                        ],
                        'analyzer' => [  // это основная секция для настроек
                            'default' => [  //'default' - применится для всех полей, можно сделать несколько анализаторов и применять их для разных полей
                                'type' => 'custom',
                                'char_filter' => [
                                    'html_strip',
                                    'replace',
                                ],
                                'tokenizer' => 'whitespace',
                                'filter' => [
                                    'lowercase',
                                    'word_delimiter',
                                    'trigrams',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        return true;
    }



}
