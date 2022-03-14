<?php

require 'DB.class.php';

if (isset($_POST['submit']))
{
    $name = $_POST['name'];
    $price = $_POST['price'];
    $details = $_POST['details'];

    $product = new DB();
    $product->table('products')->column('name','price','details')->values($name, $price, $details)->insert();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<body>

<main>
    <div class="container-lg w-50 card p-2 m-auto">
        <div class="card-header">
            <h3 class="text-primary">Create Product</h3>
        </div>
        <div class="card-body">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                <div class="col-md-6">
                    <label for="validationCustom01" class="form-label">Name Product</label>
                    <input type="text" name="name" id="validationCustom01" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="validationCustom02" class="form-label">Price</label>
                    <input type="number" name="price" id="validationCustom02" class="form-control">
                </div>                    
                <div class="col-md-12">
                    <label for="validationCustom03" class="form-label">Details</label>
                    <input type="text" name="details" id="validationCustom03" class="form-control">
                </div>
                
                <div class="col-12">
                    <button class="btn btn-primary" name="submit" value="submit" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</main>    

</body>
</html>