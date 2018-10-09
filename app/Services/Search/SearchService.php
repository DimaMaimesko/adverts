<?php
/**
 * Created by PhpStorm.
 * User: дз
 * Date: 07.10.2018
 * Time: 23:00
 */

namespace App\Services\Search;
use App\Http\Requests\Adverts\SearchRequest;
use App\Models\Adverts\Advert;
use App\Models\Adverts\Category;
use App\Models\Region;
use Elasticsearch\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Query\Expression;
use App\Services\Search\SearchResult;
class SearchService
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function search(?Category $category,?Region $region, SearchRequest $request, int $perPage, int $page): SearchResult
    {

        $values = array_filter((array)$request->input('attrs'), function ($value) {
            return !empty($value['equals']) || !empty($value['from']) || !empty($value['to']);
        });

        $response = $this->client->search([
            'index' => 'adverts',
            //'type' => 'adverts',
            'body' => [
                'from' => ($page - 1) * $perPage,//сколько элементов с какого сдвига выводим
                'size' => $perPage,
                '_source' => ['id'], // возвращаются только id
                'sort' => empty($request['text']) ? [//если это текст, то сортировка по релевантности, если не текст - по датепубликации
                    ['published_at' => ['order' => 'desc']],
                ] : [],
                'aggs' => [
                    'group_by_region' => [//название аггрегата
                        'terms' => [
                            'field' => 'regions',//по каким полям ищем(агрегируем)
                        ],
                    ],
                    'group_by_category' => [
                        'terms' => [
                            'field' => 'categories',
                        ],
                    ],
                ],
                'query' => [//сам запрос, указываем что именно мы выводим
                    'bool' => [//в секции bool перечисляем критерии поиска, они будут склеины как AND
                        'must' => array_merge(//must означает, что если хоть одна проверка не пройдет, то из поиска ничего не вернется.  array_filter() оставит только непустые элементы
                            [
                                ['term' => ['status' => Advert::STATUS_ACTIVE]],//term означает точное совпадение
                            ],
                            array_filter([
                                $category ? ['term' => ['categories' => $category->id]] : false,//категории может и не быть, поэтому обернем весь массив в array_filter()
                                $region ? ['term' => ['regions' => $region->id]] : false,
                                !empty($request['text']) ? ['multi_match' => [//multi_match позволяет искать по нескольким полям указывая им разные веса
                                    'query' => $request['text'],//указываем какое значение ищем
                                    'fields' => [ 'title^3', 'content' ]//по каким полям (title с весом в 3 раза больше, content с весом 1)
                                ]] : false,
                            ]),
                            //Через эту функцию прогоним все value вложеных элементов(которые прилетели из формы)
                            //и для каждого элемента(атрибута) построится свой nested
                            array_map(function ($value, $id) {//получаем и значение и ключ
                                return [
                                    'nested' => [
                                        'path' => 'values',
                                        'query' => [
                                            'bool' => [
                                                'must' => array_values(array_filter([
                                                    ['match' => ['values.attribute' => $id]],
                                                    !empty($value['equals']) ? ['match' => ['values.value_string' => $value['equals']]] : false,
                                                    !empty($value['from']) ? ['range' => ['values.value_int' => ['gte' => $value['from']]]] : false,
                                                    !empty($value['to']) ? ['range' => ['values.value_int' => ['lte' => $value['to']]]] : false,
                                                ])),
                                            ],
                                        ],
                                    ],
                                ];
                            }, $values, array_keys($values))
                        )
                    ],
                ]
            ]
        ]);
//dd($response);
        $ids = array_column($response['hits']['hits'], '_id');

        if (!$ids){
            $pagination =  new LengthAwarePaginator([], 0, $perPage, $page);
        }else{
            $items = Advert::active()
                ->with(['category', 'region'])
                ->whereIn('id', $ids)//new Expression для того чтобы строка не экранировалась
                ->orderBy(new Expression('FIELD(id,' . implode(',', $ids) . ')'))//выводим в том порядке, в каком получили айдишники из ES
                ->get();
            $pagination =  new LengthAwarePaginator($items, $response['hits']['total'], $perPage, $page);
        }

        return new SearchResult(
            $pagination,
            array_column($response['aggregations']['group_by_region']['buckets'], 'doc_count', 'key'),
            array_column($response['aggregations']['group_by_category']['buckets'], 'doc_count', 'key')
        );
    }

}