<?php

session_start();

include("function.php");

$contactUser = new users();

if($_SERVER['REQUEST_METHOD'] == "POST") {

    $contactUser->addContactForm();
    
}

// Display
$data = $contactUser->viewUsers();

// Delete
if(isset($_GET['del_id']) && !empty($_GET['del_id'])){
    $delId = $_GET['del_id'];
    $contactUser->deleteUser($delId);
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">

    <style>
        img {
            width: 150px;
            height: 100%;
        }
    </style>

    <title>Document</title>
</head>
<body>
    <div class="container">
        <header>
            <h2 style="color:lightgray;">CRUD Login Application </h2>
        </header>

        <div class="section">
            <h1>Contact form</h1>
            <form method="POST" enctype="multipart/form-data" action="">
                <div class="form-group">
                    <label for="business_name" class="form-label">Your business name</label>
                    <input type="business_name" class="form-control col-6" name="business_name" id="business_name" aria-describedby="business_name">
                </div>
                <div class="form-group">
                    <label for="contact_name" class="form-label">Your contact name</label>
                    <input type="text" class="form-control col-6" name ="contact_name" id="contact_name" aria-describedby="contact_name">
                </div>
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control col-6" name ="email" id="email" aria-describedby="email">
                </div>
                <div class="form-group">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control col-6" name ="phone" id="phone" aria-describedby="phone #">
                </div>

                <div class="form-group">
                    <p>Upload image</p>
                    <input type="file" class="form-control col-6" name="image" id="image" aria-describedby="phone #">
                </div>

                <input type="submit" style="margin-top: 20px;" name= "submit" value="submit" class="btn btn-danger">

            </form>


            <div style="margin-top: 20px">
                <a href="signup.php">Click here to Sign up</a><br><br>
            </div>
        </div>

        <main>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Serial #</th>
                        <th scope="col">Business name</th>
                        <th scope="col">Contact name</th>
                        <th scope="col">email</th>
                        <th scope="col">phone</th>
                        <th scope="col">image</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($data as $user){
                    ?>
                    <tr>
                        <th scope="row"><?php echo $user['id']?></th>
                        <td><?php echo $user['business_name']?></td>
                        <td><?php echo $user['contact_name']?></td>
                        <td><?php echo $user['email']?></td>
                        <td><?php echo $user['phone']?></td>
                        <td><img src="<?php echo $user['image']?>"></td>
                        <td>
                            <a href="edit.php?edit_id=<?php echo $user['id'];?>"><i class="fas fa-edit"></i></a>
                            <a href="contact.php?del_id=<?php echo $user['id'];?>"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

        </main>


    </div>


</body>

</html>