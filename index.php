<?php 

require 'DB.class.php';

$product = new DB();


$product->table('products')->select();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <link href="css/bootstrap.min.css" rel="stylesheet">
<script src="js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</head>
<body>

    <section>
        <div class="container my-5 text-end">
            <a href="create.php" class="btn btn-secondary">Add New Product</a>
        </div>
    </section>

    <main>
        <table class="table">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">name</th>
                <th scope="col">price</th>
                <th scope="col">details</th>
                <th scope="col">action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($product->result as $p) {?>
                    <tr>
                        <th scope="row">#</th>
                        <td><?php echo $p['name'];?></td>
                        <td><?php echo $p['price'];?></td>
                        <td><?php echo $p['details'];?></td>
                        <td>
                            <a href="update.php?id=<?php echo $p['id'] ?>" class="btn btn-success mx-3">Update</a>
                            <a href="delete.php?id=<?php echo $p['id'] ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php }?>
            </tbody>
        </table>
    </main>
</body>
</html>
 