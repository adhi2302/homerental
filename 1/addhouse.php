<?php
session_start();
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ownerid = $_POST["owner_id"];
    $nrooms = $_POST['no_of_rooms'];
    $rate = $_POST['rate'];
    $country = $_POST['country'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $add = $_POST['address'];
    $desc = $_POST['description'];

    // Handle image upload
    $pics = '';
    if (isset($_FILES['pics']) && $_FILES['pics']['tmp_name']) {
        $pics = addslashes(file_get_contents($_FILES['pics']['tmp_name']));
    }

    if ($ownerid != "" && $nrooms != "" && $desc != "") {
        $query = "INSERT INTO house(owner_id, no_of_rooms, rate, pics, country, state, city, address, description) 
                  VALUES('$ownerid', '$nrooms', '$rate', '$pics', '$country', '$state', '$city', '$add', '$desc')";
        $data = mysqli_query($conn, $query);

        if ($data) {
            echo "<script type='text/javascript'>alert('Added successfully'); window.location.href='houses.php';</script>";
        } else {
            echo "<script type='text/javascript'>alert('Unsuccessful'); window.location.href='houses.php';</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Add House - House Rental Management System</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <style>
    body {
      background: #f6f9fc;
    }
    .form-card {
      background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);
      border-radius: 16px;
      box-shadow: 0 4px 24px rgba(0,0,0,0.10);
      padding: 35px 30px 30px 30px;
      max-width: 540px;
      margin: 50px auto;
    }
    .form-title {
      font-size: 26px;
      font-weight: bold;
      margin-bottom: 25px;
      color: #1976d2;
      text-align: center;
      letter-spacing: 1px;
    }
    .form-group label {
      font-weight: 500;
      color: #333;
      margin-bottom: 6px;
    }
    .btn-primary {
      width: 100%;
      font-size: 18px;
      padding: 10px;
      border-radius: 8px;
      margin-top: 10px;
    }
    .preview-img {
      width: 100%;
      max-height: 180px;
      object-fit: cover;
      border-radius: 12px;
      margin-bottom: 15px;
      display: none;
      box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    .form-control:focus {
      border-color: #1976d2;
      box-shadow: 0 0 0 2px #1976d222;
    }
  </style>
</head>
<body>
<div class="container">
  <div class="form-card">
    <div class="form-title">Add House</div>
    <form method="POST" enctype="multipart/form-data" autocomplete="off">
      <div class="form-group">
        <label for="owner_id">Owner ID</label>
        <input type="text" class="form-control" id="owner_id" name="owner_id" required>
      </div>
      <div class="form-group">
        <label for="no_of_rooms">Number of Rooms</label>
        <input type="number" class="form-control" id="no_of_rooms" name="no_of_rooms" required min="1">
      </div>
      <div class="form-group">
        <label for="rate">Rate for Rent</label>
        <input type="number" class="form-control" id="rate" name="rate" required min="0">
      </div>
      <div class="form-group">
        <label for="country">Country</label>
        <input type="text" class="form-control" id="country" name="country" required>
      </div>
      <div class="form-group">
        <label for="state">State</label>
        <input type="text" class="form-control" id="state" name="state" required>
      </div>
      <div class="form-group">
        <label for="city">City</label>
        <input type="text" class="form-control" id="city" name="city" required>
      </div>
      <div class="form-group">
        <label for="address">Address</label>
        <input type="text" class="form-control" id="address" name="address" required>
      </div>
      <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
      </div>
      <div class="form-group">
        <label for="pics">House Image</label>
        <input type="file" class="form-control" id="pics" name="pics" accept="image/*" onchange="previewImage(event)">
        <img id="preview" class="preview-img" alt="Image Preview">
      </div>
      <button type="submit" class="btn btn-primary">Add House</button>
    </form>
  </div>
</div>
<script>
function previewImage(event) {
  var reader = new FileReader();
  reader.onload = function(){
    var output = document.getElementById('preview');
    output.src = reader.result;
    output.style.display = 'block';
  };
  reader.readAsDataURL(event.target.files[0]);
}
</script>
</body>
</html>