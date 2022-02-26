<?php

class users {
    private $host = 'localhost';
    private $username = 'root';
    private $password = 'root';
    private $dbname = 'CRUD_login';
    private $port = 8889;

    public $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);

        if(mysqli_connect_error()){
            trigger_error("Error is in DB" . mysqli_connect_error());
        } else {
            return $this->conn;
        }
    }

    // sign up.phpページで入力されたデータを、mySQLに格納
    public function addUser() {
        $user_name = $_POST["user_name"];
        $email = $_POST['email'];
        $phone = (int)$_POST['phone'];
        $address = $_POST['address'];
        $password = $_POST['password'];
    
        if (!empty($user_name) && !empty($email) && !empty($phone) && !empty($address) && !empty($password) && !is_numeric($user_name))
        {
            $user_id = $this->random_num(20);
            
            
            $sql = "INSERT INTO users_info (user_name, email, phone, address, password, user_id) VALUES ('$user_name', '$email', '$phone', '$address', '$password', '$user_id')";

            $this->conn->query($sql);
            header("Location:login.php");

            // if ($this->conn->query($sql)){
            //     header("Location:login.php");
            // } else {
            //     echo "We have an error" . $this->conn->error;
            // }
    
        } else {
            echo "Please enter sign up form";
        }
    }

    // ランダム数の作成 - function adduser内で使用
    public function random_num($length) {
        $text = "";
        if ($length < 5) {
            $length = 5;
        }

        $len = rand(4, $length);
        for ($i = 0; $i < $len; $i++) {
            $text .=rand(0,9);
        }
        return $text;
    }

    // ログインできるかの確認　-> login.phpで使用
    public function checkUser() {
        $user_name = $_POST['user_name'];
        $password = $_POST['password'];

        if(!empty($user_name) && !empty($password) && !is_numeric($user_name))
        {
            $query = "SELECT * from users_info where user_name = '$user_name' limit 1";
            $result = $this->conn->query($query);

            if($result)
            {
                if($result && $result->num_rows > 0) {
                    $user_data = $result->fetch_assoc();

                    if($user_data['password']===$password)
                    {
                        $_SESSION['user_id'] = $user_data['user_id'];
                        header("Location:contact.php");
                        die;
                    }
                    

                }
            } else {
                echo "wrong username or password!";
            }
        } else {
            echo "wrong username or password!";
        }
    }

    // ログインされているかの確認　-> index.phpで使用
    public function check_login() {
        if(isset($_SESSION['user_id']))
        {
            $id = $_SESSION['user_id'];
            $query = "SELECT * from users_info where user_id = '$id' limit 1";

            $result = $this->conn->query($query);

            if($result && $result->num_rows > 0)
            {
                $user_data = $result->fetch_assoc();
                return $user_data;
            }
        } else {
            header("Location:login.php");
            die;
        }

    }

    // Contact.phpページで入力されたデータを、mySQLに格納 -> contact.phpページで使用
    public function addContactForm() {
        $business_name = $_POST["business_name"];
        $contact_name = $_POST["contact_name"];
        $email = $_POST['email'];
        $phone = (int)$_POST['phone'];

        $targetDirectory = "imageFolder/";
        $targetFile = $targetDirectory . basename($_FILES['image']['name']);
        $uploadOk = true;
        
        $imageName = $this->conn->real_escape_string($targetFile);
    
        if (!empty($business_name) && !empty($contact_name) && !empty($email) && !empty($phone) && !is_numeric($business_name) && !is_numeric($contact_name))
        {

            if(getimagesize($_FILES['image']['tmp_name']) ===false)
            {
                echo "<p>Not an image!</p>";
                $uploadOk = false;
            }

            if($_FILES["image"]["size"] > 1000000) {
                echo "<p>Your image is too large. Must be less than 1MB</p>";
                $uploadOk = false;
            }

            if($uploadOk === false) {
                echo "<p>Image failed tests.</p>";
            }
            else {
                if(move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {

                    echo "<p>The File ". basename($_FILES['image']['name']) . " has been uploaded.</p>";

                    $sql = "INSERT INTO contact_info (business_name, contact_name, email, phone, image) VALUES ('$business_name', '$contact_name', '$email', '$phone', '$imageName')";

                    $this->conn->query($sql);
                    header("Location:contact.php");
        

                }
                else {
                    echo "<p>The File did not upload successfully</p>";
                }
            }

            // if ($this->conn->query($sql)){
            //     header("Location:login.php");
            // } else {
            //     echo "We have an error" . $this->conn->error;
            // }
    
        } else {
            echo "Please enter sign up form";
        }
    }

    // contact_infoデータを表に表示する -> contact.phpで使用
    public function viewUsers() {
        $sql = "SELECT * FROM contact_info";
        $result = $this->conn->query($sql);

        // 結果セットの行数を取得する
        if($result->num_rows >0){

            // for loopでaarayデータを作成するには、まず空き箱を用意する。 -> $data=array();
            $data = array();

            // Fetch a result row as an associative array
            while($row = $result->fetch_assoc()){
                $data[]=$row;
            }

            return $data;
        }

    }

    // データの削除 -> contact.phpで使用
    public function deleteUser($id){
        $sql1 =  "SELECT * FROM contact_info where id = '$id' limit 1";
        $result1 = $this->conn->query($sql1);
        $filename = $result1->fetch_assoc();

        if(file_exists($filename['image'])) {
            unlink($filename['image']);
            echo "File has been deleted";
        } else {
            echo "File could not been deleted";
        }


        $sql2 = "DELETE FROM contact_info WHERE id = '$id'";
        $result2 = $this->conn->query($sql2);
        if($result2) {
            echo "The user record has been deleted";
            header("Location:contact.php");
        } else {
            echo "No delete";
        }
    }

    // mySQlにあるデータを取得するfunction -> edit.phpで使用
    public function getRecordById($id) {
        $query = "SELECT * FROM contact_info where id = '$id' limit 1";
        $result = $this->conn->query($query);

        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        } else {
            echo "No records found";
        }

    }

    // edit.phpで修正されたデータを、mySQL上でも修正する
    public function updateUser($postData) {
        $business_name = $_POST["business_name"];
        $contact_name = $_POST["contact_name"];
        $email = $_POST['email'];
        $phone = (int)$_POST['phone'];
        $id = $_POST['id'];

        $targetDirectory = "imageFolder/";
        $targetFile = $targetDirectory . basename($_FILES['image']['name']);
        $imageName = $this->conn->real_escape_string($targetFile);

        if(getimagesize($_FILES['image']['tmp_name']) ===false)
        {
            echo "<p>Not an image!</p>";
            $uploadOk = false;
        }

        if($_FILES["image"]["size"] > 1000000) {
            echo "<p>Your image is too large. Must be less than 1MB</p>";
            $uploadOk = false;
        }

        if($uploadOk === false) {
            echo "<p>Image failed tests.</p>";
        }
        else {
            move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);

            if(!empty($id) && !empty($postData)) {
                $sql = "UPDATE contact_info SET business_name='$business_name',contact_name='$contact_name', email='$email', phone='$phone', image='$imageName' WHERE id='$id' ";

                $result = $this->conn->query($sql);

                if($sql){
                    header("Location: contact.php");
                }else{
                    echo "Updata failed";
                }


            }
        }

    }
    




}


?>