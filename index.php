<!doctype html>
<?php
  include('connect.php');
  $get_products = "SELECT * FROM products";
  $get_categories = "SELECT * FROM category";
  $products = mysqli_query($conn, $get_products);
  $categories = [];


  $category = mysqli_query($conn, $get_categories);
  if($category) {
    while($row = mysqli_fetch_assoc($category)) {
      $categories[$row['id']] = $row['cate_name'];
    }
  }
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles/index.css">
    <title>ATN-TOYS</title>
  </head>
  <body>
      <?php
      include('connect.php');
      $get_products = "SELECT * FROM products";
      $get_categories = "SELECT * FROM category";
      $products = mysqli_query($conn, $get_products);
      $categories = [];

      //fetch category data and store in the $categories array
      $category = mysqli_query($conn, $get_categories);
      if($category){
        while($row = mysqli_fetch_assoc($category)){
          $categories[$row['id']] = $row['cate_name'];
        }
      }
      ?>
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
                    <a class="nav-link active" aria-current="page" href="./index.php">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="./create.php">Create</a>
                  </li>
                </ul>
              </div>
            </div>
          </nav>
       <!--product--> 
       <div class="container text-center mt-3">
        <!-- 1 row of product -->
  <div class="row gap-5 justify-content-center">
    <!-- 1 col of product -->
    <?php foreach($products as $product){?>
    <div class="col-sm-3 col-md-5 col-lg-3">
        <div class="card" style="width: 18rem">
            <img src="<?php echo $product['thumbnail'];?>" class="card-img-top w-100 h-100" alt="<?php echo $product['prod_name'];?>">
            <div class="card-body">
              <h5 class="card-title"><?php echo $product['prod_name'];?></h5>
<div class="d-flex justify-content-between align-items-center">
                <p class="price text-primary fs-4">$<?php echo $product['price'];?></p>
                <p class="text-secondary fs-5">
                  <span class="badge bg-secondary">#<?php echo $categories[$product['category_id']];?></span>
                </p>
            </div>
              <a href="./update.php" type="button" class="btn btn-primary w-100">Update</a>
              <!-- Button trigger modal -->
            <button type="button" class="btn btn-danger w-100 mt-3" data-bs-toggle="modal" data-bs-target="#<?php echo $product["id"] ?>">Delete</button>
            
<!-- Modal -->
  <div class="modal fade" id="<?php echo $product["id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Are you sure to delete ?</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Once you delete, it will be removed from database
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-danger">
          <a href="index.php?delete_product_id=<?php echo $product ["id"]; ?>" class="text-white text-decoration-none">
          Yes, delete it
          </button>
        </div>
      </div>
    </div>
  </div>
            </div>
        </div>
    </div>
<?php }?>
</div>
</body>
</html>
<?php
if (isset($_GET['delete_product_id'])){
  $product_id = $_GET['delete_product_id'];
  $delete_product = "delete from products where id='$product_id'";
  $execute = mysqli_query($conn, $delete_product);

  if($execute){
    echo "<script>window.open('index.php','_self')</script>";
  }
}

?>
