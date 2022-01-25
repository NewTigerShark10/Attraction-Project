
<?php
require 'init.php';
require 'RestRequest.php';
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<div class="jumbotron bg-light mb-0 pb-3 rounded-0 justify-content-center text-center">
    <div class="container">
        <h1 class="display-4">Attractions</h1>
        <p class="lead">Search for Attractions</p>
    </div>
    <div class="container mb-4 mt-2">

        <div class="row">
            <div class="col col-12 mb-4">

                <form class="form" action="" method="GET">
                    <div class="form-group">
                        <div class="form-row">

                            <div class="col-sm">
                                <input class="col-4" name="dateFrom" type="number" placeholder="zip code">
                            </div>
                            <div class="col-sm">
                                <input class="col-4" name="dateTo" type="text" placeholder="Returning">
                            </div>

                        <div class="col col-12 px-0 mx-0 mt-2">
                            <button type="submit" name="submit" value="1" class="btn btn-primary col-4 ml-1">Search Attraction</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>





</div>

</div>

<?php
$restRequest = new RestRequest('textsearch');

if($_GET['search'] ?? null){
    $search = str_replace(' ', '_', $_GET['search']);
} else{
    $search = "coffee+shop";
}

$response = $restRequest->send('/json?query='.$search);
?>

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
    $redirect = $_ENV['BASE_URL'] . '?search=' . $response['results'][$i]['place_id'];
    echo('
    <div style="display:flex;justify-content: center;align-items: center;">
    <div class="card m-3" style="width: 18rem;">
      <img class="card-img-top" src="' . $url . '" alt="Something Went Wrong Loading The Image">
      <div class="card-body">
        <a href="'.$redirect .'"class="card-text">' . $description . '</a>
      </div>
      </div>
      </div>');
}
?>
