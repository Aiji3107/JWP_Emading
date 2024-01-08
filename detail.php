<?php include('template/header.php');
include('admin/config_query.php');
$db = new database;
$id_artikel = $_GET['id'];
if (!empty($id_artikel)) {
  $data = $db->get_by_id($id_artikel);
  if (empty($data)) {
    echo "<cript>alert('Id artikel tidak ditemukan');document.location.href='index.php';</cript>";
  } elseif ($data['status_publish'] != 'publish') {
    echo "<cript>alert( 'artikel yang anda pilih tidak tersedia!');document.location.href='index.php';</cript>";
  }
} else {
  echo "<cript>alert(Anda Belum memilih artikel);document.location.href='index.php';</cript>";
}
?>

<div class="site-cover site-cover-sm same-height overlay single-page" style="background-image: url('files/<?= $data['header']; ?>');">
  <div class="container">
    <div class="row same-height justify-content-center">
      <div class="col-md-6">
        <div class="post-entry text-center">
          <h1 class="mb-4"><?= $data['judul_artikel']; ?></h1>
          <div class="post-meta align-items-center text-center">
            <figure class="author-figure mb-0 me-3 d-inline-block"><img src="assets/landing/images/person_1.jpg" alt="Image" class="img-fluid"></figure>
            <span class="d-inline-block mt-1">By <?= $data['name']; ?></span>
            <span>&nbsp;-&nbsp; <?php
                                if ($data['uploaded_at'] == '0000-00-00 00:00:00') {
                                  echo date('d M Y', strtotime($data['created_at']));
                                } else {
                                  echo date('d M Y', strtotime($data['uploaded_at']));
                                }
                                ?></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<section class="section">
  <div class="container">

    <div class="row blog-entries element-animate">

      <div class="col-md-12 col-lg-12 main-content">

        <div class="post-content-body">
          <?=$data['isi_artikel'];?>
        </div>






      </div>

      <!-- END main-content -->


    </div>
  </div>
</section>


<!-- Start posts-entry -->

<!-- End posts-entry -->

<?php include('template/header.php'); ?>