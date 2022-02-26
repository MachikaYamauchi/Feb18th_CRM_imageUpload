<?php

include("function.php");

$editUser = new users();

// edit_idを通じて、修正したいデータをとってくる作業----------------------------------------------------------------------------------------------------
if(isset($_GET['edit_id']) && !empty($_GET['edit_id'])){
    $editId = $_GET['edit_id'];

    $userRecord = $editUser->getRecordById($editId);

} else {
    echo "we do not have edit_id";
}

// userが修正したデータを更新する----------------------------------------------------------------------------------------------------
if(isset($_POST['update'])) {
    echo "Plase Update";

    $data = $editUser->updateUser($_POST);
    echo $data;
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

    <title>Document</title>
</head>
<body>
<div class="container">
        <header>
            <h2 style="color:lightgray;">CRUD Login Application </h2>
        </header>

        <div class="section">
            <h1>Edit User Record</h1>
            <form method="POST" enctype="multipart/form-data" action="">
                <div class="form-group">
                    <label for="business_name" class="form-label">Your business name</label>
                    <input type="business_name" class="form-control col-6" value = "<?php echo $userRecord['business_name']; ?>" name="business_name" id="business_name" aria-describedby="business_name">
                </div>
                <div class="form-group">
                    <label for="contact_name" class="form-label">Your contact name</label>
                    <input type="text" class="form-control col-6" value = "<?php echo $userRecord['contact_name']; ?>" name ="contact_name" id="contact_name" aria-describedby="contact_name">
                </div>
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control col-6" value = "<?php echo $userRecord['email']; ?>" name ="email" id="email" aria-describedby="email">
                </div>
                <div class="form-group">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control col-6" value = "<?php echo $userRecord['phone']; ?>" name ="phone" id="phone" aria-describedby="phone #">
                </div>

                <div class="form-group">
                    <p>Upload image</p>
                    <input type="file" class="form-control col-6" name="image" id="image" aria-describedby="phone #">
                </div>

                <!-- 　　<input>タグのtype属性でtype="hidden"を指定すると、 ブラウザ上に表示されない非表示データを送信することができる -->
                <!-- 使う目的：ユーザーは知る必要がないけど、サーバーには送りたい情報を格納するため -->
                <!-- 例：データベースにユーザーの情報を保存するときにユーザーIDが必要。でもユーザー自身はIDを知る必要がない。そこで<input type="hidden">にユーザーIDをセットしておく。 -->
                <!-- 　　type="hidden" 　-> 　非表示データを送信する -->
                <!-- 　　name 　-> 　フォーム部分に名前をつける -->
                <!-- 　　value 　-> 　　送信される値を指定する -->
                <input type="hidden" name ="id" value ="<?php echo $userRecord['id']; ?>">

                <input type="submit" style="margin-top: 20px;" name= "update" value="Update Record" class="btn btn-danger">

            </form>

            <div style="margin-top: 20px">
                <a href="signup.php">Click here to Sign up</a><br><br>
            </div>
        </div>
    </div>
</body>
</html>