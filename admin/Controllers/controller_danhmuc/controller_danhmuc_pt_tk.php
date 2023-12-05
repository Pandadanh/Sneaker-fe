<?php

$apiUrl = '';
$data = array();


$sodong = 7;
if (empty($_GET['search'])) {
    $apiUrl = 'http://localhost:8080/api-admin/controller-danhmuc/show';
} else {
    $search = $_GET['search'];
    if(is_numeric($search)){
        $apiUrl = 'http://localhost:8080/api-admin/controller-danhmuc/find-iddm-danhmuc';
       
        $data = array(
            'search' => $search
        );
    }else{
        $apiUrl = 'http://localhost:8080/api-admin/controller-danhmuc/find-danhmuc';
    }  
}

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); 
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$responseData = json_decode($response, true);

if ($responseData === null) {
    die('Invalid JSON data');
}

// print_r($response);
if (is_numeric($responseData['trans_page'])) {
    $sokq = intval($responseData['trans_page']);
} else {
    $sokq = 2;
}

$sotrang = round($sokq/ $sodong + 0.4);
if (!empty($_GET['p'])) {
    $p = $_GET['p'];
} else $p = 1;

$min = $sodong * ($p - 1);
?>

<?php

$result = $responseData['data'];


foreach ($result as $row) {
?>
    <tr class="dong">
        <td><?php echo $row['idDm']; ?></td>
        <td><?php echo $row['danhMuc']; ?></td>
        <td>
            <a id="sua" href="index.php?page=danhmuc-edit&id=<?php echo $row['idDm']; ?>" class="btn btn-primary btn-xs"  >Edit</a>
            <a  id="xoa" href="#" class="btn btn-danger btn-xs" data-href="index.php?page=danhmuc-delete&id=<?php echo $row['idDm']; ?>" data-toggle="modal" data-target="#confirm-delete" >Delete</a>
        </td>
    </tr>

<?php
    
}
echo "???";
?>
<?php
for ($i = 1; $i <= $sotrang; $i++) {
    if($sotrang==1){break;}
?>
    <li class="page-item <?php if ($p == $i) echo "active"; ?>"><a class="page-link" onclick="show(<?php echo $i; ?>)"><?php echo $i; ?></php></a></li>
<?php

}

?>
