<?php

$app->post('/api/MicrosoftFaceApi/findSimilarFaces', function ($request, $response, $args) {
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
    if(empty($post_data['args']['faceId'])) {
        $error[] = 'faceId cannot be empty';
    }
    if(empty($post_data['args']['faceListId']) && empty($post_data['args']['faceIds'])) {
        $error[] = 'please provide faceListId or faceIds';
    }
    if(!empty($post_data['args']['faceListId']) && !empty($post_data['args']['faceIds'])) {
        $error[] = 'parameter faceListId and faceIds should not be provided at the same time.';
    }
    
    if(!empty($error)) {
        $result['callback'] = 'error';
        $result['contextWrites']['to'] = implode(',', $error);
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
    }
    
    
    $body['faceId'] = $post_data['args']['faceId'];
    if(!empty($post_data['args']['faceListId'])) {
        $body['faceListId'] = $post_data['args']['faceListId'];
    }
    if(!empty($post_data['args']['faceIds'])) {
        $body['faceIds'] = $post_data['args']['faceIds'];
    }
    if(!empty($post_data['args']['maxNumOfCandidatesReturned'])) {
        $body['maxNumOfCandidatesReturned'] = $post_data['args']['maxNumOfCandidatesReturned'];
    }
    if(!empty($post_data['args']['mode '])) {
        $body['mode'] = $post_data['args']['mode'];
    }
    
    $headers['Ocp-Apim-Subscription-Key'] = $post_data['args']['subscriptionKey'];
    $headers['Content-Type'] = 'application/json';
    $query_str = $settings['api_url'] . 'findsimilars';
    
    $client = $this->httpClient;

    try {

        $resp = $client->post( $query_str, 
            [
                'json' => $body,
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
