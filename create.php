<?php
include('connect.php');
$get_categories = "SELECT * FROM category";
$categories = mysqli_query($conn, $get_categories);
//$errors = [];
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
    $sql = "INSERT INTO products (prod_name, price, category_id, thumbnail) VALUES(?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdis",$title, $price, $category, $thumbnailPath);//string, double, integer, string
    //execute the prepared statement
    if($stmt->execute()){
      //Redirect to the homepage
      header("Location: index.php");
      exit();
    }else{
      echo"Error:".$sql."<br>".$conn->error;
    }
    //close the prepared statement and database connection
    $stmt->close();
  //}
}
$conn->close  ();
?>
<!DOCTYPE html>
<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Create new product</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
    </head>
    <body>
          <!--menubar-->
          <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
              <a class="navbar-brand" href="./index.php">ATN-TOYS</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="./create.php">Link</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      NEW
                    </a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="#">Action</a></li>
                      <li><a class="dropdown-item" href="#">Another action</a></li>
                      <li><hr class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                  </li>
                </ul>
                <form class="d-flex" role="search">
                  <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                  <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
              </div>
            </div>
          </nav>
        <!--Create product form-->
        <form class="row container mx-auto py-3 " novalidate method="POST" enctype="multipart/form-data">
        <h1 class="mb-3">Create a new product</h1>
        <div class="col-12">
            <label for="product_name" class="form-label">Product name</label>
            <input type="text" class="form-control" id="product_name" placeholder="Input product name" name="name">
        </div>
        <div class="col-12">
            <label for="price" class="form-label">Price</label>
            <input type="number" class="form-control" id="price" placeholder="Input product price" name="price">
        </div>
        <div class="col-12">
            <label for="category" class="form-label">Category</label>
            <select class="form-select" id="category" name="category">
              <option selected disabled value="">Choose a category</option>
              <?php foreach($categories as $category) {?>
                <option class="text-dark" value="<?php echo $category["id"]?>"><?php echo "#".$category["cate_name"]?></option>
              <?php } ?>
            </select>
        </div>
        <div class="col-12">
            <label for="image" class="form-label">Product image</label>
            <input type="file" class="form-control" id="prod_image" name="thumbnail">
        </div>
        <button class="btn btn-success mt-3 w-auto m-auto">Create</button>
        </form>
    </body>
</html>