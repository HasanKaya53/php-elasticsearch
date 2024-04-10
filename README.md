# Php Elasticsearch Example

# ElasticSearch Library İnsallation

```bash
composer require elasticsearch/elasticsearch
```

#How To Connect Elasticsearch

```php


require 'vendor/autoload.php';

use Elastic\Elasticsearch\ClientBuilder;

$client = ClientBuilder::create()->setHosts(['elasticsearch:9200'])->build(); // elasticsearch:9200 is docker container name

```



# How To Install Data In Elasticsearch

```php

$params = [
    'index' => 'your_index_name',
    'id'    => 'my_id',
    'body'  => ['testField' => 'abc']
];

$response = $client->index($params);
print_r($response);

```

# How To Get Data In Elasticsearch

```php


$params = [
        'index' => 'your_index_name',
        'body' => [
            'query' => [
                'match' => [
                    'color' => 'red'
                ]
            ]
        ]
];

$response = $client->search($params);

if (isset($response['hits']['total']['value']) && $response['hits']['total']['value'] > 0) {
    $result['message'] = "data found!";
    $result['data'] = $response['hits']['hits'];
}
else {
    $result['status'] = false;
    $result['message'] = "data not found.";
}

print_r($result);

```

# How to get multiple data in Elasticsearch

```php

$params = [
    'index' => 'your_index_name',
    'body' => [
        'query' => [
            'multi_match' => [
                'query' => 'red',
                'fields' => ['name','color','brand']
            ]
        ]
    ]
];

$response = $client->search($params);

if (isset($response['hits']['total']['value']) && $response['hits']['total']['value'] > 0) {
    $result['message'] = "data found!";
    $result['data'] = $response['hits']['hits'];
}
else {
    $result['status'] = false;
    $result['message'] = "data not found.";
}

print_r($result);

```


# How To Update Data In Elasticsearch

```php

# Update data

```
				






# Install Docker Compose And Elasticsearch

<p> This is a simple PHP example of elasticsearch. It includes the following with docker configuration. </p>

<ul>
    <li>Php last version</li>
    <li>Elasticsearch last version</li>
    <li>Kibana last version</li>
    <li>Mongo last version</li>
</ul>

<p> You can run the project with the following command. </p>

```bash 
docker-compose up -d
```

<p> You can access the project with the following link. </p>

```bash
http://localhost:8001
```
<p> You can access the elasticsearch with the following link. </p>

```bash
http://localhost:9200
```

<p> You can access the kibana with the following link. </p>

```bash
http://localhost:5601
```

<p> You can access the mongo with the following link. </p>

```bash
http://localhost:8003
```


## Elastic Search Notes

<p> Search Command: </p>

```bash
curl -X GET "localhost:9200/_search" -H 'Content-Type: application/json' -d'
        {
            "query": {
                "match_all": {}
            }
        }
```





<p> Insert Data Command: </p>
    
   ```bash
     curl -X POST https://localhost:9200/index_name/_doc/1 -H 'Content-Type: application/json' -d'
    {
        "name": "test",
        "description": "test description"
    }

```

<p> Update Data Command: </p>


 ```bash
     curl -X POST https://localhost:9200/index_name/_doc/1 -H 'Content-Type: application/json' -d'
            {
                "doc": {
                    "name": "test",
                    "description": "test description"
                }
            }

```


<p> Create Index Command: </p>


    
 ```bash
        curl -X POST https://localhost:9200/index_name -H 'Content-Type: application/json' -d'
    {
        "mappings": {
            "properties": {
                "name": {
                    "type": "text"
                },
                "description": {
                    "type": "text"
                }
            }
        }
    }


```
    


  




