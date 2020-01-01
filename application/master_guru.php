<!-- Menampilkan Data Guru (Indah) -->
<?php if ($_GET[act]==''){ ?> 
            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Semua Data Guru </h3>
                  <?php if($_SESSION[level]!='kepala'){ ?>
                  <a class='pull-right btn btn-primary btn-sm' href='index.php?view=guru&act=tambahguru'>Tambahkan Data Guru</a>
                  <?php } ?>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Kode Guru</th>
                        <th>Nama Lengkap</th>
                        <th>Jenis Kelamin</th>
                        <th>No Telpon</th>
                        <th>Status Pegawai</th>
                        <th>Jenis PTK</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $tampil = mysqli_query($koneksi,"SELECT * FROM guru a 
                                          LEFT JOIN jenis_kelamin b ON a.id_jenis_kelamin=b.id_jenis_kelamin 
                                            LEFT JOIN status_kepegawaian c ON a.id_status_kepegawaian=c.id_status_kepegawaian 
                                              LEFT JOIN jenis_ptk d ON a.id_jenis_ptk=d.id_jenis_ptk
                                              ORDER BY a.nip DESC");
                    $no = 1;
                    while($r=mysqli_fetch_array($tampil)){
                    echo "<tr><td>$no</td>
                              <td>$r[nip]</td>
                              <td>$r[nama_guru]</td>
                              <td>$r[jenis_kelamin]</td>
                              <td>$r[telepon]</td>
                              <td>$r[status_kepegawaian]</td>
                              <td>$r[jenis_ptk]</td>";
                              if($_SESSION[level]!='kepala'){
                        echo "<td><center>
                                <a class='btn btn-info btn-xs' title='Lihat Detail' href='?view=guru&act=detailguru&id=$r[nip]'>
                                <span class='glyphicon glyphicon-search'></span></a>
                                <a class='btn btn-success btn-xs' title='Edit Data' href='?view=guru&act=editguru&id=$r[nip]'>
                                <span class='glyphicon glyphicon-edit'></span></a>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='?view=guru&hapus=$r[nip]'>
                                <span class='glyphicon glyphicon-remove'></span></a>
                              </center></td>";
                              }else{
                                echo "<td><center>
                                <a class='btn btn-info btn-xs' title='Lihat Detail' href='?view=guru&act=detailguru&id=$r[nip]'>
                                <span class='glyphicon glyphicon-search'></span></a>
                              </center></td>";
                              }
                            echo "</tr>";
                      $no++;
                      }
                      // Hapus (Indah)
                      if (isset($_GET[hapus])){
                          mysqli_query($koneksi,"DELETE FROM guru where nip='$_GET[hapus]'");
                          echo "<script>document.location='index.php?view=guru';</script>";
                      }

                  ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
<!-- Tambah Guru (Indah)  -->
<?php 
}elseif($_GET[act]=='tambahguru'){
  if (isset($_POST[tambah])){
      $rtrw = explode('/',$_POST[ak]);
      $rt = $rtrw[0];
      $rw = $rtrw[1];
      $dir_gambar = 'foto_pegawai/';
      $filename = basename($_FILES['ax']['name']);
      $filenamee = date("YmdHis").'-'.basename($_FILES['ax']['name']);
      $uploadfile = $dir_gambar . $filenamee;
      $ae = tgl_simpan($_POST[ae]);
      if ($filename != ''){      
        if (move_uploaded_file($_FILES['ax']['tmp_name'], $uploadfile)) {
          mysqli_query($koneksi,"INSERT INTO guru VALUES('$_POST[aa]','$_POST[ab]','$_POST[ac]','$_POST[ad]','$ae','$_POST[af]',
          '$_POST[ag]','$_POST[ah]','$_POST[ai]','$_POST[aj]','$rt','$rw','$_POST[al]','$_POST[am]','$_POST[an]',
          '$_POST[ao]','$_POST[ap]','$_POST[aq]','$_POST[ar]','$_POST[ba]','$_POST[bc]','$_POST[bc]', 
          '$_POST[bd]','$filenamee','$_POST[be]')");
        }
      }else{
          mysqli_query($koneksi,"INSERT INTO guru VALUES('$_POST[aa]','$_POST[ab]','$_POST[ac]','$_POST[ad]','$ae','$_POST[af]',
          '$_POST[ag]','$_POST[ah]','$_POST[ai]','$_POST[aj]','$rt','$rw','$_POST[al]','$_POST[am]','$_POST[an]',
          '$_POST[ao]','$_POST[ap]','$_POST[aq]','$_POST[ar]','$_POST[ba]','$_POST[bc]','$_POST[bb]', 
          '$_POST[bd]','','$_POST[be]')");
      }
      echo "<script>document.location='index.php?view=guru&act=detailguru&id=".$_POST[aa]."';</script>";
  }

    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Tambah Data Guru</h3>
                </div>
              <div class='box-body'>
              <form method='POST' class='form-horizontal' action='' enctype='multipart/form-data'>
                <div class='col-md-6'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value='$s[nip]'>
                    <tr><th width='120px' scope='row'>Kode Guru</th>      
                    <td><input type='text' class='form-control' name='aa'></td></tr>
                    <tr><th scope='row'>Password</th>               
                    <td><input type='text' class='form-control' name='ab'></td></tr>
                    <tr><th scope='row'>Nama Lengkap</th>           
                    <td><input type='text' class='form-control' name='ac'></td></tr>
                    <tr><th scope='row'>Tempat Lahir</th>           
                    <td><input type='text' class='form-control' name='ad'></td></tr>
                    <tr><th scope='row'>Tanggal Lahir</th>          
                    <td><input type='text' style='border-radius:0px; padding-left:12px' class='datepicker form-control' value='" . date('d-m-Y') . "' name='ae' data-date-format='dd-mm-yyyy'></td></tr>
                    <tr><th scope='row'>Jenis Kelamin</th>          
                    <td><select class='form-control' name='af'> 
                        <option value='0' selected>- Pilih Jenis Kelamin -</option>"; 
                          $jk = mysqli_query($koneksi,"SELECT * FROM jenis_kelamin");
                          while($a = mysqli_fetch_array($jk)){
                              echo "<option value='$a[id_jenis_kelamin]'>$a[jenis_kelamin]</option>";
                          }
                          echo "</select></td></tr>
                <tr><th scope='row'>Agama</th>                  
                <td><select class='form-control' name='ag'> 
                    <option value='0' selected>- Pilih Agama -</option>"; 
                      $agama = mysqli_query($koneksi,"SELECT * FROM agama");
                      while($a = mysqli_fetch_array($agama)){
                          echo "<option value='$a[id_agama]'>$a[nama_agama]</option>";
                      }
                      echo "</select></td></tr>
                    <tr><th scope='row'>No Telpon</th>              
                    <td><input type='text' class='form-control' name='ah'></td></tr>
                    <tr><th scope='row'>Alamat Email</th>           
                    <td><input type='text' class='form-control' name='ai'></td></tr>
                    <tr><th scope='row'>Alamat</th>                 
                    <td><input type='text' class='form-control' name='aj'></td></tr>
                    <tr><th scope='row'>RT/RW</th>                  
                    <td><input type='text' class='form-control' value='00/00' name='ak'></td></tr>
                    <tr><th scope='row'>Dusun</th>                  
                    <td><input type='text' class='form-control' name='al'></td></tr>
                    <tr><th scope='row'>Kelurahan</th>              
                    <td><input type='text' class='form-control' name='am'></td></tr>
                    <tr><th scope='row'>Kecamatan</th>              
                    <td><input type='text' class='form-control' name='an'></td></tr>
                    <tr><th scope='row'>Kabupaten</th>              
                    <td><input type='text' class='form-control' name='ao'></td></tr>
                    <tr><th scope='row'>Kode Pos</th>               
                    <td><input type='text' class='form-control' name='ap'></td></tr>
                    <tr><th scope='row'>NUPTK</th>                  
                    <td><input type='text' class='form-control' name='aq'></td></tr>
                    <tr><th width='150px' scope='row'>NIP</th>      
                    <td><input type='text' class='form-control' name='ar'></td></tr>
                    <tr><th scope='row'>Foto</th>             
                    <td><div style='position:relative;''>
                          <a class='btn btn-primary' href='javascript:;'>
                            <span class='glyphicon glyphicon-search'></span> Browse..."; ?>
                            <input type='file' class='files' name='ax' onchange='$("#upload-file-info").html($(this).val());'>
                          <?php echo "</a> <span style='width:155px' class='label label-info' id='upload-file-info'></span>
                        </div>
                    </td></tr>
                  </tbody>
                  </table>
                </div>

                <div class='col-md-6'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                  <tr><th width='150px' scope='row'>Tamatan Guru</th>      
                  <td><input type='text' class='form-control' name='ba'></td></tr>
                  <tr><th scope='row'>Status Pegawai</th>         
                    <td><select class='form-control' name='bc'> 
                          <option value='0' selected>- Pilih Status Kepegawaian -</option>"; 
                          $status_kepegawaian = mysqli_query($koneksi,"SELECT * FROM status_kepegawaian");
                          while($a = mysqli_fetch_array($status_kepegawaian)){
                            if ($a[id_status_kepegawaian] == $s[id_status_kepegawaian]){
                              echo "<option value='$a[id_status_kepegawaian]' selected>$a[status_kepegawaian]</option>";
                            }else{
                              echo "<option value='$a[id_status_kepegawaian]'>$a[status_kepegawaian]</option>";
                            }
                          }
                           echo "</select></td></tr>
                  <tr><th scope='row'>Jenis PTK</th>              
                  <td><select class='form-control' name='bb'> 
                        <option value='0' selected>- Pilih Jenis PTK -</option>"; 
                        $ptk = mysqli_query($koneksi,"SELECT * FROM jenis_ptk");
                        while($a = mysqli_fetch_array($ptk)){
                          if ($a[id_jenis_ptk] == $s[id_jenis_ptk]){
                            echo "<option value='$a[id_jenis_ptk]' selected>$a[jenis_ptk]</option>";
                          }else{
                            echo "<option value='$a[id_jenis_ptk]'>$a[jenis_ptk]</option>";
                          }
                        }
                          echo "</select></td></tr>
                    
                    <tr><th scope='row'>Status Keaktifan</th>       
                    <td><select class='form-control' name='bd'> 
                          <option value='0' selected>- Pilih Status Keaktifan -</option>"; 
                            $status_keaktifan = mysqli_query($koneksi,"SELECT * FROM status_keaktifan");
                            while($a = mysqli_fetch_array($status_keaktifan)){
                                echo "<option value='$a[id_status_keaktifan]'>$a[nama_status_keaktifan]</option>";
                            }
                            echo "</select></td></tr>
                    <tr><th scope='row'>Golongan</th>               
                    <td><select class='form-control' name='be'> 
                    <option value='0' selected>- Pilih Golongan -</option>"; 
                      $golongan = mysqli_query($koneksi,"SELECT * FROM golongan");
                      while($a = mysqli_fetch_array($golongan)){
                          echo "<option value='$a[id_golongan]'>$a[nama_golongan]</option>";
                      }
                                  echo "</select></td></tr>
                    </tbody>
                  </table>
                </div> 
                <div style='clear:both'></div>
                        <div class='box-footer'>
                          <button type='submit' name='tambah' class='btn btn-info'>Tambahkan</button>
                          <a href='index.php?view=guru'><button type='button' class='btn btn-danger'>Kembali</button></a>
                        </div> 
              </div>
            </form>
            </div>";
// Edit Data Guru
          }elseif($_GET[act]=='editguru'){
  if (isset($_POST[update1])){
      $rtrw = explode('/',$_POST[ak]);
      $rt = $rtrw[0];
      $rw = $rtrw[1];
      $dir_gambar = 'foto_pegawai/';
      $filename = basename($_FILES['ax']['name']);
      $filenamee = date("YmdHis").'-'.basename($_FILES['ax']['name']);
      $uploadfile = $dir_gambar . $filenamee;
      $ae = tgl_simpan($_POST[ae]);
      if ($filename != ''){      
        if (move_uploaded_file($_FILES['ax']['tmp_name'], $uploadfile)) {
          mysqli_query($koneksi,"UPDATE guru SET 
                           nip          = '$_POST[aa]',
                           password     = '$_POST[ab]',
                           nama_guru         = '$_POST[ac]',
                           tempat_lahir       = '$_POST[ad]',
                           tanggal_lahir = '$ae',
                           id_jenis_kelamin       = '$_POST[af]',
                           id_agama           = '$_POST[ag]',
                           telepon       = '$_POST[ah]',
                           email        = '$_POST[ai]',
                           alamat_jalan      = '$_POST[aj]',
                           rt = '$rt',
                           rw          = '$rw',
                           nama_dusun = '$_POST[al]',
                           desa_kelurahan = '$_POST[am]',
                           kecamatan = '$_POST[an]',
                           kabupaten = '$_POST[ao]',
                           kode_pos = '$_POST[ap]',
                           nuptk = '$_POST[aq]',
                           nik = '$_POST[ar]', 
                           foto = '$filenamee', 

                           tmt = '$_POST[ba]',
                           id_jenis_ptk = '$_POST[bb]',
                           id_status_kepegawaian = '$_POST[bc]',
                           id_status_keaktifan = '$_POST[bd]',
                           id_golongan = '$_POST[be]' where nip='$_POST[id]'");
        }
      }else{
          mysqli_query($koneksi,"UPDATE guru SET 
                           nip          = '$_POST[aa]',
                           password     = '$_POST[ab]',
                           nama_guru         = '$_POST[ac]',
                           tempat_lahir       = '$_POST[ad]',
                           tanggal_lahir = '$ae',
                           id_jenis_kelamin       = '$_POST[af]',
                           id_agama           = '$_POST[ag]',
                           telepon       = '$_POST[ah]',
                           email        = '$_POST[ai]',
                           alamat_jalan      = '$_POST[aj]',
                           rt = '$rt',
                           rw          = '$rw',
                           nama_dusun = '$_POST[al]',
                           desa_kelurahan = '$_POST[am]',
                           kecamatan = '$_POST[an]',
                           kabupaten = '$_POST[ao]',
                           kode_pos = '$_POST[ap]',
                           nuptk = '$_POST[aq]',
                           nik = '$_POST[ar]', 

                           tmt = '$_POST[ba]',
                           id_jenis_ptk = '$_POST[bb]',
                           id_status_kepegawaian = '$_POST[bc]',
                           id_status_keaktifan = '$_POST[bd]',
                           id_golongan = '$_POST[be]' where nip='$_POST[id]'");
      }
      echo "<script>document.location='index.php?view=guru&act=detailguru&id=".$_POST[id]."';</script>";
  }

    $detail = mysqli_query($koneksi,"SELECT * FROM guru where nip='$_GET[id]'");
    $s = mysqli_fetch_array($detail);
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Data Guru</h3>
                </div>
              <div class='box-body'>
              <form method='POST' class='form-horizontal' action='' enctype='multipart/form-data'>
                <div class='col-md-7'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value='$s[nip]'>
                    <tr><th style='background-color:#E7EAEC' width='160px' rowspan='25'>";
                        if (trim($s[foto])==''){
                          echo "<img class='img-thumbnail' style='width:155px' src='foto_siswa/no-image.jpg'>";
                        }else{
                          echo "<img class='img-thumbnail' style='width:155px' src='foto_pegawai/$s[foto]'>";
                        }
                        echo "</th>
                    </tr>
                    <input type='hidden' name='id' value='$s[nip]'>
                    <tr><th width='120px' scope='row'>Kode_guru</th>      
                    <td><input type='text' class='form-control' value='$s[nip]' name='aa'></td></tr>
                    <tr><th scope='row'>Password</th>               
                    <td><input type='text' class='form-control' value='$s[password]' name='ab'></td></tr>
                    <tr><th scope='row'>Nama Lengkap</th>           
                    <td><input type='text' class='form-control' value='$s[nama_guru]' name='ac'></td></tr>
                    <tr><th scope='row'>Tempat Lahir</th>           
                    <td><input type='text' class='form-control' value='$s[tempat_lahir]' name='ad'></td></tr>
                    <tr><th scope='row'>Tanggal Lahir</th>          
                    <td><input type='text' style='border-radius:0px; padding-left:12px' class='datepicker form-control' value='" . tgl_view($s[tanggal_lahir]) . "' name='ae' data-date-format='dd-mm-yyyy'></td></tr>
                    <tr><th scope='row'>Jenis Kelamin</th>          
                    <td><select class='form-control' name='af'> 
                        <option value='0' selected>- Pilih Jenis Kelamin -</option>"; 
                        $jk = mysqli_query($koneksi,"SELECT * FROM jenis_kelamin");
                        while($a = mysqli_fetch_array($jk)){
                          if ($a[id_jenis_kelamin] == $s[id_jenis_kelamin]){
                            echo "<option value='$a[id_jenis_kelamin]' selected>$a[jenis_kelamin]</option>";
                          }else{
                            echo "<option value='$a[id_jenis_kelamin]'>$a[jenis_kelamin]</option>";
                          }
                        }
                        echo "</select></td></tr>
                    <tr><th scope='row'>Agama</th>                  
                    <td><select class='form-control' name='ag'> 
                        <option value='0' selected>- Pilih Agama -</option>"; 
                          $agama = mysqli_query($koneksi,"SELECT * FROM agama");
                          while($a = mysqli_fetch_array($agama)){
                            if ($a[id_agama] == $s[id_agama]){
                              echo "<option value='$a[id_agama]' selected>$a[nama_agama]</option>";
                            }else{
                              echo "<option value='$a[id_agama]'>$a[nama_agama]</option>";
                            }
                          }
                echo "</select></td></tr>
                    <tr><th scope='row'>No Telpon</th>              <td><input type='text' class='form-control' value='$s[telepon]' name='ah'></td></tr>
                    <tr><th scope='row'>Alamat Email</th>           <td><input type='text' class='form-control' value='$s[email]' name='ai'></td></tr>
                    <tr><th scope='row'>Alamat</th>                 <td><input type='text' class='form-control' value='$s[alamat_jalan]' name='aj'></td></tr>
                    <tr><th scope='row'>RT/RW</th>                  <td><input type='text' class='form-control' value='$s[rt]/$s[rw]' name='ak'></td></tr>
                    <tr><th scope='row'>Dusun</th>                  <td><input type='text' class='form-control' value='$s[nama_dusun]' name='al'></td></tr>
                    <tr><th scope='row'>Kelurahan</th>              <td><input type='text' class='form-control' value='$s[desa_kelurahan]' name='am'></td></tr>
                    <tr><th scope='row'>Kecamatan</th>              <td><input type='text' class='form-control' value='$s[kecamatan]' name='an'></td></tr>
                    <tr><th scope='row'>Kabupaten</th>              <td><input type='text' class='form-control' value='$s[kabupaten]' name='ao'></td></tr>
                    <tr><th scope='row'>Kode Pos</th>               <td><input type='text' class='form-control' value='$s[kode_pos]' name='ap'></td></tr>
                    <tr><th scope='row'>NUPTK</th>                  <td><input type='text' class='form-control' value='$s[nuptk]' name='aq'></td></tr>
                    <tr><th width='150px' scope='row'>NIP</th>      <td><input type='text' class='form-control' value='$s[nik]' name='ar'></td></tr>
                    <tr><th scope='row'>Ganti Foto</th>             <td><div style='position:relative;''>
                                                                          <a class='btn btn-primary' href='javascript:;'>
                                                                            <span class='glyphicon glyphicon-search'></span> Browse..."; ?>
                                                                            <input type='file' class='files' name='ax' onchange='$("#upload-file-info").html($(this).val());'>
                                                                          <?php echo "</a> <span style='width:155px' class='label label-info' id='upload-file-info'></span>
                                                                        </div>
                    </td></tr>
                  </tbody>
                  </table>
                </div>

                <div class='col-md-5'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                  <tr><th scope='row'>Tamatan Guru</th>                   
                  <td><input type='text' class='form-control' value='$s[tmt]' name='ba'></td></tr>
                  <tr><th scope='row'>Jenis PTK</th>              
                  <td><select class='form-control' name='bb'> 
                          <option value='0' selected>- Pilih Jenis PTK -</option>"; 
                            $ptk = mysqli_query($koneksi,"SELECT * FROM jenis_ptk");
                            while($a = mysqli_fetch_array($ptk)){
                              if ($a[id_jenis_ptk] == $s[id_jenis_ptk]){
                                echo "<option value='$a[id_jenis_ptk]' selected>$a[jenis_ptk]</option>";
                              }else{
                                echo "<option value='$a[id_jenis_ptk]'>$a[jenis_ptk]</option>";
                              }
                            }
                  echo "</select></td></tr>
                    <tr><th scope='row'>Status Pegawai</th>         
                    <td><select class='form-control' name='bc'> 
                          <option value='0' selected>- Pilih Status Kepegawaian -</option>"; 
                            $status_kepegawaian = mysqli_query($koneksi,"SELECT * FROM status_kepegawaian");
                            while($a = mysqli_fetch_array($status_kepegawaian)){
                              if ($a[id_status_kepegawaian] == $s[id_status_kepegawaian]){
                                echo "<option value='$a[id_status_kepegawaian]' selected>$a[status_kepegawaian]</option>";
                              }else{
                                echo "<option value='$a[id_status_kepegawaian]'>$a[status_kepegawaian]</option>";
                              }
                            }
                  echo "</select></td></tr>
                    <tr><th scope='row'>Status Keaktifan</th>       
                    <td><select class='form-control' name='bd'> 
                          <option value='0' selected>- Pilih Status Keaktifan -</option>"; 
                            $status_keaktifan = mysqli_query($koneksi,"SELECT * FROM status_keaktifan");
                            while($a = mysqli_fetch_array($status_keaktifan)){
                              if ($a[id_status_keaktifan] == $s[id_status_keaktifan]){
                                echo "<option value='$a[id_status_keaktifan]' selected>$a[nama_status_keaktifan]</option>";
                              }else{
                                echo "<option value='$a[id_status_keaktifan]'>$a[nama_status_keaktifan]</option>";
                              }
                            }
                  echo "</select></td></tr>
                    <tr><th scope='row'>Golongan</th>               
                    <td><select class='form-control' name='be'> 
                    <option value='0' selected>- Pilih Golongan -</option>"; 
                            $golongan = mysqli_query($koneksi,"SELECT * FROM golongan");
                            while($a = mysqli_fetch_array($golongan)){
                              if ($a[id_golongan] == $s[id_golongan]){
                                echo "<option value='$a[id_golongan]' selected>$a[nama_golongan]</option>";
                              }else{
                                echo "<option value='$a[id_golongan]'>$a[nama_golongan]</option>";
                              }
                            }
                  echo "</select></td></tr>
                  </tbody>
                  </table>
                </div> 
                <div style='clear:both'></div>
                        <div class='box-footer'>
                          <button type='submit' name='update1' class='btn btn-info'>Edit</button>
                          <a href='index.php?view=guru'><button type='button' class='btn btn-danger'>Kembali</button></a>
                        </div> 
              </div>
            </form>
            </div>";
            // Detail Data Guru Erwin
}elseif($_GET[act]=='detailguru'){
    $detail = mysqli_query($koneksi,"SELECT a.*, b.jenis_kelamin, c.status_kepegawaian, d.jenis_ptk, e.nama_agama, g.nama_golongan, f.nama_status_keaktifan 
                                FROM guru a LEFT JOIN jenis_kelamin b ON a.id_jenis_kelamin=b.id_jenis_kelamin 
                                  LEFT JOIN status_kepegawaian c ON a.id_status_kepegawaian=c.id_status_kepegawaian 
                                    LEFT JOIN jenis_ptk d ON a.id_jenis_ptk=d.id_jenis_ptk 
                                      LEFT JOIN agama e ON a.id_agama=e.id_agama 
                                        LEFT JOIN status_keaktifan f ON a.id_status_keaktifan=f.id_status_keaktifan 
                                        LEFT JOIN golongan g ON a.id_golongan=g.id_golongan
                                            where a.nip='$_GET[id]'");
    $s = mysqli_fetch_array($detail);
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Detail Data Guru</h3>
                </div>
              <div class='box-body'>
              <form method='POST' class='form-horizontal' action='' enctype='multipart/form-data'>
                <div class='col-md-7'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value='$s[nip]'>
                    <tr><th style='background-color:#E7EAEC' width='160px' rowspan='25'>";
                        if (trim($s[foto])==''){
                          echo "<img class='img-thumbnail' style='width:155px' src='foto_siswa/no-image.jpg'>";
                        }else{
                          echo "<img class='img-thumbnail' style='width:155px' src='foto_pegawai/$s[foto]'>";
                        }
                      if($_SESSION[level]!='kepala'){
                        echo "<a href='index.php?view=guru&act=editguru&id=$_GET[id]' class='btn btn-success btn-block'>Edit Profile</a>";
                        echo"<a href='index.php?view=guru'><button type='button' class='btn btn-danger btn-block'>Kembali</button></a>";
                      }
                        echo "</th>
                    </tr>
                    <tr><th width='120px' scope='row'>Kode Guru</th>      <td>$s[nip]</td></tr>
                    <tr><th scope='row'>Password</th>               <td>$s[password]</td></tr>
                    <tr><th scope='row'>Nama Lengkap</th>           <td>$s[nama_guru]</td></tr>
                    <tr><th scope='row'>Tempat Lahir</th>           <td>$s[tempat_lahir]</td></tr>
                    <tr><th scope='row'>Tanggal Lahir</th>          <td>" . tgl_indo($s[tanggal_lahir]) . "</td></tr>
                    <tr><th scope='row'>Jenis Kelamin</th>          <td>$s[jenis_kelamin]</td></tr>
                    <tr><th scope='row'>Agama</th>                  <td>$s[nama_agama]</td></tr>
                    <tr><th scope='row'>No Telpon</th>              <td>$s[telepon]</td></tr>
                    <tr><th scope='row'>Alamat Email</th>           <td>$s[email]</td></tr>
                    <tr><th scope='row'>Alamat</th>                 <td>$s[alamat_jalan]</td></tr>
                    <tr><th scope='row'>RT/RW</th>                  <td>$s[rt]/$s[rw]</td></tr>
                    <tr><th scope='row'>Dusun</th>                  <td>$s[nama_dusun]</td></tr>
                    <tr><th scope='row'>Kelurahan</th>              <td>$s[desa_kelurahan]</td></tr>
                    <tr><th scope='row'>Kecamatan</th>              <td>$s[kecamatan]</td></tr>
                    <tr><th scope='row'>Kabupaten</th>              <td>$s[kabupaten]</td></tr>
                    <tr><th scope='row'>Kode Pos</th>               <td>$s[kode_pos]</td></tr>
                    <tr><th scope='row'>NUPTK</th>                  <td>$s[nuptk]</td></tr>
                    <tr><th width='150px' scope='row'>NIP</th>      <td>$s[nik]</td></tr>
                  </tbody>
                  </table>
                </div>

                <div class='col-md-5'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <tr><th scope='row'>TMT</th>                   <td>$s[tmt]</td></tr>
                    <tr><th scope='row'>Jenis PTK</th>              <td>$s[jenis_ptk]</td></tr>
                    <tr><th scope='row'>Status Pegawai</th>         <td>$s[status_kepegawaian]</td></tr>
                    <tr><th scope='row'>Status Keaktifan</th>       <td>$s[nama_status_keaktifan]</td></tr>
                    <tr><th scope='row'>Golongan</th>               <td>$s[nama_golongan]</td></tr>

                  </tbody>
                  </table>
                </div> 
              </div>
            </form>
            </div>";
}  
?>