<?php

    session_start();

    if((!isset($_POST['login'])) || (!isset($_POST['password'])))
    {
        header('Location: index.php');
        exit();
    }

    require_once "dbconnect.php";

    $connect = @new mysqli($host, $user, $password, $database);   // Open connect!  @ - не пускає опис помилки

    if ($connect->connect_errno!=0) // connect error nomber != 0
    {
        echo "Error: ".$connect->connect_errno."Ops..".$connect->connect_errno;
    } else {

        $login = $_POST['login'];
        $passw = $_POST['password'];

        $sql = "SELECT * FROM users WHERE name='$login' AND password='$passw'";

        if ($rezultat = @$connect->query($sql))
        {
            $ilu_userow = $rezultat->num_rows;
            if($ilu_userow>0)
            {
                $_SESSION['zalogowany'] = true;

                $wiersz = $rezultat->fetch_assoc();     //fetch принеси
                $_SESSION['id'] = $wiersz['id'];
                $_SESSION['user']= $wiersz['name'];

                unset($_SESSION['mistake']);
                $rezultat->free_result();
                header('Location: within.php');

            } else {

                $_SESSION['mistake'] = '<span style="color:red">Не правильний логін або пароль!</span>';
                header('Location: index.php');

            }
        }

        $connect->close();  // Close connect.

    }






?>