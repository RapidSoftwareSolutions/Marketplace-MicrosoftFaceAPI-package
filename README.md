# MicrosoftFaceApi Package
Microsoft Face API, a cloud-based service that provides the most advanced face algorithms. Face API has two main functions: face detection with attributes and face recognition.
* Domain: microsoft.com
* Credentials: subscriptionKey

## How to get credentials: 
 1. Go to the [Service page](https://www.microsoft.com/cognitive-services/en-us/computer-vision-api)
 2. Create [Microsoft account](https://www.microsoft.com/cognitive-services/en-US/subscriptions) or log in. 
 3. Choose "Face - Preview" to create new subscription
 4. In **Key** section choose Key1 or Key2 and press <kbd>Show</kbd> or  <kbd>Copy</kbd>

## TOC: 
* [detectFaces](#detectFaces)
* [findSimilarFaces](#findSimilarFaces)
* [divideFacesIntoGroups](#divideFacesIntoGroups)
* [identifyFaces](#identifyFaces)
* [verifyFaceToFace](#verifyFaceToFace)
* [verifyFaceToPerson](#verifyFaceToPerson)
* [addFaceToFaceList](#addFaceToFaceList)
* [createFaceList](#createFaceList)
* [deleteFaceFromFaceList](#deleteFaceFromFaceList)
* [deleteFaceList](#deleteFaceList)
* [getFaceList](#getFaceList)
* [getFaceLists](#getFaceLists)
* [updateFaceList](#updateFaceList)
* [addPersonFace](#addPersonFace)
* [createPerson](#createPerson)
* [deletePerson](#deletePerson)
* [deletePersonFace](#deletePersonFace)
* [getPerson](#getPerson)
* [getPersonFace](#getPersonFace)
* [getPersonsInPersonGroup](#getPersonsInPersonGroup)
* [updatePerson](#updatePerson)
* [updatePersonFace](#updatePersonFace)
* [createPersonGroup](#createPersonGroup)
* [deletePersonGroup](#deletePersonGroup)
* [getPersonGroup](#getPersonGroup)
* [getPersonGroupTrainingStatus](#getPersonGroupTrainingStatus)
* [getPersonGroups](#getPersonGroups)
* [trainPersonGroup](#trainPersonGroup)
* [updatePersonGroup](#updatePersonGroup)
 
<a name="detectFaces"/>
## MicrosoftFaceApi.detectFaces
Detect human faces in an image and returns face locations, and optionally with faceIds, landmarks, and attributes.

| Field               | Type       | Description
|---------------------|------------|----------
| subscriptionKey     | credentials| Required: The api key obtained from Microsoft Cognitive Services.
| image               | String     | Required: To detect in a URL (or binary data) specified image.
| returnFaceId        | String     | Optional: Return faceIds of the detected faces or not. The default value is true.
| returnFaceLandmarks | String     | Optional: Return face landmarks of the detected faces or not. The default value is false.
| returnFaceAttributes| String     | Optional: Analyze and return the one or more specified face attributes in the comma-separated string like "returnFaceAttributes=age,gender". Supported face attributes include age, gender, headPose, smile, facialHair, and glasses. Note that each face attribute analysis has additional computational and time cost.

<a name="findSimilarFaces"/>
## MicrosoftFaceApi.findSimilarFaces
Given query face's faceId, to search the similar-looking faces from a faceId array or a faceListId. 

| Field                      | Type       | Description
|----------------------------|------------|----------
| subscriptionKey            | credentials| Required: The api key obtained from Microsoft Cognitive Services.
| faceId                     | String     | Required: faceId of the query face. User needs to call detectFaces first to get a valid faceId. Note that this faceId is not persisted and will expire in 24 hours after the detection call.
| faceListId                 | String     | Required: An existing user-specified unique candidate face list, created earlier. Parameter faceListId and faceIds should not be provided at the same time.
| faceIds                    | JSON       | Required: An array of candidate faceIds. All of them are created by detectFaces and the faceIds will expire in 24 hours after the detection call. The number of faceIds is limited to 1000. Parameter faceListId and faceIds should not be provided at the same time.
| maxNumOfCandidatesReturned | String     | Optional: The number of top similar faces returned. The valid range is [1, 1000].It defaults to 20.
| mode                       | String     | Optional: Similar face searching mode. It can be "matchPerson" or "matchFace". It defaults to "matchPerson".

### faceIds format:

```json
{
	["1cbb4b3b-3a83-457a-a3dc-3110b094dc21", "ad0a56a0-afdc-4e6c-bae2-b6dc5d6a3ee0"]
}
```

<a name="divideFacesIntoGroups"/>
## MicrosoftFaceApi.divideFacesIntoGroups
Divide candidate faces into groups based on face similarity.

| Field          | Type       | Description
|----------------|------------|----------
| subscriptionKey| credentials| Required: The api key obtained from Microsoft Cognitive Services.
| faceIds        | JSON       | Required: Array of candidate faceId created by detectFaces. The maximum is 1000 faces.

### faceIds format:

```json
{
	["1cbb4b3b-3a83-457a-a3dc-3110b094dc21", "ad0a56a0-afdc-4e6c-bae2-b6dc5d6a3ee0"]
}
```

<a name="identifyFaces"/>
## MicrosoftFaceApi.identifyFaces
Identify unknown faces from a person group.

| Field                     | Type       | Description
|---------------------------|------------|----------
| subscriptionKey           | credentials| Required: The api key obtained from Microsoft Cognitive Services.
| faceIds                   | JSON       | Required: Array of query faces faceIds, created by the detectFaces. Each of the faces are identified independently. The valid number of faceIds is between [1, 10].
| personGroupId             | String     | Required: personGroupId of the target person group, created by createPersonGroup.
| maxNumOfCandidatesReturned| String     | Optional: The range of maxNumOfCandidatesReturned is between 1 and 5 (default is 1).
| confidenceThreshold       | String     | Optional: Confidence threshold of identification, used to judge whether one face belong to one person. The range of confidenceThreshold is [0, 1] (default specified by algorithm).

### faceIds format:

```json
{
	["1cbb4b3b-3a83-457a-a3dc-3110b094dc21", "ad0a56a0-afdc-4e6c-bae2-b6dc5d6a3ee0"]
}

<a name="verifyFaceToFace"/>
## MicrosoftFaceApi.verifyFaceToFace
Verify whether two faces belong to a same person

| Field          | Type       | Description
|----------------|------------|----------
| subscriptionKey| credentials| Required: The api key obtained from Microsoft Cognitive Services.
| faceId1        | String     | Required: faceId of one face, comes from detectFaces.
| faceId2        | String     | Required: faceId of one face, comes from detectFaces.

<a name="verifyFaceToPerson"/>
## MicrosoftFaceApi.verifyFaceToPerson
Verify whether one face belongs to a person.

| Field          | Type       | Description
|----------------|------------|----------
| subscriptionKey| credentials| Required: The api key obtained from Microsoft Cognitive Services.
| faceId         | String     | Required: faceId of face, comes from detectFaces.
| personGroupId  | String     | Required: Using existing personGroupId and personId for fast loading a specified person. personGroupId is created in createPersonGroup.
| personId       | String     | Required: Specify a certain person in a person group. personId is created in createPerson.

<a name="addFaceToFaceList"/>
## MicrosoftFaceApi.addFaceToFaceList
Add a face to a face list.

| Field          | Type       | Description
|----------------|------------|----------
| subscriptionKey| credentials| Required: The api key obtained from Microsoft Cognitive Services.
| faceListId     | String     | Required: Valid character is letter in lower case or digit or '-' or '_', maximum length is 64.
| image          | String     | Required: Image url. Image file size should between 1KB to 4MB. Only one face is allowed per image.
| userData       | String     | Optional: User-specified data about the face list for any purpose. The maximum length is 1KB.
| targetFace     | String     | Optional: A face rectangle to specify the target face to be added into the face list, in the format of "targetFace=left,top,width,height". E.g. "targetFace=10,10,100,100". If there is more than one face in the image, targetFace is required to specify which face to add. No targetFace means there is only one face detected in the entire image.

<a name="createFaceList"/>
## MicrosoftFaceApi.createFaceList
Create an empty face list with user-specified faceListId, name and an optional userData. Up to 64 face lists are allowed to exist in one subscription.

| Field          | Type       | Description
|----------------|------------|----------
| subscriptionKey| credentials| Required: The api key obtained from Microsoft Cognitive Services.
| faceListId     | String     | Required: Valid character is letter in lower case or digit or '-' or '_', maximum length is 64.
| name           | String     | Required: Name of the created face list, maximum length is 128.
| userData       | String     | Optional: Optional user defined data for the face list. Length should not exceed 16KB.

<a name="deleteFaceFromFaceList"/>
## MicrosoftFaceApi.deleteFaceFromFaceList
Delete an existing face from a face list (given by a persisitedFaceId and a faceListId). Persisted image related to the face will also be deleted.

| Field          | Type       | Description
|----------------|------------|----------
| subscriptionKey| credentials| Required: The api key obtained from Microsoft Cognitive Services.
| faceListId     | String     | Required: Valid character is letter in lower case or digit or '-' or '_', maximum length is 64.
| persistedFaceId| String     | Required: persistedFaceId of an existing face. Valid character is letter in lower case or digit or '-' or '_', maximum length is 64.

<a name="deleteFaceList"/>
## MicrosoftFaceApi.deleteFaceList
Delete an existing face list according to faceListId. Persisted face images in the face list will also be deleted.

| Field          | Type       | Description
|----------------|------------|----------
| subscriptionKey| credentials| Required: The api key obtained from Microsoft Cognitive Services.
| faceListId     | String     | Required: Valid character is letter in lower case or digit or '-' or '_', maximum length is 64.

<a name="getFaceList"/>
## MicrosoftFaceApi.getFaceList
Retrieve a face list's information, including faceListId, name, userData and faces in the face list.

| Field          | Type       | Description
|----------------|------------|----------
| subscriptionKey| credentials| Required: The api key obtained from Microsoft Cognitive Services.
| faceListId     | String     | Required: Valid character is letter in lower case or digit or '-' or '_', maximum length is 64.

<a name="getFaceLists"/>
## MicrosoftFaceApi.getFaceLists
Retrieve information about all existing face lists. Only faceListId, name and userData will be returned.

| Field          | Type       | Description
|----------------|------------|----------
| subscriptionKey| credentials| Required: The api key obtained from Microsoft Cognitive Services.

<a name="updateFaceList"/>
## MicrosoftFaceApi.updateFaceList
Update information of a face list, including name and userData.

| Field          | Type       | Description
|----------------|------------|----------
| subscriptionKey| credentials| Required: The api key obtained from Microsoft Cognitive Services.
| faceListId     | String     | Required: Valid character is letter in lower case or digit or '-' or '_', maximum length is 64.
| name           | String     | Required: Name of the created face list, maximum length is 128.
| userData       | String     | Optional: Optional user defined data for the face list. Length should not exceed 16KB.

<a name="addPersonFace"/>
## MicrosoftFaceApi.addPersonFace
Add a representative face to a person for identification.

| Field          | Type       | Description
|----------------|------------|----------
| subscriptionKey| credentials| Required: The api key obtained from Microsoft Cognitive Services.
| personGroupId  | String     | Required: Specifying the person group containing the target person.
| personId       | String     | Required: Target person that the face is added to.
| image          | String     | Required: Face image URL. Valid image size is from 1KB to 4MB. Only one face is allowed per image.
| userData       | String     | Optional: User-specified data about the target face to add for any purpose. The maximum length is 1KB.
| targetFace     | String     | Optional: A face rectangle to specify the target face to be added to a person, in the format of "targetFace=left,top,width,height". E.g. "targetFace=10,10,100,100". If there is more than one face in the image, targetFace is required to specify which face to add. No targetFace means there is only one face detected in the entire image.

<a name="createPerson"/>
## MicrosoftFaceApi.createPerson
Create a new person in a specified person group.

| Field          | Type       | Description
|----------------|------------|----------
| subscriptionKey| credentials| Required: The api key obtained from Microsoft Cognitive Services.
| personGroupId  | String     | Required: Specifying the person group containing the target person.
| name           | String     | Required: Display name of the target person. The maximum length is 128.
| userData       | String     | Optional: User-specified data about the target face to add for any purpose. The maximum length is 1KB.

<a name="deletePerson"/>
## MicrosoftFaceApi.deletePerson
Delete an existing person from a person group. Persisted face images of the person will also be deleted.

| Field          | Type       | Description
|----------------|------------|----------
| subscriptionKey| credentials| Required: The api key obtained from Microsoft Cognitive Services.
| personGroupId  | String     | Required: Specifying the person group containing the person.
| personId       | String     | Required: The target personId to delete.

<a name="deletePersonFace"/>
## MicrosoftFaceApi.deletePersonFace
Delete a face from a person. Relative image for the persisted face will also be deleted.

| Field          | Type       | Description
|----------------|------------|----------
| subscriptionKey| credentials| Required: The api key obtained from Microsoft Cognitive Services.
| personGroupId  | String     | Required: Specifying the person group containing the person.
| personId       | String     | Required: The target personId to delete.
| persistedFaceId| String     | Required: The persisted face to remove.

<a name="getPerson"/>
## MicrosoftFaceApi.getPerson
Retrieve a person's information, including registered persisted faces, name and userData.

| Field          | Type       | Description
|----------------|------------|----------
| subscriptionKey| credentials| Required: The api key obtained from Microsoft Cognitive Services.
| personGroupId  | String     | Required: Specifying the person group containing the person.
| personId       | String     | Required: The target personId to delete.

<a name="getPersonFace"/>
## MicrosoftFaceApi.getPersonFace
Retrieve information about a persisted face (specified by persistedFaceId, personId and its belonging personGroupId).

| Field          | Type       | Description
|----------------|------------|----------
| subscriptionKey| credentials| Required: The api key obtained from Microsoft Cognitive Services.
| personGroupId  | String     | Required: Specifying the person group containing the person.
| personId       | String     | Required: The target personId to delete.
| persistedFaceId| String     | Required: The persistedFaceId of the target persisted face of the person.

<a name="getPersonsInPersonGroup"/>
## MicrosoftFaceApi.getPersonsInPersonGroup
List all persons in a person group, and retrieve person information (including personId, name, userData and persistedFaceIds of registered faces of the person).

| Field          | Type       | Description
|----------------|------------|----------
| subscriptionKey| credentials| Required: The api key obtained from Microsoft Cognitive Services.
| personGroupId  | String     | Required: personGroupId of the target person group.

<a name="updatePerson"/>
## MicrosoftFaceApi.updatePerson
Update name or userData of a person.

| Field          | Type       | Description
|----------------|------------|----------
| subscriptionKey| credentials| Required: The api key obtained from Microsoft Cognitive Services.
| personGroupId  | String     | Required: Specifying the person group containing the target person.
| personId       | String     | Required: personId of the target person.
| name           | String     | Required: Target person's display name. Maximum length is 128.
| userData       | String     | Optional: User-provided data attached to the person. Maximum length is 16KB.

<a name="updatePersonFace"/>
## MicrosoftFaceApi.updatePersonFace
Update a person persisted face's userData field.

| Field          | Type       | Description
|----------------|------------|----------
| subscriptionKey| credentials| Required: The api key obtained from Microsoft Cognitive Services.
| personGroupId  | String     | Required: Specifying the person group containing the target person.
| personId       | String     | Required: personId of the target person.
| persistedFaceId| String     | Required: persistedFaceId of target face, which is persisted and will not expire.
| userData       | String     | Optional: User-provided data attached to the person. Maximum length is 16KB.

<a name="createPersonGroup"/>
## MicrosoftFaceApi.createPersonGroup
Create a new person group with specified personGroupId, name and user-provided userData. 

| Field          | Type       | Description
|----------------|------------|----------
| subscriptionKey| credentials| Required: The api key obtained from Microsoft Cognitive Services.
| personGroupId  | String     | Required: User-provided personGroupId as a string. The valid characters include numbers, English letters in lower case, '-' and '_'. The maximum length of the personGroupId is 64.
| name           | String     | Required: Person group display name. The maximum length is 128.
| userData       | String     | Optional: User-provided data attached to the person group. The size limit is 16KB.

<a name="deletePersonGroup"/>
## MicrosoftFaceApi.deletePersonGroup
Delete an existing person group. Persisted face images of all people in the person group will also be deleted.

| Field          | Type       | Description
|----------------|------------|----------
| subscriptionKey| credentials| Required: The api key obtained from Microsoft Cognitive Services.
| personGroupId  | String     | Required: User-provided personGroupId as a string. The valid characters include numbers, English letters in lower case, '-' and '_'. The maximum length of the personGroupId is 64.

<a name="getPersonGroup"/>
## MicrosoftFaceApi.getPersonGroup
Retrieve the information of a person group, including its name and userData.

| Field          | Type       | Description
|----------------|------------|----------
| subscriptionKey| credentials| Required: The api key obtained from Microsoft Cognitive Services.
| personGroupId  | String     | Required: User-provided personGroupId as a string. The valid characters include numbers, English letters in lower case, '-' and '_'. The maximum length of the personGroupId is 64.

<a name="getPersonGroupTrainingStatus"/>
## MicrosoftFaceApi.getPersonGroupTrainingStatus
Retrieve the training status of a person group (completed or ongoing).

| Field          | Type       | Description
|----------------|------------|----------
| subscriptionKey| credentials| Required: The api key obtained from Microsoft Cognitive Services.
| personGroupId  | String     | Required: User-provided personGroupId as a string. The valid characters include numbers, English letters in lower case, '-' and '_'. The maximum length of the personGroupId is 64.

<a name="getPersonGroups"/>
## MicrosoftFaceApi.getPersonGroups
List person groups and their information.

| Field          | Type       | Description
|----------------|------------|----------
| subscriptionKey| credentials| Required: The api key obtained from Microsoft Cognitive Services.
| start          | String     | Optional: List person groups from the least personGroupId greater than the "start". It contains no more than 64 characters. Default is empty.
| top            | String     | Optional: The number of person groups to list, ranging in [1, 1000]. Default is 1000.

<a name="trainPersonGroup"/>
## MicrosoftFaceApi.trainPersonGroup
Queue a person group training task, the training task may not be started immediately.

| Field          | Type       | Description
|----------------|------------|----------
| subscriptionKey| credentials| Required: The api key obtained from Microsoft Cognitive Services.
| personGroupId  | String     | Required: Target person group to be trained.

<a name="updatePersonGroup"/>
## MicrosoftFaceApi.updatePersonGroup
Update an existing person group's display name and userData. The properties which does not appear in request body will not be updated.

| Field          | Type       | Description
|----------------|------------|----------
| subscriptionKey| credentials| Required: The api key obtained from Microsoft Cognitive Services.
| personGroupId  | String     | Required: personGroupId of the person group to be updated.
| name           | String     | Optional: Person group display name. The maximum length is 128.
| userData       | String     | Optional: User-provided data attached to the person group. The size limit is 16KB.

