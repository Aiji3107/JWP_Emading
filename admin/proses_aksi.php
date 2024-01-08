<?php
include('config_query.php');
$db= new database;
session_start();
$id_users = $_SESSION['id_users'];
$aksi = $_GET['aksi'];

if ($aksi == "add") {
    //disini operasi input data

    //Cek file sudah di pilih atau belum
    if($_FILES["header"]["name"]!=''){
        $tmp = explode('.',$_FILES["header"]["name"]);//memecah nama file dan extensi
        $ext = end($tmp);//mengambil extensi dari array tmp
        $filename = $tmp[0];//mengambil nilai file tanpa extention
        $allowed_ext = array("jpg","png","jpeg"); //extension yang di bolehkan

        if (in_array($ext,$allowed_ext)) {//cek validasi extention
            
            if ($_FILES["header"]["size"] <=5120000) {
                $name = $filename . '_' . rand() . '.' . $ext; // rename nama file gambar
                $path="../files/".$name;//lokasi upload file
                $uploaded = move_uploaded_file($_FILES["header"]["tmp_name"],$path);

                if ($uploaded) {
                    $insertData = $db->tambah_data($name, $_POST["judul_artikel"],$_POST["isi_artikel"],$_POST["status_publish"],$id_users); //Query insert data

                    if ($insertData) {

                        echo "<script>alert('Data Berhasil di Tambahkan!');document.location.href = 'index.php';</script>";
                    }else{

                        echo "<script>alert('Upps Data Gagal di Tambahkan!');document.location.href = 'index.php';</script>";
                    }
                }else {
                    echo "<script>alert('Upps Upload File Gagal di Tambahkan!');document.location.href = 'tambah_data.php';</script>";
                }
            }else {
                echo "<script>alert('Ukuran lebih dari 5mb!');document.location.href = 'tambah_data.php';</script>";
            }
        }else {
            echo "<script>alert('File yang di upload bukan yang di izinkan!');document.location.href = 'tambah_data.php';</script>";
        }
    }else {
        echo "<script>alert('Silahkan Pilih File Gambar!');document.location.href = 'tambah_data.php';</script>";

    }
    # code...
} elseif ($aksi == "update") {
    //disini operasi edit data
    $id_artikel = $_POST['id_artikel'];
    if (!empty($id_artikel)){

        if($_FILES['header']['name'] !=''){

            $data = $db->get_by_id($id_artikel);

            //opeasi hapus file
            if(file_exists('../files/'.$data['header']) && $data['header'])
            unlink('../files/'. $data['header']);

            $tmp = explode('.', $_FILES["header"]["name"]); //memecah nama file dan extensi
            $ext = end($tmp); //mengambil extensi dari array tmp
            $filename = $tmp[0]; //mengambil nilai file tanpa extention
            $allowed_ext = array("jpg", "png", "jpeg"); //extension yang di bolehkan

            if (in_array($ext, $allowed_ext)) { //cek validasi extention

                if ($_FILES["header"]["size"] <= 5120000) {
                    $name = $filename . '_' . rand() . '.' . $ext; // rename nama file gambar
                    $path = "../files/" . $name; //lokasi upload file
                    $uploaded = move_uploaded_file($_FILES["header"]["tmp_name"], $path);

                    if ($uploaded) {
                        $updateData = $db->update_data($name, $_POST["judul_artikel"], $_POST["isi_artikel"], $_POST["status_publish"],$_POST["id_artikel"], $id_users); //Query insert data

                        if ($insertData) {

                            echo "<script>alert('Data Berhasil di Ubah!');document.location.href = 'index.php';</script>";
                        } else {

                            echo "<script>alert('Upps Data Gagal di Ubah!');document.location.href = 'index.php';</script>";
                        }
                    } else {
                        echo "<script>alert('Upps Upload File Gagal di Ubah!');document.location.href = 'edit.php?id=".$id_artikel."';</script>";
                    }
                } else {
                    echo "<script>alert('Ukuran lebih dari 5mb!');document.location.href = 'edit.php?id=".$id_artikel."';</script>";
                }
            } else {
                echo "<script>alert('File yang di upload bukan yang di izinkan!');document.location.href = 'edit.php?id=".$id_artikel."';</script>";
            }
            
        } else{
            $updateData = $db->update_data('not_set', $_POST['judul_artikel'], $_POST['isi_artikel'], $_POST['status_publish'], $_POST['id_artikel'],$id_users);

            if ($updateData) {
                echo "<script>alert('Data Berhasil di Ubah!');document.location.href = 'index.php';</script>";
            }else{
                echo "<script>alert('Data Gagal di Ubah!');document.location.href = 'index.php';</script>";

            }
        }
    }else{
        echo "<script>alert('Anda Belum Memilih Artikel!');document.location.href = 'index.php';</script>";

    }
} elseif ($aksi == "delete") {
    //disini operasi delete data
    $id_artikel = $_GET['id'];
    if (!empty($id_artikel)) {
        $data =$db->get_by_id($id_artikel);

        //delete files
        if (file_exists('../files/' . $data['header']) && $data['header'])
        unlink('../files/' . $data['header']);

            $deleteData = $db->delete_data($id_artikel);
        if ($deleteData) {
            echo "<script>alert('Data Berhasil di Hapus!');document.location.href = 'index.php';</script>";
        } else {
            echo "<script>alert('Data Gagal di Hapus!');document.location.href = 'index.php';</script>";
        }
    }
} else{
    header('location:index.php');
    echo "<script>alert('Anda tidak mendapatkan hak akses untuk operasi ini!');document.location.href = 'index.php';</script>";
}
?>
