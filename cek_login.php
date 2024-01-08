<?php

// $pass = password_hash('jewepe123',PASSWORD_DEFAULT);
// var_dump($pass);
// die;
    include ('admin/config_query.php');
    $db = new database();

    //Inisialisasi session
    session_start();

    //cek session aktif
    if (isset($_SESSION['username']) || isset($_SESSION['id_users'])) {
        header('location: admin/index.php');

        $data = 'oke';
        var_dump($data);

        die;
    }else{
    $data = 'oke no session';
    var_dump($data);
        //cek apakah disubmit?
        if (isset($_POST['submit'])) {
            //menghilangkan backslashses
            $username = stripslashes($_POST['username']);
            $password = stripslashes($_POST['password']);

            //cek nilai username password apakah kosong
            if (!empty(trim($username)) && !empty(trim($password))) {
                //select data tb_users berdasarkan username
                $query = $db->get_data_users($username);
                //cek jika berhasil
                if ($query) {
                    $rows = mysqli_num_rows($query);
                }else{
                    $rows = 0;
                }
                //cek keterrsediaan data username
                if ($rows !=0) {
                    $getData = $query->fetch_assoc();

                    if (password_verify($password,$getData['password'])) {
                        $_SESSION['username']=$username;
                        $_SESSION['id_users']=$getData['id_users'];

                        header('location:admin/index.php');
                    }else{
                    header('location:admin/index.php?pesan=gagal');

                    }
                }else{
                    header('location:login.php?pesan=notfound');
                }

            }else{
                header('location: login.php?pesan=empty');
            }
        } else{
            header("location:login.php?pesan=empty");
        }
    }
?>