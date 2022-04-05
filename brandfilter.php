<?php
require_once 'connect.php';

$data = json_decode($_POST['data']);

foreach($data as $d){
  $sql = "select * from product where product_brand like '%$d%'";
  $result = mysqli_query($conn, $sql);

  while ($row = mysqli_fetch_assoc($result)) {
    echo "
    <div class='col-md-3'>
      <div class='card mb-3 text-center'>
        <p class='card-header'>".$row['product_name']."</p>
        <img src='image/image-1.jpeg' class='img-fluid'>
        <p><b>Price:</b>$".$row['product_price']."</p>
        <div class='card-body'>
          <p>Camera: ".$row['product_camera']." MP</p>
          <p>Ram: ".$row['product_ram']." GB</p>
          <p>Brand: ".$row['product_brand']."</p>
          <p>Storage: ".$row['product_storage']." GB</p>
        </div>
      </div>
    </div>";
  }
}