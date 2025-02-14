<?php
$link = mysqli_connect('localhost', 'root', '', 'basicWeb');
mysqli_query($link, "SET NAMES 'utf8'");
return $link;