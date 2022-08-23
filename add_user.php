<?php
    include 'inc/config.php';
    $title = 'Create User';
    include 'inc/header.php';
    //
    if(!$_SESSION['id']) {
        header('Location: index.php');
        exit();
    }
    //
    if (isset($_POST['submit']))
    {
        $msg = [];
        $name = isset($_POST['name']) ? trim($_POST['name']) : NULL;
        $email = isset($_POST['email']) ? $_POST['email'] : NULL;
        $phone = isset($_POST['phone']) ? trim($_POST['phone']) : NULL;
        $about = isset($_POST['about']) ? trim($_POST['about']) : NULL;
        $username = isset($_POST['username']) ? trim($_POST['username']) : NULL;
        $password = isset($_POST['password']) ? trim($_POST['password']) : NULL;
        if (!$name)
        {
            $msg[] = 'Enter Name';
        }
        if (!$email) {
            $msg[] = 'Enter E-mail';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $msg[] = 'Enter valid e-mail';
        }
        if (!$phone) {
            $msg[] = 'Enter phone';
        }
        if ($phone && (mb_strlen($phone) > 12 || mb_strlen($phone) < 8)) {
            $msg[] = 'Phone must be 9-11 character';
        }
        if (!$about) {
            $msg[] = 'Enter about';
        }
        if ($about && (mb_strlen($about) < 10)) {
            $msg[] = 'About must be min 10 character';
        }
        if (!$username)
        {
            $msg[] = 'Enter username';
        }
        if (!$password)
        {
            $msg[] = 'Enter password';
        }
        if ($password && (mb_strlen($password) < 4 || mb_strlen($password) > 20)) {
            $msg[] = 'Password must be 4-20 character';
        }
        if (!$msg)
        {
			$sql = "SELECT id, username, email FROM users WHERE (username=:username || email=:email)";
            $query = $connect->prepare($sql);
            $query->bindParam(':username', $username, PDO::PARAM_STR);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            if($query->execute())
            {
                if($query->rowCount() == 0)
                {
                    $hash_password = password_hash($password,  PASSWORD_BCRYPT, ['cost' => 4]);
                    $insert = "INSERT INTO users (name, email, phone, about, username, password) VALUES(:name, :email, :phone, :about, :username, :password)";
                    $record = $connect->prepare($insert);
                    $record->bindParam(':name', $name, PDO::PARAM_STR);
                    $record->bindParam(':email', $email, PDO::PARAM_STR);
                    $record->bindParam(':phone', $phone, PDO::PARAM_STR);
                    $record->bindParam(':about', $about, PDO::PARAM_INT);
                    $record->bindParam(':username', $username, PDO::PARAM_STR);
                    $record->bindParam(':password', $hash_password, PDO::PARAM_STR);
                    if($record->execute()) {
                        header('Location: users.php?msg=New user added');
                    }
                } else {
                    $msg[] = "Username or E-mail used";
                }
            }
		}
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
           <div class="text-left"> 
           <?php
                if($msg) {
                    echo '<div class="msg">';
                    foreach($msg as $key => $m):
                        echo '<p>'.$m.'</p>';
                    endforeach;
                    echo '</div>';
                }
            ?>
                <form action="" method="POST">
                    <div class="input">
                        <label for="name">Name:</label>
                        <input type="text" name="name" placeholder="Enter name" value="<?php echo ($_POST['name']) ? $_POST['name'] : ''?>" required="true"> 
                    </div>
                    <div class="input">
                        <label for="email">E-mail:</label>
                        <input type="email" name="email" placeholder="Enter e-mail" value="<?php echo ($_POST['email']) ? $_POST['email'] : ''?>" required="true"> 
                    </div>
                    <div class="input">
                        <label for="phone">Phone:</label>
                        <input type="number" name="phone" placeholder="Enter phone" value="<?php echo ($_POST['phone']) ? $_POST['phone'] : ''?>" required="true"> 
                    </div>
                    <div class="input">
                        <label for="about">About:</label>
                        <textarea name="about" placeholder="Enter about" required="true"><?php echo ($_POST['username']) ? $_POST['username'] : ''?></textarea> 
                    </div>
                    <div class="input">
                        <label for="username">Username:</label>
                        <input type="text" name="username" placeholder="Enter username" value="<?php echo ($_POST['username']) ? $_POST['username'] : ''?>" required="true"> 
                    </div>
                    <div class="input">
                        <label for="password">Password:</label>
                        <input type="password" name="password" placeholder="Enter password" required="true"> 
                    </div>
                    <div class="input">
                        <button type="submit" name="submit">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php
    include 'inc/footer.php';
?>