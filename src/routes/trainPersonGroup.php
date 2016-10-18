<?php

$app->post('/api/MicrosoftFaceApi/trainPersonGroup', function ($request, $response, $args) {
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
    if(empty($post_data['args']['personGroupId'])) {
        $error[] = 'personGroupId cannot be empty';
    } 
    
    if(!empty($error)) {
        $result['callback'] = 'error';
        $result['contextWrites']['to'] = implode(',', $error);
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
    }
    
    
    $headers['Ocp-Apim-Subscription-Key'] = $post_data['args']['subscriptionKey'];
    $headers['Content-Type'] = 'application/json';
    $query_str = $settings['api_url'] . 'persongroups/'.$post_data['args']['personGroupId'].'/train';
    
    $client = $this->httpClient;

    try {

        $resp = $client->post( $query_str, 
            [
                'headers' => $headers,
                'verify' => false
            ]);
        $responseBody = $resp->getBody()->getContents();
        if($resp->getStatusCode() == '202') {
            $result['callback'] = 'success';
            $result['contextWrites']['to'] = json_encode($responseBody);
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
