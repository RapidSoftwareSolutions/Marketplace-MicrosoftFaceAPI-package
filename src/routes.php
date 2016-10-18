<?php
$routes = [
    'detectFaces',
    'findSimilarFaces',
    'divideFacesIntoGroups',
    'identifyFaces',
    'verifyFaceToFace',
    'verifyFaceToPerson',
    'addFaceToFaceList',
    'createFaceList',
    'deleteFaceFromFaceList',
    'deleteFaceList',
    'getFaceList',
    'getFaceLists',
    'updateFaceList',
    'addPersonFace',
    'createPerson',
    'deletePerson',
    'deletePersonFace',
    'getPerson',
    'getPersonFace',
    'getPersonsInPersonGroup',
    'updatePerson',
    'updatePersonFace',
    'createPersonGroup',
    'deletePersonGroup',
    'getPersonGroup',
    'getPersonGroupTrainingStatus',
    'getPersonGroups',
    'trainPersonGroup',
    'updatePersonGroup',
    'metadata'
];
foreach($routes as $file) {
    require __DIR__ . '/../src/routes/'.$file.'.php';
}

