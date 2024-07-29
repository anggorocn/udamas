<?
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");
?>

<div class="row">
  <div class="col-md-12">
    <div class="judul-halaman">
      <h1>Data Utama</h1>
      <h6>
        <span class="ikon"><i class="fa fa-arrow-right" aria-hidden="true"></i></span>&nbsp;&nbsp;
        <span>Halaman data utama</span>
      </h6>
    </div>

    <div class="area-panel">
      <div class="judul-panel">Data Pribadi</div>
      <form class="form-horizontal" action="/action_page.php">

        <div class="form-group">
          <label class="control-label col-sm-2" for="">NIP Baru:
            <span aria-label="813/11/415.42/2011" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
          </label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="" placeholder="Enter email" value="198305022011011001">
          </div>
          <label class="control-label col-sm-2" for="">NIP Lama:</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="" placeholder="Enter email">
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="">Nama:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="" placeholder="Enter email">
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="">Status Pegawai:</label>
          <div class="col-sm-2">
            <input type="text" class="form-control" id="" placeholder="Enter email" value="PNS">
          </div>
          <label class="control-label col-sm-2" for="">Kedudukan:</label>
          <div class="col-sm-2">
            <input type="text" class="form-control" id="" placeholder="Enter email" value="Terkena Hukuman Disiplin">
          </div>
          <label class="control-label col-sm-2" for="">TMT Kedudukan:</label>
          <div class="col-sm-2">
            <input type="text" class="form-control" id="" placeholder="Enter email" value="01-01-2014">
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="">Tempat Lahir:</label>
          <div class="col-sm-2">
            <input type="text" class="form-control" id="" placeholder="Enter email" value="Jember">
          </div>
          <label class="control-label col-sm-2" for="">Jenis Kelamin:</label>
          <div class="col-sm-2">
            <select>
              <option>Laki-laki</option>
              <option>Perempuan</option>
            </select>
          </div>
          <label class="control-label col-sm-2" for="">Gol Darah:</label>
          <div class="col-sm-2">
            <select>
              <option>A</option>
              <option>B</option>
              <option>AB</option>
              <option>O</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="">Agama:</label>
          <div class="col-sm-4">
            <select>
              <option>Islam</option>
              <option>Kristen</option>
              <option>Katolik</option>
              <option>Hindu</option>
              <option>Budha</option>
              <option>Konghucu</option>
            </select>
          </div>
          <label class="control-label col-sm-2" for="">Suku Bangsa:</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="" placeholder="Enter email" value="Jawa">
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="">Jenis Pegawai:</label>
          <div class="col-sm-6">
            <select name="reqJenisPegawaiId" id="reqJenisPegawaiId" class="form-control ">
              <option value="1">PNS Pusat yang bekerja pada Departemen/Lembaga</option>
              <option value="2">PNS Pusat DPB pada Instansi lain</option>
              <option value="3">PNS Pusat DPK pada Instansi lain</option>
              <option value="4">PNS Pusat DPB pada Pemerintah Propinsi</option>
              <option value="5">PNS Pusat DPK pada Pemerintah Propinsi</option>
              <option value="6">PNS Pusat DPB pada Pemerintah Kabupaten/Kota</option>
              <option value="7">PNS Pusat DPK pada Pemerintah Kabupaten/Kota</option>
              <option value="8">PNS Pusat DPB pada BUMN/Badan lain</option>
              <option value="9">PNS Pusat DPK pada BUMN/Badan lain</option>
              <option value="10">PNS Daerah Propinsi yang bekerja pada Propinsi</option>
              <option value="11">PNS Daerah Propinsi DPB pada Instansi lain</option>
              <option value="12">PNS Daerah Propinsi DPK pada Instansi lain</option>
              <option value="13">PNS Daerah Propinsi DPB pada BUMN/BUMD</option>
              <option value="14">PNS Daerah Propinsi DPK pada BUMN/BUMD</option>
              <option value="15" selected="">PNS Daerah Kab./Kota yang bekerja pada Kab./Kota</option>
              <option value="16">PNS Daerah Kab./Kota DPB pada Instansi lain</option>
              <option value="17">PNS Daerah Kab./Kota DPK pada Instansi lain</option>
              <option value="18">PNS Daerah Kab./Kota DPB pada BUMN/BUMD</option>
              <option value="19">PNS Daerah Kab./Kota DPK pada BUMN/BUMD</option>
              <option value="20">PPPK Daerah Kab./Kota yang bekerja pada Kab./Kota</option>
              <option value="21">PPPK Daerah Kab./Kota DPB pada Instansi lain</option>
              <option value="22">PPPK Daerah Kab./Kota DPK pada Instansi lain</option>
              <option value="23">PPPK Daerah Kab./Kota DPB pada BUMN/BUMD</option>
              <option value="24">PPPK Daerah Kab./Kota DPK pada BUMN/BUMD</option>
            </select>
          </div>
          
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="">Satuan Kerja:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="" placeholder="Enter email" value="Badan Kepegawaian dan Pengembangan Sumber Daya Manusia - Bidang Pengadaan, Pemberhentian dan Informasi Kepegawaian - Sub Bidang Data dan Informasi Kepegawaian">
          </div>
          
        </div>

        

        <!-- <div class="form-group">
          <label class="control-label col-sm-2" for="email">Email:</label>
          <div class="col-sm-10">
            <input type="email" class="form-control" id="email" placeholder="Enter email">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="pwd">Password:</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" id="pwd" placeholder="Enter password">
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <div class="checkbox">
              <label><input type="checkbox"> Remember me</label>
            </div>
          </div>
        </div> -->
        <!-- <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Submit</button>
          </div>
        </div> -->
      </form> 

      <div class="judul-panel">Dokumen Pribadi</div>
      <form class="form-horizontal" action="/action_page.php">
        
        <div class="form-group">
          <div class="form-group">
            <label class="control-label col-sm-2" for="">NIK:</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" id="reqNik" name="reqNik" placeholder="Enter NIK" value="<?=$reqNik?>">
            </div>

            <label class="control-label col-sm-2" for="">No. KK:</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" id="reqNoKk" name="reqNoKk" placeholder="Enter No. KK" value="<?=$reqNoKk?>">
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="">File:</label>
          <div class="col-sm-4">
            <input type="file" class="form-control">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="">Radio Button:</label>
          <div class="col-sm-4">
            <div class="form-check">
              <input type="radio" class="form-check-input" id="radio1" name="optradio" value="option1" checked> Option 1
              <label class="form-check-label" for="radio1"></label>
            </div>
            <div class="form-check">
              <input type="radio" class="form-check-input" id="radio2" name="optradio" value="option2"> Option 2
              <label class="form-check-label" for="radio2"></label>
            </div>
            <div class="form-check">
              <input type="radio" class="form-check-input" disabled> Option 3
              <label class="form-check-label"></label>
            </div> 
          </div>
          <label class="control-label col-sm-2" for="">Check Box:</label>
          <div class="col-sm-4">
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="radio1" name="optradio" value="option1" checked> Option 1
              <label class="form-check-label" for="radio1"></label>
            </div>
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="radio2" name="optradio" value="option2"> Option 2
              <label class="form-check-label" for="radio2"></label>
            </div>
            <div class="form-check">
              <input type="checkbox" class="form-check-input" disabled> Option 3
              <label class="form-check-label"></label>
            </div> 
          </div>
        </div>
        
        <div class="form-group">
          <label class="control-label col-sm-2" for=""></label>
          <div class="col-sm-4">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-default">Reset</button>
          </div>
        </div>

        
      </form>

      <!-- <div class="judul-panel">Contoh Data Lain</div>
      <form class="form-horizontal" action="/action_page.php">
        
        <div class="form-group">
          <label class="control-label col-sm-2" for="">Textarea:</label>
          <div class="col-sm-4">
            <textarea class="form-control" name="message" rows="4" cols="30">
              The cat was playing in the garden.
            </textarea>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="">File:</label>
          <div class="col-sm-4">
            <input type="file" class="form-control">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="">Radio Button:</label>
          <div class="col-sm-4">
            <div class="form-check">
              <input type="radio" class="form-check-input" id="radio1" name="optradio" value="option1" checked> Option 1
              <label class="form-check-label" for="radio1"></label>
            </div>
            <div class="form-check">
              <input type="radio" class="form-check-input" id="radio2" name="optradio" value="option2"> Option 2
              <label class="form-check-label" for="radio2"></label>
            </div>
            <div class="form-check">
              <input type="radio" class="form-check-input" disabled> Option 3
              <label class="form-check-label"></label>
            </div> 
          </div>
          <label class="control-label col-sm-2" for="">Check Box:</label>
          <div class="col-sm-4">
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="radio1" name="optradio" value="option1" checked> Option 1
              <label class="form-check-label" for="radio1"></label>
            </div>
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="radio2" name="optradio" value="option2"> Option 2
              <label class="form-check-label" for="radio2"></label>
            </div>
            <div class="form-check">
              <input type="checkbox" class="form-check-input" disabled> Option 3
              <label class="form-check-label"></label>
            </div> 
          </div>
        </div>
        
        <div class="form-group">
          <label class="control-label col-sm-2" for=""></label>
          <div class="col-sm-4">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-default">Reset</button>
          </div>
        </div>

        
      </form> -->

    </div>
    
  </div>
</div>