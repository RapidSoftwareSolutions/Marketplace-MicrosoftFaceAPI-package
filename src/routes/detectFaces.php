<?php

$app->post('/api/MicrosoftFaceApi/detectFaces', function ($request, $response, $args) {
    $settings =  $this->settings;
    
    $data = $request->getBody();
    $post_data = json_decode($data, true);
    if(!isset($post_data['args'])) {
        $data = $request->getParsedBody();
        $post_data = $data;
    }
    
    $error = [];
    if(empty($post_data['args']['subscriptionKey'])) {
        $error[] = 'subscriptionKey cannot be empty';
    }
    if(empty($post_data['args']['image'])) {
        $error[] = 'image cannot be empty';
    }
    
    if(!empty($error)) {
        $result['callback'] = 'error';
        $result['contextWrites']['to'] = implode(',', $error);
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
    }
    
    
    $query = [];
    if(!empty($post_data['args']['returnFaceId'])) {
        $query['returnFaceId'] = $post_data['args']['returnFaceId'];
    }
    if(!empty($post_data['args']['returnFaceLandmarks'])) {
        $query['returnFaceLandmarks'] = $post_data['args']['returnFaceLandmarks'];
    }
    if(!empty($post_data['args']['returnFaceAttributes'])) {
        $query['returnFaceAttributes'] = $post_data['args']['returnFaceAttributes'];
    }
    
    $headers['Ocp-Apim-Subscription-Key'] = $post_data['args']['subscriptionKey'];
    $headers['Content-Type'] = 'application/json';
    $query_str = $settings['api_url'] . 'detect';
    $body['url'] = $post_data['args']['image'];
    
    $client = $this->httpClient;

    try {

        $resp = $client->post( $query_str, 
            [
                'query' => $query,
                'body' => json_encode($body),
                'headers' => $headers,
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
