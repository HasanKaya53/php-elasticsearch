<?php

namespace App\Library;


use Elastic\Elasticsearch\ClientBuilder;

class ElasticSearchLib
{

    private $client = null;

    private $sort = [];

    private $size = ['size' => 10];
    public function __construct()
    {
        $this->sort = [];
        $this->client = ClientBuilder::create()->setHosts(['elasticsearch:9200'])->build();
    }


    public function setSort($column,$order = 'asc'){
        $this->sort = [
            'sort' => [
                $column => [
                    'order' => $order
                ]
            ]
        ];
        return $this;
    }

    public function setSize($size){
        if(!is_numeric($size)) $this->size = ['size' => 10];
        else $this->size = ['size' => $size];

        return $this;
    }



    public function addData($params = [],$indexName = 'my_index'): array{

        $params['index'] = $indexName;




        $response = $this->client->index($params);

        $result = [
            "status" => true
        ];

        if ($response['result'] === 'created') {
            $result['message'] = "Veri başarıyla eklendi!";
            $result['data'] = $params;
        }
        else if ($response['result'] === 'updated') {
            $result['message'] = "Veri başarıyla güncellendi!";
            $result['data'] = $params;
        }
        else {
            $result['status'] = false;
            $result['message'] = "Veri eklenirken bir hata oluştu.";
            $result['data'] = [];
        }

        return $result;


    }

    public function searchData($params = [],$indexName = 'my_index'){

        $params['index'] = $indexName;

        $params['body'] = array_merge($params['body'], $this->sort);
        $params['body'] = array_merge($params['body'], $this->size);


        try{
            $response = $this->client->search($params);
        }
        catch (\Exception $e){
           return [
               "status" => 0,
               "message" => "Veri bulunamadı.",
           ];
        }

        $result = [
            "status" => true
        ];

        if (isset($response['hits']['total']['value']) && $response['hits']['total']['value'] > 0) {
            $result['message'] = "Veri bulundu!";
            $result['data'] = $response['hits']['hits'];
        }
        else {
            $result['status'] = false;
            $result['message'] = "Veri bulunamadı.";
        }

        return $result;

    }

    public function listAllData($indexName = 'my_index'){

            $params = [
                'index' => $indexName,
                'body' => [
                    'query' => [
                        'match_all' => new \stdClass()
                    ]
                ]
            ];

            return $this->searchData($params);
    }



}
