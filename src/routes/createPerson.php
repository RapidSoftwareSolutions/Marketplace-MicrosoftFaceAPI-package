<?php
require_once(__DIR__ . '/../Models/normalizeJson.php');

$app->post('/api/MicrosoftFaceApi/createPerson', function ($request, $response, $args) {
    $settings =  $this->settings;
    
    $data = $request->getBody();

    if($data=='') {
        $post_data = $request->getParsedBody();
    } else {
        $toJson = new normilizeJson();
        $data = $toJson->normalizeJson($data); 
        $data = str_replace('\"', '"', $data);
        $post_data = json_decode($data, true);
    }
    
    $error = [];
    if(empty($post_data['args']['subscriptionKey'])) {
        $error[] = 'subscriptionKey cannot be empty';
    }
    if(empty($post_data['args']['personGroupId'])) {
        $error[] = 'personGroupId cannot be empty';
    }
    if(empty($post_data['args']['name'])) {
        $error[] = 'name cannot be empty';
    }
    
    if(!empty($error)) {
        $result['callback'] = 'error';
        $result['contextWrites']['to'] = implode(',', $error);
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
    }
    
    
    $body['name'] = $post_data['args']['name'];
    if(!empty($post_data['args']['userData'])) {
        $body['userData'] = $post_data['args']['userData'];
    }
    
    $headers['Ocp-Apim-Subscription-Key'] = $post_data['args']['subscriptionKey'];
    $headers['Content-Type'] = 'application/json';
    $query_str = $settings['api_url'] . 'persongroups/'.$post_data['args']['personGroupId'].'/persons';
    
    $client = $this->httpClient;

    try {

        $resp = $client->post( $query_str, 
            [
                'headers' => $headers,
                'json' => $body,
                'verify' => false
            ]);
        $responseBody = $resp->getBody()->getContents();
        if($resp->getStatusCode() == '200') {
            $result['callback'] = 'success';
            if(!empty($post_data['args']['runscope'])) {
                $result['contextWrites']['to'] = json_decode($responseBody);
            } else {
                $result['contextWrites']['to'] = json_encode($responseBody);
            }
        } else {
            $result['callback'] = 'error';
            $result['contextWrites']['to'] = $responseBody;
        }

    } catch (\GuzzleHttp\Exception\ClientException $exception) {

        $responseBody = $exception->getResponse()->getBody(true);
        $result['callback'] = 'error';
        $result['contextWrites']['to'] = json_decode($responseBody);

    }
    
    

    return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
});
