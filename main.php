<?php

if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $sex = $_POST['sex'];
    $problem = $_POST['problem'];
    $priority = $_POST['priority'];
    $time = $_POST['time'];
    if (isset($time)) {
        $time_str = implode(', ', $time);
        $query = mysqli_query($link, "INSERT INTO `problems`(`name`, `problem`, `sex`, `prefer_time`, `user_id`) 
                                                    VALUES ('$name','$problem','$sex','$time_str','$_SESSION[id]')");
        $_SESSION['success'] = "You have successfully added a message!";
        header('Location: /');
        exit;
    } else {
        $_SESSION['timeError'] = "Select your preferred time to receive an answer";
        header('Location: /');
        exit;
    }
}

$text = "<h1 class='text-center p-5'>Main page</h1>";
if (isset($_SESSION['auth']) && $_SESSION['auth'] === true) {
    $text .= "<p class='text-center'>Form</p>
                <form class='w-25' method='POST' action=''>
                    <div class='form-floating'>
                        <input name='name' required type='text' class='form-control' id='floatingName' placeholder='Name'>
                        <label for='floatingName'>Name</label>
                    </div>
                    <p class='mt-3'>Choose your sex</p>
                    <div class='form-check'>
                        <input value='Male' class='form-check-input' type='radio' name='sex' id='flexRadioDefault1' checked>
                        <label class='form-check-label' for='flexRadioDefault1'>
                            Male
                        </label>
                    </div>
                    <div class='form-check'>
                        <input value='Female' class='form-check-input' type='radio' name='sex' id='flexRadioDefault2'>
                        <label class='form-check-label' for='flexRadioDefault2'>
                            Female
                        </label>
                    </div>
                    <div class='form-floating mt-3'>
                        <textarea name='problem' required style='height: 100px;' class='form-control' placeholder='Describe the problem' id='floatingTextarea'></textarea>
                        <label for='floatingTextarea'>Problem</label>
                    </div>
                    <select name='priority' required class='form-select mt-3' aria-label='Default select example'>
                        <option disabled>Choose problem priority</option>
                        <option value='Low'>Low</option>
                        <option value='Medium'>Medium</option>
                        <option value='High'>High</option>
                    </select>
                    <p class='mt-3'>What time do you prefer to receive an answer?</p>
                    <div class='form-check'>
                        <input name='time[]' class='form-check-input' type='checkbox' value='Morning' id='flexCheckDefault'>
                        <label class='form-check-label' for='flexCheckDefault'>
                            Morning
                        </label>
                    </div>
                    <div class='form-check'>
                        <input name='time[]' class='form-check-input' type='checkbox' value='Afternoon' id='flexCheckChecked' checked>
                        <label class='form-check-label' for='flexCheckChecked'>
                            Afternoon
                        </label>
                    </div>
                    <div class='form-check'>
                        <input name='time[]' class='form-check-input' type='checkbox' value='Evening' id='flexCheckChecked'>
                        <label class='form-check-label' for='flexCheckChecked'>
                            Evening
                        </label>
                    </div>";
                    if (isset($_SESSION['timeError'])) {
                        $text .= "<p class='text-danger'>$_SESSION[timeError]</p>";
                        unset($_SESSION['timeError']);
                    }
                    $text .= "<div class='mt-3 d-flex justify-content-center gap-5'>
                        <button type='submit' class='btn btn-primary'>Submit</button>
                        <a href='/' class='btn btn-secondary' type='button'>Reset</a>
                    </div>
                </form>";
                    if (isset($_SESSION['success'])) {
                        $text .= "<p class='text-success mt-3'>$_SESSION[success]</p>";
                        unset($_SESSION['success']);
                    }
} else {
    $text .= "<p class='text-center text-danger'>If you want to send a form, <a href='/auth'>auth</a></p>";
}
return $text;