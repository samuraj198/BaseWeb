<?php
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE email='$email'"));
    if (isset($user) && password_verify($password, $user['password'])) {
        $_SESSION['id'] = $user['id'];
        $_SESSION['auth'] = true;
        header('Location: /');
        exit;
    }
}

$text = "<h2 class='text-center p-5'>Auth page</h2>";
$text .=
    "<form method='POST' action='' class='w-100 d-flex flex-column align-items-center'>
        <div class='form-floating mb-3 w-25'>
            <input required name='email' type='email' class='form-control' id='floatingInput' placeholder='name@example.com'>
            <label for='floatingInput'>Email address</label>
        </div>
        <div class='form-floating mb-3 w-25'>
            <input required name='password' type='password' class='form-control' id='floatingPassword' placeholder='Password'>
            <label for='floatingPassword'>Password</label>
        </div>
        <div class=''>
            <button class='btn btn-primary' type='submit'>Auth</button>
        </div>
    </form>";
return $text;