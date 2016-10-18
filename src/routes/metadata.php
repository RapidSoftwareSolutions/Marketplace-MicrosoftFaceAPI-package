<?php

$app->get('/api/MicrosoftFaceApi', function ($request, $response, $args) {
    $newStream = new \GuzzleHttp\Psr7\LazyOpenStream(__DIR__ . '/../../src/metadata/metadata.json', 'r');
    $newResponse = $response->withHeader('Content-type', 'application/json')->withStatus(200)->withBody($newStream);
    return $newResponse;
});
