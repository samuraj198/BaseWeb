<?php
$text = "<h1 class='text-center p-5'>Main page</h1>";
if (isset($_SESSION['auth']) && $_SESSION['auth'] === true) {
    $text .= "<p class='text-center'>Form</p>
                <form class='w-25' method='POST' action=''>
                    <div class='form-floating'>
                        <input type='text' class='form-control' id='floatingName' placeholder='Name'>
                        <label for='floatingName'>Name</label>
                    </div>
                    <p class='mt-3'>Choose sex</p>
                    <div class='form-check'>
                        <input class='form-check-input' type='radio' name='sex' id='flexRadioDefault1' checked>
                        <label class='form-check-label' for='flexRadioDefault1'>
                            Male
                        </label>
                    </div>
                    <div class='form-check'>
                        <input class='form-check-input' type='radio' name='sex' id='flexRadioDefault2'>
                        <label class='form-check-label' for='flexRadioDefault2'>
                            Female
                        </label>
                    </div>
                    <div class='form-floating mt-3'>
                        <textarea style='height: 100px;' class='form-control' placeholder='Describe the problem' id='floatingTextarea'></textarea>
                        <label for='floatingTextarea'>Problem</label>
                    </div>
                    <select class='form-select mt-3' aria-label='Default select example'>
                        <option selected>Choose</option>
                        <option value='1'>One</option>
                        <option value='2'>Two</option>
                        <option value='3'>Three</option>
                    </select>
                    <div class='form-check mt-3'>
                        <input class='form-check-input' type='checkbox' value='' id='flexCheckDefault'>
                        <label class='form-check-label' for='flexCheckDefault'>
                            Default checkbox
                        </label>
                    </div>
                    <div class='form-check'>
                        <input class='form-check-input' type='checkbox' value='' id='flexCheckChecked' checked>
                        <label class='form-check-label' for='flexCheckChecked'>
                            Checked checkbox
                        </label>
                    </div>
                    <div class='mt-3 d-flex justify-content-center gap-5'>
                        <button type='submit' class='btn btn-primary'>Submit</button>
                        <a href='/' class='btn btn-secondary' type='button'>Reset</a>
                    </div>
                </form>";
} else {
    $text .= "<p class='text-center text-danger'>If you want to send a form, <a href='/auth'>auth</a></p>";
}
return $text;