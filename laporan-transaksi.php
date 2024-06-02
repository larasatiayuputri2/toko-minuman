<?php
  include 'config/conn.php';
  include 'config/url.php';
  include 'function/check-login.php';

  $tgl_mulai    = '';
  $tgl_selesai  = '';
  if($_SERVER['REQUEST_METHOD']=='POST'){
    $tgl_mulai    = $_POST['tgl_mulai'];
    $tgl_selesai  = $_POST['tgl_selesai'];
    if(strtoupper($_SESSION['level']) == 'A'){
      /* Jika user admin maka where hanya tanggal */
      $query_tgl    = " WHERE date(tb_transaksi_jual.created_at) BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
    }else{
      /* Jika user selain admin maka where id_user dan tanggal */
      $query_tgl    = " AND date(tb_transaksi_jual.created_at) BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
    }
  }else{
    $query_tgl    = "";
  }

  if(strtoupper($_SESSION['level']) == 'A'){  
    /* Jika Yang Login Admin */
    // $list_transaksi_query = 
    //   "SELECT tb_transaksi_jual_detail.*, tb_transaksi_jual.created_at, tb_produk.nama AS nama_produk, tb_transaksi_jual.nama AS nama_pembeli, tb_transaksi_jual.alamat AS alamat_pembeli
    //   FROM tb_transaksi_jual_detail
    //   INNER JOIN tb_produk
    //     ON tb_transaksi_jual_detail.id_produk = tb_produk.id_produk
    //   INNER JOIN tb_transaksi_jual
    //     ON tb_transaksi_jual_detail.id_transaksi_jual = tb_transaksi_jual.id_transaksi_jual ".
    //   $query_tgl;
    //   $list_transaksi_result= mysqli_query($conn, $list_transaksi_query);

    $list_transaksi_query = 
      "SELECT *
      FROM tb_transaksi_jual ".
      $query_tgl;
      $list_transaksi_result= mysqli_query($conn, $list_transaksi_query);
  }else{
    /* Jika Yang Login Bukan Admin */
    $list_transaksi_query =
      "SELECT *
      FROM tb_transaksi_jual 
      WHERE tb_transaksi_jual.id_user = '$_SESSION[id_user]' ".
      $query_tgl;
    $list_transaksi_result= mysqli_query($conn, $list_transaksi_query);
  }

  
?>
<!DOCTYPE html>
<html>
<head>
  <title>Laporan Transaksi</title>
  <?php include 'layout/head.php'; ?>
</head>
<body class="app header-fixed sidebar-md-show sidebar-fixed">
  <header class="app-header navbar">
    <?php include 'layout/header.php'; ?>
  </header>
  <div class="app-body">
    <div class="sidebar">
      <?php include 'layout/sidebar.php'; ?>
    </div>
    <main class="main">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item "><a href="<?= $base_url; ?>">Home</a></li>
          <li class="breadcrumb-item active">Laporan Transaksi</li>
        </ol>
      </nav>
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12 col-xl-12 ">
            <div class="card">
              <div class="card-header">
                <i class="fa fa-align-justify"></i> Laporan Transaksi</div>
              <div class="card-body">
                <form style="margin-bottom: 25px" method="POST">
                  <div class="form-row">
                    <div class="col-2">
                      <input type="text" class="form-control datepicker" placeholder="Dari Tanggal" name="tgl_mulai" required="" value="<?= $tgl_mulai;?>">
                    </div>
                    <div class="col-2">
                      <input type="text" class="form-control datepicker" placeholder="Sampai Tanggal" name="tgl_selesai" required="" value="<?= $tgl_selesai;?>">
                    </div>
                    <div class="col-3">
                      <button class="btn btn-primary">Lihat</button>
                    </div>
                  </div>
                </form>
                <div class="row">
                  <div class="col-lg-12">
                    <table class="table table-responsive-sm table-bordered table-striped datatable">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Tanggal</th>
                          <!-- <th>Minuman</th>
                          <th>Harga</th>
                          <th>Jumlah</th> -->
                          <?php if(strtoupper($_SESSION['level']) == 'A') { ?>
                            <th>Nama Pembeli</th>
                          <?php } ?>
                          <th>Alamat</th>
                          <th>Total Harga</th>
                          <th style="text-align: center;">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $no = 1;
                          while($transaksi = mysqli_fetch_array($list_transaksi_result, MYSQLI_ASSOC)){ ?>
                            <tr>
                            <td><?= $no; ?></td>
                            <td><?= $transaksi['created_at']; ?></td>
                            <?php if(strtoupper($_SESSION['level']) == 'A') { ?>
                              <td><?= $transaksi['nama']; ?></td>
                            <?php } ?>
                            <td><?= $transaksi['alamat']; ?></td>
                            <td>
                              Rp. <?= number_format($transaksi['total_harga'], 0, '', '.'); ?>
                            </td>
                            <td style="text-align: center;">
                              <a href="<?= $base_url.'detail-laporan-transaksi-jual.php?id_transaksi='.$transaksi['id_transaksi_jual']; ?>" class="btn btn-primary">
                                Detail Transaksi
                              </a>
                            </td>
                            </tr>
                            
                        <?php 
                            $no++; 
                          } 
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div><!-- end .row -->
      </div><!-- end .container-fluid -->
    </main>
  </div>
  <footer class="app-footer">
  </footer>
  <?php include 'layout/bottom.php'; ?>
  </body>
</html>