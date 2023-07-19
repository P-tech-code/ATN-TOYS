<html lang="en">
<head>
  <title>Create</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
  <?php
  include('connect.php');

  $get_categories = "SELECT * FROM category";
  $categories = mysqli_query($conn, $get_categories);
  $categoriesArr = [];
  if ($categories) {
    while ($row = mysqli_fetch_assoc($categories)) {
    $categoriesArr[$row['id']] = $row['cate_name'];
    }
  }
  $currentURL = $_SERVER['REQUEST_URI'];

  $parts = explode('/', $currentURL);

  $id = end($parts);

  $getProductById = "SELECT * FROM products WHERE id = '$id'";
  $currentProduct = mysqli_query($conn, $getProductById);

  if ($currentProduct & mysqli_num_rows($currentProduct) > 0) { 
    // Fetch the data 
    $productData = mysqli_fetch_assoc($currentProduct);
  }
  if ($_SERVER["REQUEST_METHOD"]=="POST"){
    //GET FORM DATA
    $title = $_POST["name"];
    $price = $_POST["price"];
    $category = $_POST["category"];
    //check if fields are not empty
    //if(empty($title)){
      //$errors[] = "Product name is required";
    //}
    //if(empty($price)){
     // $errors[] = "Price is required";
    //}
    //if(empty($category)){
      //$errors[] = "Category is required";
    //}
  
    $thumbnail = $_FILES["thumbnail"];
    $thumbnailName = $thumbnail["name"];
    $thumbnailTmpName = $thumbnail["tmp_name"];
    $thumbnailPath = "assets/". $thumbnailName;
    move_uploaded_file($thumbnailTmpName,$thumbnailPath);
  
  
    //if(empty($errors)){
      //process form submission
      $sql = "UPDATE products SET prod_name = ?, price = ?, category_id = ?, thumbnail ? WHERE id = ?"; 
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("sdis",$title, $price, $category, $thumbnailPath);//string, double, integer, string
      //execute the prepared statement
      if($stmt->execute()){
        //Redirect to the homepage
        header("Location: ../index.php");
        exit();
      }else{
        echo"Error:".$sql."<br>".$conn->error;
      }
      //close the prepared statement and database connection
      $stmt->close();
    //}
  }
  ?>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
          <a class="navbar-brand" href="./index.php">ATN-TOYS</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="./index.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="./create.php">Ceate</a>
              </li>
              <li class="nav-item dropdown">
              </li>
            </ul>
          </div>
        </div>
      </nav>
<!--Update product form-->
<form class="row container mx-auto py-3" method="POST" enctype="multipart/ form-data"> 
    <h1>Update a product</h1>
    <?php foreach ($currentProduct as $product) { ?>
    <div class="col-12 mb-3" >
        <label for="product_name" class="form-label">Product name</label>
        <input type="text" class="form-control" id="product_name" placeholder="Input product name">
    </div>
    <div class="col-12 mb-3" >
        <label for="price" class="form-label">Price</label>
        <input type="number" class="form-control" id="price" placeholder="Input product price" name="price" value="<?php echo $product["price"] ?>">
    </div>
    <div class="col-12 mb-3" >
      <label for="category" class="form-label">Category</label> 
      <select class="form-select" id="category" name="category">
        <option selected hidden value="<?php echo $product["category_id"] ?>"> 
        <?php echo "#". $categoriesArr[$product["category_id"]] ?></option>
        <?php foreach ($categories as $category) { ?>
        <option class="text-dark" value="<?php echo $category["id"] ?>"><?php echo "#". $category["cate_name"] ?></option>
        <?php } ?>
      </select>
    </div>
    <?php } ?>
    <div class="col-12 mb-3" >
        <label for="image" class="form-label">Product image</label>
        <input type="file" class="form-control" id="prod_img" value="<?php echo $product["thumbnail"] ?>" name="thumbnail">
    </div>
    <div class="d-flex justify-content-center gap-3 mt-3">
        <button class="btn btn-success">Update</button>
        <button type="button" class="btn btn-secondary">Back to product</button>
    </div>
</form>

</body>
</html>