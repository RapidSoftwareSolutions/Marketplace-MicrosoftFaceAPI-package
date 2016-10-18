<?php

namespace Tests\Functional;

class MicrosoftFaceApiTest extends BaseTestCase {
    
    public $subscriptionKey = "6677677263fa434dadddaa5e24b03436";
    public $FaceFromFaceList;
    public $FaceList;
    public $personId;
    public $persistedFaceId;
    public $personGroupId;

    public function testDetectFaces() {
        
        $var = '{
                    "args": {
                      "subscriptionKey": "'.$this->subscriptionKey.'",
                      "image": "http://tpsnews.co.il/wp-content/uploads/2016/01/12045261_10204516478367182_4266167553466427960_o-750x563.jpg"
                    }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/MicrosoftFaceApi/detectFaces', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

    public function testFindSimilarFaces() {

        $var = '{
                    "args": {
                      "subscriptionKey": "'.$this->subscriptionKey.'",
                      "faceId": "c695c28a-09a2-4db2-bef9-db80f1742eae",
                      "faceIds": ["c695c28a-09a2-4db2-bef9-db80f1742eae"],
                      "maxNumOfCandidatesReturned": "10",
                      "mode": "matchPerson"
                    }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/MicrosoftFaceApi/findSimilarFaces', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }
    
    public function testDivideFacesIntoGroups() {

        $var = '{
                    "args": {
                      "subscriptionKey": "'.$this->subscriptionKey.'",
                      "faceIds": ["c695c28a-09a2-4db2-bef9-db80f1742eae", "0926b79a-9033-44e0-9521-e1d0ebb0d074"]
                    }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/MicrosoftFaceApi/divideFacesIntoGroups', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }
    
    public function testIdentifyFaces() {

        $var = '{
                    "args": {
                      "subscriptionKey": "'.$this->subscriptionKey.'",
                      "faceIds": ["c695c28a-09a2-4db2-bef9-db80f1742eae", "0926b79a-9033-44e0-9521-e1d0ebb0d074"],
                      "personGroupId": "group"
                    }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/MicrosoftFaceApi/identifyFaces', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }
    
    public function testVerifyFaceToFace() {

        $var = '{
                    "args": {
                      "subscriptionKey": "'.$this->subscriptionKey.'",
                      "faceId1": "c695c28a-09a2-4db2-bef9-db80f1742eae",
                      "faceId2": "0926b79a-9033-44e0-9521-e1d0ebb0d074"
                    }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/MicrosoftFaceApi/verifyFaceToFace', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }
    
    public function testVerifyFaceToPerson() {

        $var = '{
                    "args": {
                      "subscriptionKey": "'.$this->subscriptionKey.'",
                      "faceId": "c695c28a-09a2-4db2-bef9-db80f1742eae",
                      "personGroupId": "group",
                      "personId": "15a2f546-212a-4a77-af90-f7384b5d0ec0"
                    }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/MicrosoftFaceApi/verifyFaceToPerson', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }
    
    public function testAddFaceToFaceList() {

        $var = '{
                    "args": {
                      "subscriptionKey": "'.$this->subscriptionKey.'",
                      "faceListId": "test_list1",
                      "image": "https://media.licdn.com/mpr/mpr/shrinknp_200_200/AAEAAQAAAAAAAAfzAAAAJGQ3ZjBiY2MwLWFlMGQtNGY5OC1iYTE5LWIzNzE3NDgzZTYyYQ.jpg"
                    }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/MicrosoftFaceApi/addFaceToFaceList', $post_data);
        
        $data = json_decode($response->getBody())->contextWrites->to;
        $data = stripcslashes($data);
        $data = substr($data,0,-1);
        $data = substr($data,1);
        $data = json_decode($data, true);
        $this->persistedFaceId = $data['persistedFaceId'];

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }
    
    public function testCreateFaceList() {

        $this->FaceList = date("YmdHis");
        $var = '{
                        "args": {
                          "subscriptionKey": "'.$this->subscriptionKey.'",
                          "faceListId": "test_'.$this->FaceList.'",
                          "name": "New test list"
                        }
                }';
        
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/MicrosoftFaceApi/createFaceList', $post_data);
        

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }
    
    public function testDeleteFaceFromFaceList() {

        $var = '{
                        "args": {
                          "subscriptionKey": "'.$this->subscriptionKey.'",
                          "faceListId": "test_'.$this->FaceList.'",
                          "persistedFaceId": "'.$this->persistedFaceId.'"
                        }
                }';

        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/MicrosoftFaceApi/deleteFaceFromFaceList', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }
    
    public function testGetFaceList() {

        $var = '{
                        "args": {
                          "subscriptionKey": "'.$this->subscriptionKey.'",
                          "faceListId": "test_list1"
                        }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/MicrosoftFaceApi/getFaceList', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }
    
    public function testGetFaceLists() {

        $var = '{
                        "args": {
                          "subscriptionKey": "'.$this->subscriptionKey.'"
                        }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/MicrosoftFaceApi/getFaceLists', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }
    
    public function testUpdateFaceList() {

        $var = '{
                        "args": {
                          "subscriptionKey": "'.$this->subscriptionKey.'",
                          "faceListId": "test_list1",
                          "name": "new name updated"
                        }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/MicrosoftFaceApi/updateFaceList', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }
    
    public function testAddPersonFace() {

        $var = '{
                    "args": {
                      "subscriptionKey": "'.$this->subscriptionKey.'",
                      "personGroupId": "group",
                      "personId": "15a2f546-212a-4a77-af90-f7384b5d0ec0",
                      "image": "https://media.licdn.com/mpr/mpr/shrinknp_200_200/AAEAAQAAAAAAAAfzAAAAJGQ3ZjBiY2MwLWFlMGQtNGY5OC1iYTE5LWIzNzE3NDgzZTYyYQ.jpg"
                    }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/MicrosoftFaceApi/addPersonFace', $post_data);
        
        $data = json_decode($response->getBody())->contextWrites->to;
        $data = stripcslashes($data);
        $data = substr($data,0,-1);
        $data = substr($data,1);
        $data = json_decode($data, true);
        $this->persistedFaceId = $data['persistedFaceId'];

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }
    
    public function testCreatePerson() {

        $var = '{
                    "args": {
                      "subscriptionKey": "'.$this->subscriptionKey.'",
                      "personGroupId": "group",
                      "name": "new person"
                    }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/MicrosoftFaceApi/createPerson', $post_data);

        $data = json_decode($response->getBody())->contextWrites->to;
        $data = stripcslashes($data);
        $data = substr($data,0,-1);
        $data = substr($data,1);
        $data = json_decode($data, true);
        $this->personId = $data['personId'];

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }
    
    public function testGetPerson() {

        $var = '{
                    "args": {
                      "subscriptionKey": "'.$this->subscriptionKey.'",
                      "personGroupId": "group",
                      "personId": "15a2f546-212a-4a77-af90-f7384b5d0ec0"                         
                    }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/MicrosoftFaceApi/getPerson', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }
    
    public function testGetPersonFace() {

        $var = '{
                    "args": {
                      "subscriptionKey": "'.$this->subscriptionKey.'",
                      "personGroupId": "group",
                      "personId": "15a2f546-212a-4a77-af90-f7384b5d0ec0",
                      "persistedFaceId": "d90f87a1-d709-4832-823d-a5fb5809f4c4"
                    }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/MicrosoftFaceApi/getPersonFace', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }
    
    public function testGetPersonsInPersonGroup() {

        $var = '{
                    "args": {
                      "subscriptionKey": "'.$this->subscriptionKey.'",
                      "personGroupId": "group"
                    }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/MicrosoftFaceApi/getPersonsInPersonGroup', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }
    
    public function testUpdatePerson() {

        $var = '{
                    "args": {
                      "subscriptionKey": "'.$this->subscriptionKey.'",
                      "personGroupId": "group",
                      "personId": "15a2f546-212a-4a77-af90-f7384b5d0ec0",
                      "name": "new updated name"
                    }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/MicrosoftFaceApi/updatePerson', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }
    
    public function testUpdatePersonFace() {

        $var = '{
                    "args": {
                      "subscriptionKey": "'.$this->subscriptionKey.'",
                      "personGroupId": "group",
                      "personId": "15a2f546-212a-4a77-af90-f7384b5d0ec0",
                      "persistedFaceId": "d90f87a1-d709-4832-823d-a5fb5809f4c4",
                      "userData": "test"
                    }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/MicrosoftFaceApi/updatePersonFace', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }
    
    public function testCreatePersonGroup() {

        $this->personGroupId = "group_".date("YmdHis");
        $var = '{
                    "args": {
                      "subscriptionKey": "'.$this->subscriptionKey.'",
                      "personGroupId": "'.$this->personGroupId.'",
                      "name": "new group"
                    }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/MicrosoftFaceApi/createPersonGroup', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }
    
    public function testGetPersonGroup() {

        $var = '{
                    "args": {
                      "subscriptionKey": "'.$this->subscriptionKey.'",
                      "personGroupId": "group"
                    }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/MicrosoftFaceApi/getPersonGroup', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }
    
    public function testGetPersonGroupTrainingStatus() {

        sleep(60);
        $var = '{
                    "args": {
                      "subscriptionKey": "'.$this->subscriptionKey.'",
                      "personGroupId": "group"
                    }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/MicrosoftFaceApi/getPersonGroupTrainingStatus', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }
    
    public function testGetPersonGroups() {

        $var = '{
                    "args": {
                      "subscriptionKey": "'.$this->subscriptionKey.'",
                      "personGroupId": "group"
                    }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/MicrosoftFaceApi/getPersonGroups', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }
    
    public function testTrainPersonGroup() {

        $var = '{
                    "args": {
                      "subscriptionKey": "'.$this->subscriptionKey.'",
                      "personGroupId": "group"
                    }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/MicrosoftFaceApi/trainPersonGroup', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }
    
    public function testUpdatePersonGroup() {

        $var = '{
                    "args": {
                      "subscriptionKey": "'.$this->subscriptionKey.'",
                      "personGroupId": "group1",
                      "name": "new_updated_name"
                    }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/MicrosoftFaceApi/updatePersonGroup', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }
    
    public function testDeleteFaceList() {

        $var = '{
                        "args": {
                          "subscriptionKey": "'.$this->subscriptionKey.'",
                          "faceListId": "test_list_'.$this->FaceList.'",
                        }
                }';

        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/MicrosoftFaceApi/deleteFaceList', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }
    
    public function testDeletePersonFace() {

        $var = '{
                    "args": {
                      "subscriptionKey": "'.$this->subscriptionKey.'",
                      "personGroupId": "group",
                      "personId": "'.$this->personId.'",
                      "persistedFaceId": "'.$this->persistedFaceId.'"                          
                    }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/MicrosoftFaceApi/deletePersonFace', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }
    
    public function testDeletePerson() {

        $var = '{
                    "args": {
                      "subscriptionKey": "'.$this->subscriptionKey.'",
                      "personGroupId": "group",
                      "personId": "'.$this->personId.'"
                    }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/MicrosoftFaceApi/deletePerson', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }
    
    public function testDeletePersonGroup() {

        $var = '{
                    "args": {
                      "subscriptionKey": "'.$this->subscriptionKey.'",
                      "personGroupId": "'.$this->personGroupId.'"
                    }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/MicrosoftFaceApi/deletePersonGroup', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

}
