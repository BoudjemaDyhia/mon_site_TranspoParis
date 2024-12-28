<?php
// Check if the query parameter is set in the POST request
if (isset($_POST['query'])) {
    
    $query = $_POST['query'];
    $apiKey = '882863bd-bbb0-4f8b-a8c0-5212f183a5ac';
    $url = 'https://api.navitia.io/v1/coverage/fr-idf/places?q=' . urlencode($query);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: ' . $apiKey
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    if (isset($data['places']) && count($data['places']) > 0) {
        foreach ($data['places'] as $place) {
            echo '<div class="suggestion" data-id="' . $place['id'] . '">' . $place['name'] . '</div>';
        }
    } else {
        echo '<div class="no-suggestions">No suggestions found</div>';
    }
}
?>
