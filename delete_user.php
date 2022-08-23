<?php
    include 'inc/config.php';
    //
    if(!$_SESSION['id']) {
        header('Location: index.php');
        exit();
    }
    //
    if (isset($_GET['id']))
    {
        $id = isset($_GET['id']) ? trim($_GET['id']) : NULL;
        if($_SESSION['id'] == $id) {
            header('Location: users.php?msg=You can\'t remove yourself');
        } else {
            $sql = "DELETE FROM users WHERE id = :id";
            $query = $connect->prepare($sql);
            $query->bindParam(':id', $id);
            $query->execute();
            if($query->rowCount()) {
                header('Location: users.php?msg=user removed');
            } else {
                header('Location: users.php?msg=Error');
            }
        }
    }
?>