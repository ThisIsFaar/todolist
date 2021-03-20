<?php

if(isset($_POST['id'])){
    require 'connect.php';

    $id = $_POST['id'];

    if(empty($id)){
       echo 'error';
    }else {
        $todos = $conn->prepare("SELECT id, task_status FROM list WHERE id=?");
        $todos->execute([$id]);

        $todo = $todos->fetch();
        $uId = $todo['id'];
        $checked = $todo['task_status'];

        $uChecked = $checked ? 0 : 1;

        $res = $conn->query("UPDATE list SET task_status=$uChecked WHERE id=$uId");

        if($res){
            echo $checked;
        }else {
            echo "error";
        }
        $conn = null;
        exit();
    }
}else {
    header("Location: index.php?mess=error");
}