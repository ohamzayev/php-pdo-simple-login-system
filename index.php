<?php
    include 'inc/config.php';
    $title = 'Login';
    include 'inc/header.php';
    //
    if (isset($_POST['submit']))
    {
        $msg = [];
        $username = isset($_POST['username']) ? trim($_POST['username']) : NULL;
        $password = isset($_POST['password']) ? trim($_POST['password']) : NULL;
        if ($password && !$username)
        {
            $msg[] = 'Enter username';
        }
        if ($username && !$password) {
            $msg[] = 'Enter password';
        }
        if ($password && (mb_strlen($password) < 4 || mb_strlen($password) > 20)) {
            $msg[] = 'Password mus be 4-20 character';
        }
        if (!$msg && $password && $username)
        {
			$sql = "SELECT id, username, password FROM users WHERE username = :username";
            $query = $connect->prepare($sql);
            $query->bindParam(':username', $username, PDO::PARAM_STR);
            if($query->execute())
            {
                if($query->rowCount() > 0)
                {
                    $get_user = $query->fetch(PDO::FETCH_ASSOC);
                    if(password_verify($password, $get_user['password']))
                    {
                        $_SESSION['id'] = $get_user['id'];
                        $_SESSION['username'] = $username;
                        header('Location: users.php?msg=Login successfully');
                        exit();
                    } else {
                        $msg[] = "Wrong password";
                    }
                } else {
                    $msg[] = "Wrong username or password";
                }
            }
		}
	}
?>
<section>
    <div class="header">
        <h1><?php echo $title;?></h1>
    </div>
    <div class="container">
        <div class="box text-left">
            <?php
                if($msg) {
                    foreach($msg as $key => $m):
                        echo '<div class="msg">'.$m.'</div>';
                    endforeach;
                }
            ?>
            <form action="" method="POST">
                <div class="input">
                    <label for="username">Username:</label>
                    <input type="text" name="username" placeholder="Enter username" required="true"> 
                </div>
                <div class="input">
                    <label for="password">Password:</label>
                    <input type="password" name="password" placeholder="Enter password" required="true"> 
                </div>
                <div class="input">
                    <button type="submit" name="submit">Login</button>
                </div>
            </form>
        </div>
    </div>
</section>
<?php
    include 'inc/footer.php';
?>