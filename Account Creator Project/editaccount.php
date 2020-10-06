<?php
$con = new PDO('mysql:localhost=host;dbname=accountcreatorproject','root');
$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$stmt = $con->prepare('SELECT * FROM accounts WHERE idaccounts = ?');
$stmt->bindValue(1, $_GET['id']);

$stmt->execute();

$account = $stmt->fetchObject();


//-----------------------------------------------------------------------------------------------------------------------------------------------//
if(isset($_POST['submit'])) {
    //profile picture
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["profilePic"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (file_exists($target_file)) {
        echo "Sorry, file already exists. ";
        $uploadOk = 0;
    }

    if ($_FILES["profilePic"]["size"] > 2000000000) {
        echo "Sorry your files is too large. ";
        $uploadOk = 0;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png") {
        echo "Sorry only jpg files allowed. ";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "your file does not meet parameters. ";
    } else {
        if (move_uploaded_file($_FILES["profilePic"]["tmp_name"], $target_file)) {
            echo "the file" . basename($_FILES["profilePic"]["name"]) . "is uploaded. ";
        } else {
            echo "there was an error, your file was not uploaded. ";
        }
    }

    header('location:accountviewer.php');
}
//-------------------------------------------------------------------------------------------------------------------------------------------//

if($_POST) {
    $stmt = $con->prepare('UPDATE accounts set sex= ?, name= ?, surname= ?, email= ?, phone= ?, city= ?, picture= ? WHERE idaccounts = ?');
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
    $stmt->bindValue(8, $_GET['id']);
    $stmt->execute();

}


?>

<html>
<head>
    <title>create account</title>
    <link rel="stylesheet" type="text/css" href="createAccountStyle.css">
</head>
<body>
<div id="accountForm">
    <form method="post" enctype="multipart/form-data">
        Sex: <input type="radio" name="male">male</input> <input type="radio" name="female">female</input> <br></br>
        Name: <input type="text" name="name" value="<?php echo $account->name; ?>"> <br></br>
        Surname: <input type="text" name="surname" value="<?php echo $account->surname; ?>"> <br></br>
        Email: <input type="text" name="email" value="<?php echo $account->email; ?>"> <br></br>
        Phone: <input type="text" name="phone" value="<?php echo $account->phone; ?>"> <br></br>
        City: <input type="text" name="city" value="<?php echo $account->city; ?>"> <br></br>
        Profile Picture: <input type="file" name="profilePic"> <br></br>
        <input type="submit" value="Edit account" name="submit">
    </form>
</div>
</body>
</html>


