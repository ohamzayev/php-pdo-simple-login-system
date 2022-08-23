<?php
    include 'inc/config.php';
    $title = 'Users';
    include 'inc/header.php';
    //
    if(!$_SESSION['id']) {
        header('Location: index.php');
        exit();
    }
?>
<section>
    <div class="header">
        <h1>Hello, <?php echo $_SESSION['username'];?></h1>
    </div>
    <div class="container">
        <div class="dashboard">
            <?php
                include 'top.php';
            ?>
            <?php
                if(isset($_GET['msg']))
                {
            ?>
                <div class="msg text-left"><?php echo $_GET['msg'];?></div>
            <?php
                }            
            ?>
            <table>
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Username</td>
                        <td>E-mail</td>
                        <td>Phone</td>
                        <td>About</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $sql = 'SELECT * FROM users ORDER BY id ASC';
                    $query = $connect->query($sql);
                    while($row = $query->fetch(PDO::FETCH_ASSOC))
                    {
                ?>
                    <tr>
                        <td><?php echo $row['id']?></td>
                        <td><?php echo $row['username']?></td>
                        <td><?php echo $row['email']?></td>
                        <td><?php echo $row['phone']?></td>
                        <td><?php echo $row['about']?></td>
                        <td><?php echo ($_SESSION['id'] != $row['id']) ? '<a href="delete_user.php?id='.$row['id'].'" onclick="return confirm(\'Are you sure you want to remove the user?\')">Remove</a>' : 'Remove' ?></td>
                    </tr>
                <?php
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?php
    include 'inc/footer.php';
?>