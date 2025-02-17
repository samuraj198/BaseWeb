<?php
if (isset($_POST['name'])) {
    $name = $_POST['name'];
    if (isset($_POST['sex'])) {
        $sex = $_POST['sex'];
    }
    $problem = $_POST['problem'];
    $priority = $_POST['priority'];
    $time = $_POST['time'];
    if (isset($time) && isset($sex)) {
        $time_str = implode(', ', $time);
        $query = $link->prepare("INSERT INTO `problems` 
                                                    (`name`, `problem`, `sex`, `prefer_time`, `user_id`, `priority`) 
                                                    VALUES (?, ?, ?, ?, ?, ?)");
        $query->execute([$name, $problem, $sex, $time_str, $_SESSION['id'], $priority]);
        $query->close();
        $_SESSION['success'] = "You have successfully added a message!";
        $name = null;
        $problem = null;
        $priority = null;
        $time = null;
        $sex = null;
        header('Location: /');
        exit;
    } else {
        if (empty($sex)) {
            $_SESSION['sexError'] = 'Select your gender to receive an answer';
        } else {
            $_SESSION['sex'] = $sex;
        }
        if (empty($time)) {
            $_SESSION['timeError'] = "Select your preferred time to receive an answer";
        } else {
            $_SESSION['time'] = $time;
        }
        $_SESSION['problem'] = $problem;
        $_SESSION['priority'] = $priority;
        $_SESSION['name'] = $name;
        header('Location: /');
        exit;
    }
}

$text = "<h1 class='text-center p-5'>Main page</h1>";
if (isset($_SESSION['auth']) && $_SESSION['auth'] === true) {
    $text .= "<p class='text-center'>Form</p>
                <form class='w-25' method='POST' action=''>
                    <div class='form-floating'>
                        <input value='" . (isset($_SESSION['name']) ? $_SESSION['name'] : '') . "' name='name' 
                        type='text' class='form-control' id='floatingName' placeholder='Name' required>
                        <label for='floatingName'>Name</label>
                    </div>
                    <p class='mt-3'>Choose your sex</p>
                    <div class='form-check'>
                        <input " . (isset($_SESSION['sex']) && $_SESSION['sex'] === 'Male' ? 'checked' : '') . " 
                        value='Male' class='form-check-input' type='radio' name='sex' id='flexRadioDefault1'>
                        <label class='form-check-label' for='flexRadioDefault1'>
                            Male
                        </label>
                    </div>
                    <div class='form-check'>
                        <input " . (isset($_SESSION['sex']) && $_SESSION['sex'] === 'Female' ? 'checked' : '') . " 
                        value='Female' class='form-check-input' type='radio' name='sex' id='flexRadioDefault2'>
                        <label class='form-check-label' for='flexRadioDefault2'>
                            Female
                        </label>
                    </div>
                    <div class='form-floating mt-3'>
                        <textarea name='problem' required style='height: 100px;' class='form-control' 
                        placeholder='Describe the problem' id='floatingTextarea'>" .
                        (isset($_SESSION['problem']) ? $_SESSION['problem'] : '') . "</textarea>
                        <label for='floatingTextarea'>Problem</label>
                    </div>
                    <select name='priority' required class='form-select mt-3' aria-label='Default select example'>
                        <option disabled>Choose problem priority</option>
                        <option " . (isset($_SESSION['priority']) && $_SESSION['priority'] === 'Low' ?
                        'selected' : '') . " value='Low'>Low</option>
                        <option " . (isset($_SESSION['priority']) && $_SESSION['priority'] === 'Medium' ?
                        'selected' : '') . " value='Medium'>Medium</option>
                        <option " . (isset($_SESSION['priority']) && $_SESSION['priority'] === 'High' ?
                        'selected' : '') . " value='High'>High</option>
                    </select>
                    <p class='mt-3'>What time do you prefer to receive an answer?</p>
                    <div class='form-check'>
                        <input " . (isset($_SESSION['time']) && in_array('Morning', $_SESSION['time']) ?
                        'checked' : '') . " name='time[]' class='form-check-input' type='checkbox' 
                        value='Morning' id='flexCheckDefault'>
                        <label class='form-check-label' for='flexCheckDefault'>
                            Morning
                        </label>
                    </div>
                    <div class='form-check'>
                        <input " . (isset($_SESSION['time']) && in_array('Afternoon', $_SESSION['time']) ?
                        'checked' : '') . " name='time[]' class='form-check-input' type='checkbox' value='Afternoon' 
                        id='flexCheckChecked'>
                        <label class='form-check-label' for='flexCheckChecked'>
                            Afternoon
                        </label>
                    </div>
                    <div class='form-check'>
                        <input " . (isset($_SESSION['time']) && in_array('Evening', $_SESSION['time']) ?
                        'checked' : '') . " name='time[]' class='form-check-input' type='checkbox' value='Evening' 
                        id='flexCheckChecked'>
                        <label class='form-check-label' for='flexCheckChecked'>
                            Evening
                        </label>
                    </div>
                    <div class='mt-3 d-flex justify-content-center gap-5'>
                        <button type='submit' class='btn btn-primary'>Submit</button>
                        <a href='/' class='btn btn-secondary' type='button'>Reset</a>
                    </div>
                </form>";
                    if (isset($_SESSION['sexError'])) {
                        $text .= "<p class='text-danger mt-3'>$_SESSION[sexError]</p>";
                        unset($_SESSION['sexError']);
                    }
                    if (isset($_SESSION['timeError'])) {
                        $text .= "<p class='text-danger mt-3'>$_SESSION[timeError]</p>";
                        unset($_SESSION['timeError']);
                    }
                    if (isset($_SESSION['success'])) {
                        $text .= "<p class='text-success mt-3'>$_SESSION[success]</p>";
                        unset($_SESSION['success']);
                    }
                    unset($_SESSION['name']);
                    unset($_SESSION['sex']);
                    unset($_SESSION['problem']);
                    unset($_SESSION['priority']);
                    unset($_SESSION['time']);
} else {
    $text .= "<p class='text-center text-danger'>If you want to send a form, <a href='/auth'>auth</a></p>";
}
return $text;