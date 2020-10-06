<?php
$con = new PDO('mysql:localhost=host;dbname=accountcreatorproject','root','');
$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//--------------------------------------------------------------------------------------------------------------------------------------------------------------//

$errors = array();
if(isset($_POST['submit'])) {
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["profilePic"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];

    if (isset($name) && trim($name) !== "" && isset($surname) && trim($surname) !== ""  && isset($email) && trim($email) !== ""  && isset($phone) && trim($phone) !== ""  && isset($city) && trim($city) !== "" ) {
        if (file_exists($target_file)) {
            array_push($errors, "Sorry, file already exists. ");
        } else {
            echo 'succesfully no file found ';
        }

        if ($_FILES["profilePic"]["size"] > 2000000000) {
            array_push($errors, "Sorry your files are too large. ");
        } else {
            echo 'size is lower than 2mb ';
        }

        if ($imageFileType != "jpg" && $imageFileType != "png") {
            array_push($errors, "Sorry only jpg files allowed. ");
        } else {
            echo 'file is a jpg or PNG ';
        }
            var_dump($errors);
                        if(count($errors) == 0 ) {
                            move_uploaded_file($_FILES["profilePic"]["tmp_name"], $target_file);
                            echo "the file" . basename($_FILES["profilePic"]["name"]) . "is uploaded. ";

                            $stmt = $con->prepare('INSERT INTO accounts(sex, name, surname, email, phone, city, picture) VALUES(?,?,?,?,?,?,?);');
                            if (isset($_POST['male'])) {
                                $stmt->bindValue(1, 1);
                            } else {
                                $stmt->bindValue(1, 0);
                            }
                            $stmt->bindValue(2, $_POST['name']);
                            $stmt->bindValue(3, $_POST['surname']);
                            $stmt->bindValue(4, $_POST['email']);
                            $stmt->bindValue(5, $_POST['phone']);
                            $stmt->bindValue(6, $_POST['city']);
                            $stmt->bindValue(7, $target_file);
                            $stmt->execute();

                            header('location:accountviewer.php');
                        } else{
                            array_push($errors, 'there was an error');
                        }

    } else {
        array_push($errors, 'Fill in all field to continue. ');
    }
}

    var_dump(isset($name));
    var_dump(isset($surname));
    var_dump(isset($email));
    var_dump(isset($phone));
    var_dump(isset($phone));



?>


<html>
<head>
    <title>create account</title>
    <link rel="stylesheet" type="text/css" href="createAccountStyle.css">
</head>
<body>
    <div id="accountForm">
        <div id="errors">
            <?php

            if(count($errors) > 0){
                foreach ($errors as  $error){
                    echo $error . '<br>';
                }
            }

            ?>
        </div>
        <form method="post" enctype="multipart/form-data">
            Sex: <input type="radio" name="male">male</input> <input type="radio" name="female">female</input> <br></br>
            Name: <input type="text" name="name"> <br></br>
            Surname: <input type="text" name="surname"> <br></br>
            Email: <input type="text" name="email"> <br></br>
            Phone: <input type="text" name="phone"> <br></br>
            City: <input type="text" name="city"> <br></br>
            Profile Picture: <input type="file" name="profilePic"> <br></br>
            <input type="submit" value="Create account" name="submit">
        </form>
    </div>
</body>
</html>


