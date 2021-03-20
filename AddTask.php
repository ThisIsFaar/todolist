<?php

if (isset( $_POST['about_task'] )) {
	require "connect.php";
	$task = $_POST['about_task'];
	if (empty($task)) {
	 	header("Location: index.php?mess=blank");
	 } else {
	 	$sql = "INSERT INTO list (about_task) VALUES (:about_task)";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(":about_task", $_POST['about_task'], PDO::PARAM_STR);
		$stmt->execute();

		if ($stmt) {
			header("Location: index.php?mess=success");
		} else {
			header("Location: index.php");
		}
		$conn = null;
		exit();

	 }
} else {
		header("Location: index.php?mess=blank");
	}

?>