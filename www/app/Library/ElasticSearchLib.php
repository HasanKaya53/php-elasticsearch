<?php

namespace App\Library;


use Elastic\Elasticsearch\ClientBuilder;

class ElasticSearchLib
{

    private $client = null;
    public function __construct()
    {
        $this->client = ClientBuilder::create()->setHosts(['elasticsearch:9200'])->build();
    }




    public function addData($params = [],$indexName = 'my_index'){

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
        $response = $this->client->search($params);

        $result = [
            "status" => true
        ];

        if ($response['hits']['total']['value'] > 0) {
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
