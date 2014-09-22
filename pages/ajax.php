<?php
$test = "";

if(isset($_POST['test'])){
	$test = " param test set as: ".$_POST['test'];
}
?>

<p>RESPONSE FROM AJAX.PHP <?= $test ?></p>