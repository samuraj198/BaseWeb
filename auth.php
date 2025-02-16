<?php
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = $link->prepare( "SELECT * FROM `users` WHERE email = ?");
    $query->execute([$email]);
    $result = $query->get_result();
    $user = $result->fetch_assoc();

    if (isset($user) && password_verify($password, $user['password'])) {
        $_SESSION['id'] = $user['id'];
        $_SESSION['auth'] = true;
        header('Location: /');
        exit;
    } else {
        $_SESSION['authError'] = "Email or password is incorrect";
        header('Location: /auth');
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
        </div>";
        if (isset($_SESSION['authError'])) {
            $text .= "<p class='mt-3 text-danger'>$_SESSION[authError]</p>";
            unset($_SESSION['authError']);
        }
    $text .= "</form>";
    $text .= "<p class='mt-3'>Don't have an account? <a href='register'>register</a></p>";
return $text;