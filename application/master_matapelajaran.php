<!-- TAMPIL DATA MAPEL @MHA -->
<?php if ($_GET[act] == '') { ?>
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Data Mata Pelajaran </h3>
        <?php if ($_SESSION[level] != 'kepala') { ?>
          <a class='pull-right btn btn-primary btn-sm' href='index.php?view=matapelajaran&act=tambah'>Tambahkan Data</a>
        <?php } ?>
      </div><!-- /.box-header -->
      <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th style='width:30px'>No</th>
              <th>Kode Mapel</th>
              <th>Nama Mapel</th>
              <th>Jurusan</th>
              <th>Tingkat</th>
              <th>Guru Pengampu</th>
              <th>KKM</th>
              <th>Urutan</th>
              <?php if ($_SESSION[level] != 'kepala') { ?>
                <th style='width:70px'>Action</th>
              <?php } ?>
            </tr>
          </thead>
          <tbody>
          <!-- RELASI DB @MHA-->
            <?php
              $tampil = mysqli_query($koneksi, "SELECT * FROM mata_pelajaran a 
                                              LEFT JOIN kelompok_mata_pelajaran b ON a.id_kelompok_mata_pelajaran=b.id_kelompok_mata_pelajaran
                                                LEFT JOIN guru c ON a.nip=c.nip 
                                                  LEFT JOIN jurusan d ON a.kode_jurusan=d.kode_jurusan
                                                      ORDER BY a.urutan ASC");
              $no = 1;
              while ($r = mysqli_fetch_array($tampil)) {
                echo "<tr><td>$no</td>
                              <td>$r[kode_pelajaran]</td>
                              <td>$r[namamatapelajaran]</td>
                              <td>$r[nama_jurusan]</td>
                              <td>$r[tingkat]</td>
                              <td>$r[nama_guru]</td>
                              <td>$r[kkm]</td>
                              <td>$r[urutan]</td>";
                if ($_SESSION[level] != 'kepala') {
                  echo "<td><center>
                                <a class='btn btn-primary btn-xs' title='Detail Data' href='?view=matapelajaran&act=detail&id=$r[kode_pelajaran]'><span class='glyphicon glyphicon-search'></span></a>
                                <a class='btn btn-success btn-xs' title='Edit Data' href='?view=matapelajaran&act=edit&id=$r[kode_pelajaran]'><span class='glyphicon glyphicon-edit'></span></a>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='?view=matapelajaran&hapus=$r[kode_pelajaran]'><span class='glyphicon glyphicon-remove'></span></a>
                              </center></td>";
                }
                echo "</tr>";
                $no++;
              }
              // HAPUS MAPEL @MHA
              if (isset($_GET[hapus])) {
                mysqli_query($koneksi, "DELETE FROM mata_pelajaran where kode_pelajaran='$_GET[hapus]'");
                echo "<script>document.location='index.php?view=matapelajaran';</script>";
              }

              ?>
          </tbody>
        </table>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div>
  <!-- EDIT MAPEL @MHA -->
<?php
} elseif ($_GET[act] == 'edit') {
  if (isset($_POST[update])) {
    mysqli_query($koneksi, "UPDATE mata_pelajaran SET 
    id_kelompok_mata_pelajaran = '$_POST[b]',
    kode_jurusan = '$_POST[c]',
    nip = '$_POST[d]',
    namamatapelajaran = '$_POST[f]',
    tingkat = '$_POST[h]',
    kkm = '$_POST[kkm]',
    id_sesi = '$_POST[z]',
    jumlah_jam = '$_POST[k]',
    urutan = '$_POST[l]',
    aktif = '$_POST[m]' where kode_pelajaran='$_POST[id]'");
    echo "<script>document.location='index.php?view=matapelajaran';</script>";
  }
  $edit = mysqli_query($koneksi, "SELECT * FROM mata_pelajaran where kode_pelajaran='$_GET[id]'");
  $s = mysqli_fetch_array($edit);
  echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Data Mata Pelajaran</h3>
                </div>
              <div class='box-body'>
              <form method='POST' class='form-horizontal' action='' enctype='multipart/form-data'>
                <div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value='$s[kode_pelajaran]'>
                    
                    <tr><th scope='row'>Kode Pelajaran</th>       
                    <td><input type='text' class='form-control' name='a' value='$s[kode_pelajaran]' disabled> </td></tr>
                    <tr><th scope='row'>Nama Mapel</th>           
                    <td><input type='text' class='form-control' name='f' value='$s[namamatapelajaran]'></td></tr>
                    <tr><th scope='row'>Jurusan</th> <td><select class='form-control' name='c'> 
                             <option value='0' selected>- Pilih Jurusan -</option>";
                      $jurusan = mysqli_query($koneksi, "SELECT * FROM jurusan");
                      while ($a = mysqli_fetch_array($jurusan)) {
                        if ($s[kode_jurusan] == $a[kode_jurusan]) {
                          echo "<option value='$a[kode_jurusan]' selected>$a[nama_jurusan]</option>";
                        } else {
                          echo "<option value='$a[kode_jurusan]'>$a[nama_jurusan]</option>";
                        }
                      }
                      echo "</select>
                    </td></tr>
                    <tr><th scope='row'>Guru Pengampu</th> <td><select class='form-control' name='d'> 
                             <option value='0' selected>- Pilih Guru Pengampu -</option>";
                      $guru = mysqli_query($koneksi, "SELECT * FROM guru");
                      while ($a = mysqli_fetch_array($guru)) {
                        if ($s[nip] == $a[nip]) {
                          echo "<option value='$a[nip]' selected>$a[nama_guru]</option>";
                        } else {
                          echo "<option value='$a[nip]'>$a[nama_guru]</option>";
                        }
                      }
                      echo "</select>
                    </td></tr>
                    <tr><th scope='row'>Tingkat</th>              <td><input type='text' class='form-control' name='h' value='$s[tingkat]'></td></tr>
                    <tr><th scope='row'>KKM</th>              <td><input type='text' class='form-control' name='kkm' value='$s[kkm]'></td></tr>
                    <tr><th scope='row'>Semester</th> <td><select class='form-control' name='z'> 
                    <option value='0' selected>- Pilih Semester -</option>";
                    $semester = mysqli_query($koneksi, "SELECT * FROM sesi");
                    while ($a = mysqli_fetch_array($semester)) {
                      if ($s[id_sesi] == $a[id_sesi]) {
                        echo "<option value='$a[id_sesi]' selected>$a[nama_sesi]</option>";
                      } else {
                        echo "<option value='$a[id_sesi]'>$a[nama_sesi]</option>";
                      }
                    }
                    echo "</select>
                    <tr><th scope='row'>Jumlah Jam</th>           <td><input type='text' class='form-control' name='k' value='$s[jumlah_jam]'></td></tr>
                    <tr><th scope='row'>Urutan</th>           <td><input type='text' class='form-control' name='l' value='$s[urutan]'></td></tr>
                    <tr><th scope='row'>Kelompok</th> <td><select class='form-control' name='b'> 
                             <option value='0' selected>- Pilih Kelompok Mata Pelajaran -</option>";
  $kelompok = mysqli_query($koneksi, "SELECT * FROM kelompok_mata_pelajaran");
  while ($a = mysqli_fetch_array($kelompok)) {
    if ($s[id_kelompok_mata_pelajaran] == $a[id_kelompok_mata_pelajaran]) {
      echo "<option value='$a[id_kelompok_mata_pelajaran]' selected>$a[nama_kelompok_mata_pelajaran]</option>";
    } else {
      echo "<option value='$a[id_kelompok_mata_pelajaran]'>$a[nama_kelompok_mata_pelajaran]</option>";
    }
  }
  echo "</select>
                    </td></tr>
                    <tr><th scope='row'>Aktif</th>                <td>";
  if ($s[aktif] == 'Ya') {
    echo "<input type='radio' name='m' value='Ya' checked> Ya
                                                                             <input type='radio' name='m' value='Tidak'> Tidak";
  } else {
    echo "<input type='radio' name='m' value='Ya'> Ya
                                                                             <input type='radio' name='m' value='Tidak' checked> Tidak";
  }
  echo "</td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='update' class='btn btn-info'>Edit</button>
                    <a href='index.php?view=matapelajaran'><button type='button' class='btn btn-danger'>Kembali</button></a>
                  </div>
              </form>
            </div>";
            // TAMBAH MAPEL @MHA
} elseif ($_GET[act] == 'tambah') {
  if (isset($_POST[tambah])) {
    mysqli_query($koneksi, "INSERT INTO mata_pelajaran VALUES
    ('$_POST[a]','$_POST[b]','$_POST[c]','$_POST[d]','$_POST[f]','$_POST[h] (SLTA)','$_POST[kkm]','$_POST[z]','$_POST[k]','$_POST[l]','$_POST[m]')");
    echo "<script>document.location='index.php?view=matapelajaran';</script>";
  }
  echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Tambah Data Mata Pelajaran</h3>
                </div>
              <div class='box-body'>
              <form method='POST' class='form-horizontal' action='' enctype='multipart/form-data'>
                <div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <tr><th scope='row'>Kode Pelajaran</th>       
                    <td><input type='text' class='form-control' name='a' value='$s[kode_pelajaran]'> </td></tr>
                    <tr><th scope='row'>Nama Mapel</th>           <td><input type='text' class='form-control' name='f' value='$s[namamatapelajaran]'></td></tr>
                    <tr><th scope='row'>Jurusan</th> <td><select class='form-control' name='c'> 
                             <option value='0' selected>- Pilih Jurusan -</option>";
                    $jurusan = mysqli_query($koneksi, "SELECT * FROM jurusan");
                    while ($a = mysqli_fetch_array($jurusan)) {
                      echo "<option value='$a[kode_jurusan]'>$a[nama_jurusan]</option>";
                    }
                    echo "</select>
                    </td></tr>
                    <tr><th scope='row'>Guru Pengampu</th> <td><select class='form-control' name='d'> 
                       <option value='0' selected>- Pilih Guru Pengampu -</option>";
                      $guru = mysqli_query($koneksi, "SELECT * FROM guru");
                      while ($a = mysqli_fetch_array($guru)) {
                        echo "<option value='$a[nip]'>$a[nama_guru]</option>";
                      }
                      echo "</select>
                    </td></tr>
                    <tr><th scope='row'>Tingkat</th>              <td><input type='text' class='form-control' name='h' value='$s[tingkat]'></td></tr>
                    <tr><th scope='row'>KKM</th>              <td><input type='text' class='form-control' name='kkm' value='$s[kkm]'></td></tr>
                    <tr><th scope='row'>semester</th> <td><select class='form-control' name='z'> 
                       <option value='0' selected>- Pilih Semester -</option>";
                      $semester = mysqli_query($koneksi, "SELECT * FROM sesi");
                      while ($a = mysqli_fetch_array($semester)) {
                        echo "<option value='$a[id_sesi]'>$a[nama_sesi]</option>";
                      }
                      echo "</select>
                    </td></tr>
                    <tr><th scope='row'>Jumlah Jam</th>           <td><input type='text' class='form-control' name='k' value='$s[jumlah_jam]'></td></tr>
                    <tr><th scope='row'>Urutan</th>           <td><input type='text' class='form-control' name='l' value='$s[urutan]'></td></tr>
                    <tr><th scope='row'>Kelompok</th> <td><select class='form-control' name='b'> 
                             <option value='0' selected>- Pilih Kelompok Mata Pelajaran -</option>";
  $kelompok = mysqli_query($koneksi, "SELECT * FROM kelompok_mata_pelajaran");
  while ($a = mysqli_fetch_array($kelompok)) {
    echo "<option value='$a[id_kelompok_mata_pelajaran]'>$a[nama_kelompok_mata_pelajaran]</option>";
  }
  echo "</select>
                    </td></tr>
                    <tr><th scope='row'>Aktif</th>                <td><input type='radio' name='m' value='Ya' checked> Ya
                                                                             <input type='radio' name='m' value='Tidak'> Tidak</td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='tambah' class='btn btn-info'>Tambahkan</button>
                    <a href='index.php?view=matapelajaran'><button type='button' class='btn btn-danger'>Kembali</button></a>
                  </div>
              </form>
            </div>";
            // DETAIL MAPEL @MHA
} elseif ($_GET[act] == 'detail') {
  $edit = mysqli_query($koneksi, "SELECT a.*, b.nama_kelompok_mata_pelajaran, c.nama_guru, e.nama_jurusan ,f.nama_sesi FROM mata_pelajaran a 
                                              JOIN kelompok_mata_pelajaran b ON a.id_kelompok_mata_pelajaran=b.id_kelompok_mata_pelajaran
                                                JOIN guru c ON a.nip=c.nip
                                                    JOIN jurusan e ON a.kode_jurusan=e.kode_jurusan
                                                    JOIN sesi f ON a.id_sesi=f.id_sesi
                                                      where a.kode_pelajaran='$_GET[id]'");
  $s = mysqli_fetch_array($edit);
  echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Detail Data Mata Pelajaran</h3>
                </div>
              <div class='box-body'>
              <form method='POST' class='form-horizontal' action='' enctype='multipart/form-data'>
                <div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <tr><th scope='row'>Kode Pelajaran</th>       <td>$s[kode_pelajaran] </td></tr>
                    <tr><th scope='row'>Nama Mapel</th>           <td>$s[namamatapelajaran]</td></tr>
                    <tr><th scope='row'>Jurusan</th>              <td>$s[nama_jurusan]</td></tr>
                    <tr><th scope='row'>Guru Pengampu</th>        <td>$s[nama_guru]</td></tr>
                    <tr><th scope='row'>Tingkat</th>              <td>$s[tingkat]</td></tr>
                    <tr><th scope='row'>KKM</th>              <td>$s[kkm]</td></tr>
                    <tr><th scope='row'>Semester</th>              <td>$s[id_sesi]</td></tr>
                   <tr><th scope='row'>Jumlah Jam</th>           <td>$s[jumlah_jam]</td></tr>
                    <tr><th scope='row'>Urutan</th>               <td>$s[urutan]</td></tr>
                    <tr><th scope='row'>Kelompok</th>             <td>$s[nama_kelompok_mata_pelajaran]</td></tr>
                    <tr><th scope='row'>Aktif</th>                <td>$s[aktif]</td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <a href='index.php?view=matapelajaran'><button type='button' class='btn btn-danger pull-right'>Kembali</button></a>
                    
                  </div>
              </form>
            </div>";
}
?>