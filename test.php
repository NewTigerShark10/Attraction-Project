<?php
require 'init.php';
require 'RestRequest.php';
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
$restRequest = new RestRequest('textsearch');

$response = $restRequest->send('/json?query=museums+near+30041');
?>
<div class="row h-100 justify-content-center align-items-center">
<?php
for($i=0;$i<count($response['results']);$i++){
    if($response['results'][$i]['price_level'] ?? NULL){
        $description = $response['results'][$i]['name'] . ' at ' .$response['results'][$i]['formatted_address'] . ' [Rating: ' .$response['results'][$i]['rating'] . '] [Price Level: ' .$response['results'][$i]['price_level'] . ']';
    } else {
        $description = $response['results'][$i]['name'] . ' at ' .$response['results'][$i]['formatted_address'] . ' [Rating: ' .$response['results'][$i]['rating'] . ']';

    }
    if($response['results'][$i]['photos'] ?? NULL){
        $url = sprintf(
            '%s%s%s%s%s',
            $_ENV['API_BASE_URL'],
            '/photo?',
            'maxwidth=400&',
            'photo_reference=' . $response['results'][$i]['photos'][0]['photo_reference'],
            '&key=' . $_ENV['API_KEY']
        );
    }else{
        $url = 'images/Placeholder_Image.png';
    }
    echo('<div class="card m-5" style="width: 18rem; ">
      <img class="card-img-top" src="' . $url . '" alt="Something Went Wrong Loading The Image">
      <div class="card-body">
        <p class="card-text">' . $description . '</p>
      </div>
    </div>');
}
?>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
