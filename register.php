<?php
$query = $link->prepare("SELECT * FROM `users`");
$query->execute();
$result = $query->get_result();
$users = $result->fetch_all(MYSQLI_ASSOC);

if (isset($_POST['login'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $passwordConf = $_POST['password_confirmation'];
    $email = $_POST['email'];

    $errors = [];

    if (strlen($login) < 5 || strlen($login) > 20) {
        $_SESSION['loginError'] = "Login length must be 5 to 20 characters";
        array_push($errors, $_SESSION['loginError']);
    }

    $query = $link->prepare("SELECT * FROM `users` WHERE login = ? OR email = ?");
    $query->execute([$login, $email]);
    $result = $query->get_result();
    $check = $result->fetch_assoc();

    if ($check) {
        if ($check['login'] == $login) {
            $_SESSION['loginError'] = "Login already exists";
            array_push($errors, $_SESSION['loginError']);
        }
        if ($check['email'] == $email) {
            $_SESSION['emailError'] = "This email is already registered";
            array_push($errors, $_SESSION['emailError']);
        }
    }

    if (strlen($password) < 5) {
        $_SESSION['passwordError'] = "Password must be at least 5 characters";
        array_push($errors, $_SESSION['passwordError']);
    }

    if ($password !== $passwordConf) {
        $_SESSION['passwordConfError'] = "Passwords do not match";
        array_push($errors, $_SESSION['passwordConfError']);
    }

    if (!empty($errors)) {
        header('Location: /register');
        exit;
    }

    $query = $link->prepare("INSERT INTO `users` (`login`, `password`, `email`) VALUES 
                                                                                    (?, ?, ?)");
    $query->execute([$login, $hash, $email]);
    $query->close();

    $query = $link->prepare("SELECT * FROM `users` WHERE email = ?");
    $query->execute([$email]);
    $result = $query->get_result();
    $check = $result->fetch_assoc();

    $_SESSION['id'] = $check['id'];
    $_SESSION['auth'] = true;

    header('Location: /');
    exit();
}

$text = "<h2 class='text-center p-5'>Register page</h2>";
$text .=
    "<form method='POST' action='' class='w-100 d-flex flex-column align-items-center'>
        <div class='form-floating mb-3 w-25'>
            <input required name='login' type='text' class='form-control' id='floatingLogin' 
            placeholder='Daniil/samuraj198'>
            <label for='floatingLogin'>Login</label>";
            if (isset($_SESSION['loginError'])) {
                $text .= "<p class='text-danger mt-1' id='loginError'>$_SESSION[loginError]</p>";
                unset($_SESSION['loginError']);
            }
        $text .= "</div>
        <div class='form-floating mb-3 w-25'>
            <input required name='email' type='email' class='form-control' id='floatingInput' 
            placeholder='name@example.com'>
            <label for='floatingInput'>Email address</label>";
            if (isset($_SESSION['emailError'])) {
                $text .= "<p class='text-danger mt-1' id='emailError'>$_SESSION[emailError]</p>";
                unset($_SESSION['emailError']);
            }
        $text .= "</div>
        <div class='form-floating mb-3 w-25'>
            <input required name='password' type='password' class='form-control' id='floatingPassword' 
            placeholder='Password'>
            <label for='floatingPassword'>Password</label>";
            if (isset($_SESSION['passwordError'])) {
                $text .= "<p class='text-danger mt-1' id='passwordError'>$_SESSION[passwordError]</p>";
                unset($_SESSION['passwordError']);
            }
        $text .= "</div>
        <div class='form-floating mb-3 w-25'>
            <input required name='password_confirmation' type='password' class='form-control' id='floatingPasswordConf' 
            placeholder='Password confirmation'>
            <label for='floatingPassword'>Password confirmation</label>";
            if (isset($_SESSION['passwordConfError'])) {
                $text .= "<p class='text-danger mt-1' id='passwordConfError'>$_SESSION[passwordConfError]</p>";
                unset($_SESSION['passwordConfError']);
            }
        $text .= "</div>
        <div class=''>
            <button class='btn btn-primary' type='submit'>Register</button>
        </div>
    </form>";
    $text .= "<p class='mt-3'>Already have an account? <a href='auth'>auth</a></p>";
return $text;