<?php

if (isset($_REQUEST['id_user'])) {

    $apiUrl = 'http://localhost:8080/api-admin/controller-user-admin/doitt/' . $_REQUEST["id_user"];
    $curl = curl_init($apiUrl);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
}
?>