<?php
$con = new PDO('mysql:localhost=host;dbname=accountcreatorproject','root','');
$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


if(isset($_GET['id'])) {
    $stmt= $con->prepare('SELECT * FROM accounts WHERE idaccounts = ?');
    $stmt->bindValue(1, $_GET['id']);
    $stmt->execute();

    $account = $stmt->fetchObject();

    $stmt = $con->prepare('DELETE FROM accounts WHERE idaccounts = ?');
    $stmt->bindValue(1, $_GET['id']);

    $stmt->execute();
    unlink($account->picture);

    header("location:accountviewer.php");
}

?>

<html>
<head>
    <title>account viewer</title>
    <link rel="stylesheet" type="text/css" href="createAccountStyle.css">
</head>
<body>
<?php


$stmt = $con->prepare('SELECT * FROM accounts;');
$stmt->execute();
$accounts= $stmt->fetchAll(PDO::FETCH_OBJ);

$theSex = 0;

foreach ($accounts as $account){
    if ($account->sex == 1){
        $theSex = 'male';
    }else{
        $theSex = 'female';
    }

    echo "<div id='account'>";
       echo "<div>";
       echo "<img id='img' src='$account->picture'>";
       echo "</div>";

       echo "<div id='name'>";
       echo "Name: $account->name";
       echo "</div>";

       echo "<div id='surname'>";
       echo "Surname: $account->surname";
       echo "</div>";

       echo "<div id='sex'>";
       echo "Sex: $theSex";
       echo "</div>";

       echo "<div id='email'>";
       echo "Email: $account->email";
       echo "</div>";

       echo "<div id='phone'>";
       echo "Phone: $account->phone";
       echo "</div>";

       echo "<div id='city'>";
       echo "City: $account->city";
       echo "</div>";

       echo "<div id='delete'>";
       echo "<a href='accountviewer.php?id=$account->idaccounts'>delete account</a>";
       echo "</div>";

       echo "<div id='edit'>";
       echo "<a href='editaccount.php?id=$account->idaccounts'>edit account</a>";
       echo "</div>";
    echo "</div>";
}
?>
</body>
</html>
