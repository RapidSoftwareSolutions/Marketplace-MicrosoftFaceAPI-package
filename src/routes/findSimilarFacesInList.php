<?php

$app->post('/api/MicrosoftFaceApi/findSimilarFacesInList', function ($request, $response, $args) {
    $settings = $this->settings;

    $data = $request->getBody();

    if ($data == '') {
        $post_data = $request->getParsedBody();
    } else {
        $toJson = $this->toJson;
        $data = $toJson->normalizeJson($data);
        $data = str_replace('\"', '"', $data);
        $post_data = json_decode($data, true);
    }

    if (json_last_error() != 0) {
        $error[] = json_last_error_msg() . '. Incorrect input JSON. Please, check fields with JSON input.';
    }

    if (!empty($error)) {
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'JSON_VALIDATION';
        $result['contextWrites']['to']['status_msg'] = implode(',', $error);
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
    }

    $error = [];
    if (empty($post_data['args']['subscriptionKey'])) {
        $error[] = 'subscriptionKey';
    }
    if (empty($post_data['args']['faceId'])) {
        $error[] = 'faceId';
    }
    if (empty($post_data['args']['faceListId'])) {
        $error[] = 'please provide faceListId';
    }

    if (!empty($error)) {
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = "REQUIRED_FIELDS";
        $result['contextWrites']['to']['status_msg'] = "Please, check and fill in required fields.";
        $result['contextWrites']['to']['fields'] = $error;
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
    }


    $body['faceId'] = $post_data['args']['faceId'];
    if (!empty($post_data['args']['faceListId'])) {
        $body['faceListId'] = $post_data['args']['faceListId'];
    }
 
    if (!empty($post_data['args']['maxNumOfCandidatesReturned'])) {
        $body['maxNumOfCandidatesReturned'] = $post_data['args']['maxNumOfCandidatesReturned'];
    }
    if (!empty($post_data['args']['mode'])) {
        $body['mode'] = $post_data['args']['mode'];
    }

    $headers['Ocp-Apim-Subscription-Key'] = $post_data['args']['subscriptionKey'];
    $headers['Content-Type'] = 'application/json';
     if(!empty($post_data['args']['region'])){         $settings['api_url'] = "https://".$post_data['args']['region'].".api.cognitive.microsoft.com/face/v1.0/";     }  $query_str = $settings['api_url'] . 'findsimilars';

    $client = $this->httpClient;

    try {

        $resp = $client->post($query_str,
            [
                'json' => $body,
                'headers' => $headers,
                'verify' => false
            ]);
        $responseBody = $resp->getBody()->getContents();
        if ($resp->getStatusCode() == '200') {
            $result['callback'] = 'success';
            $result['contextWrites']['to'] = is_array($responseBody) ? $responseBody : json_decode($responseBody);
        } else {
            $result['callback'] = 'error';
            $result['contextWrites']['to']['status_code'] = 'API_ERROR';
            $result['contextWrites']['to']['status_msg'] = is_array($responseBody) ? $responseBody : json_decode($responseBody);
        }

    } catch (\GuzzleHttp\Exception\ClientException $exception) {

        $responseBody = $exception->getResponse()->getBody()->getContents();
        if (empty(json_decode($responseBody))) {
            $out = $responseBody;
        } else {
            $out = json_decode($responseBody);
        }
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'API_ERROR';
        $result['contextWrites']['to']['status_msg'] = $out;

    } catch (GuzzleHttp\Exception\ServerException $exception) {

        $responseBody = $exception->getResponse()->getBody()->getContents();
        if (empty(json_decode($responseBody))) {
            $out = $responseBody;
        } else {
            $out = json_decode($responseBody);
        }
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'API_ERROR';
        $result['contextWrites']['to']['status_msg'] = $out;

    } catch (GuzzleHttp\Exception\ConnectException $exception) {


        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'INTERNAL_PACKAGE_ERROR';
        $result['contextWrites']['to']['status_msg'] = 'Something went wrong inside the package.';

    }

    return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
});
