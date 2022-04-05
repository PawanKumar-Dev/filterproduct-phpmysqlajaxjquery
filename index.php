<?php
require_once 'connect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ajax Filter</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">Filter</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarColor01">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link" href="#">Features</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Pricing</a>
          </li>
        </ul>
        <form id="searchform" class="d-flex">
          <input id="search_term" class="form-control me-sm-2" type="text" placeholder="Search" name="search_term">
          <button class="btn btn-secondary my-2 my-sm-0" type="submit" name="search">Search</button>
        </form>
      </div>
    </div>
  </nav>

  <div class="container">
    <div class="row mt-3">
      <div class="col-md-3">
        <div class="card p-3">
          <legend class="mt-1">Price</legend>
          <input class="form-range inline" type="range" id="slider" value="5000" min="2000" max="20000" step="2000">
          <span id="slider_value">$5000</span>

        </div>


        <div class="card p-3 mt-2">
          <legend class="mt-1">Brand</legend>
          <div class="list-group overflow-auto" style="height: 150px;">
            <?php
            $sql = "select product_brand from product";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) :
              while ($row = mysqli_fetch_assoc($result)) : ?>
                <div class="list-group-item list-group-item-action">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="<?= $row['product_brand']; ?>" id="brandselect" name="brandselect">
                    <label class="form-check-label" for="brandselect">
                      <?= $row['product_brand']; ?>
                    </label>
                  </div>
                </div>
            <?php
              endwhile;
            endif;
            ?>
          </div>
          <br>
          <button id="brandfiltersbmt" class="btn btn-info btn-sm">Filter</button>
        </div>


        <div class="card p-3 mt-2">
          <legend class="mt-1">Ram</legend>
          <div class="list-group">
            <?php
            $sql = "select distinct product_ram from product order by product_ram";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) :
              while ($row = mysqli_fetch_assoc($result)) : ?>
                <div class="list-group-item list-group-item-action">
                  <div class="form-check">
                    <input class="form-check-input" name="ramselect" type="checkbox" value="<?= $row['product_ram']; ?>" id="ramselect">
                    <label class="form-check-label" for="ramselect">
                      <?= $row['product_ram']; ?> GB Ram
                    </label>
                  </div>
                </div>
            <?php
              endwhile;
            endif;
            ?>
          </div>
          <br>
          <button id="ramfiltersbmt" class="btn btn-info btn-sm">Filter</button>
        </div>

        <div class="card p-3 mt-2">
          <legend class="mt-1">Internal Storage</legend>
          <div class="list-group">
            <?php
            $sql = "select distinct product_storage from product order by product_storage";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) :
              while ($row = mysqli_fetch_assoc($result)) : ?>
                <div class="list-group-item list-group-item-action">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="<?= $row['product_storage']; ?>" id="storageselect" name="storageselect">
                    <label class="form-check-label" for="storageselect">
                      <?= $row['product_storage']; ?> GB
                    </label>
                  </div>
                </div>
            <?php
              endwhile;
            endif;
            ?>
          </div>
          <br>
          <button id="storagefiltersbmt" class="btn btn-info btn-sm">Filter</button>
        </div>
      </div>

      <div class="col-md-9">
        <div class="row" id="product-data-table">
          <?php
          $sql = "select * from product";
          $result = mysqli_query($conn, $sql);

          if (mysqli_num_rows($result) > 0) :
            while ($row = mysqli_fetch_assoc($result)) : ?>
              <div class="col-md-3">
                <div class="card mb-3 text-center">
                  <p class="card-header"><?= $row['product_name']; ?></p>
                  <img src="image/image-1.jpeg" class="img-fluid">
                  <p><b>Price:</b> $<?= $row['product_price']; ?></p>
                  <div class="card-body">
                    <p>Camera: <?= $row['product_camera']; ?> MP</p>
                    <p>Ram: <?= $row['product_ram']; ?> GB</p>
                    <p>Brand: <?= $row['product_brand']; ?></p>
                    <p>Storage: <?= $row['product_storage']; ?> GB</p>
                  </div>
                </div>
              </div>
          <?php
            endwhile;
          endif;
          ?>
        </div>
      </div>
    </div>
  </div>

  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>
<script>
  $(document).ready(function() {
    // Default data when page loads
    let defaultData = $("#product-data-table").html();

    // Begin--Price Range
    $(document).on('input', '#slider', function() {
      $('#slider_value').html('$' + $(this).val());

      let pr= $(this).val();
      
      $.ajax({
        type: "get",
        url: "pricefilter.php?price="+pr,
        success: function (resp) {
          if (resp == '') {
            $("#product-data-table").html("<div class='text-center'>No Product in this price range</div>");
          } else {
            $("#product-data-table").html(resp);
          }
        }
      });
    });
    // Ends--Price Range

    // Begin--Search Functionality using ajax
    $("#searchform").on("submit", function(e) {
      e.preventDefault();
      var search_term = $("#search_term").val();

      $.ajax({
        type: "get",
        url: "search.php?search_term=" + search_term,
        success: function(data) {
          $("#product-data-table").html(data);
        }
      });
    });
    //End--Search Functionality using ajax

    // Begin-- filter based on brand name
    $("#brandfiltersbmt").click(function(e) {
      e.preventDefault();
      var brndArry = [];
      $.each($("input[name='brandselect']:checked"), function() {
        brndArry.push($(this).val());
      });

      if (brndArry.length == 0) {
        location.reload();
      }

      var jsonString = JSON.stringify(brndArry);
      $.ajax({
        type: "post",
        url: "brandfilter.php",
        data: {
          data: jsonString
        },
        success: function(resp) {
          $("#product-data-table").html(resp);
        }
      });
    });
    // End-- filter based on brand name

    // Begin-- filter based on ram
    $("#ramfiltersbmt").click(function(e) {
      e.preventDefault();
      var ramArry = [];
      $.each($("input[name='ramselect']:checked"), function() {
        ramArry.push($(this).val());
      });

      if (ramArry.length == 0) {
        location.reload();
      }

      var jsonString = JSON.stringify(ramArry);
      $.ajax({
        type: "post",
        url: "ramfilter.php",
        data: {
          data: jsonString
        },
        success: function(resp) {
          $("#product-data-table").html(resp);
        }
      });
    });
    // Ends-- filter based on ram

    // Begin-- filter based on storage
    $("#storagefiltersbmt").click(function(e) {
      e.preventDefault();
      var storageArry = [];
      $.each($("input[name='storageselect']:checked"), function() {
        storageArry.push($(this).val());
      });

      if (storageArry.length == 0) {
        location.reload();
      }

      var jsonString = JSON.stringify(storageArry);
      $.ajax({
        type: "post",
        url: "storagefilter.php",
        data: {
          data: jsonString
        },
        success: function(resp) {
          $("#product-data-table").html(resp);
        }
      });
    });
    // Ends-- filter based on storage
  });
</script>

</html>