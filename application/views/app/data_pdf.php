<?
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");
?>

<!-- Twitter Bootstrap -->
<!-- <link rel="stylesheet" href="assets/bootstrap-pdf-viewer/lib/twitter-bootstrap/css/bootstrap.css"> -->

<!-- Font Awesome -->
<link rel="stylesheet" href="assets/bootstrap-pdf-viewer/lib/font-awesome/css/font-awesome.css">

<!-- Bootstrap PDF Viewer -->
<link rel="stylesheet" href="assets/bootstrap-pdf-viewer/css/bootstrap-pdf-viewer.css">
<link rel="stylesheet" href="assets/bootstrap-pdf-viewer/css/bootstrap-pdf-form-builder.css">

<div class="row">
  <div class="col-md-12">
    <div class="judul-halaman">
      <h1>E-File</h1>
      <h6>
        <span class="ikon"><i class="fa fa-arrow-right" aria-hidden="true"></i></span>&nbsp;&nbsp;
        <span>Halaman elektronik file</span>
      </h6>
    </div>

    <div class="area-panel">
      <div class="judul-panel">Riwayat E-File</div>

      <div class="inner inner-pdf">
        <!-- <object data="http://192.168.88.100/jombang/siapasn/uploads/8300/rcMxO0Jlrz.pdf?SK_JABATAN_01092017_198305022011011001.pdf" type="application/pdf" width="100%" height="800px"> 
          <p>It appears you don't have a PDF plugin for this browser.
           No biggie... you can <a href="resume.pdf">click here to
          download the PDF file.</a></p>  
        </object> -->

        <!-- <iframe src="http://192.168.88.100/jombang/siapasn/uploads/8300/rcMxO0Jlrz.pdf?SK_JABATAN_01092017_198305022011011001.pdf" ></iframe>  -->

        <!-- Bootstrap PDF Viewer -->
        <!-- <div id="viewer" class="pdf-viewer" data-url="http://192.168.88.100/jombang/siapasn/uploads/8300/rcMxO0Jlrz.pdf?SK_JABATAN_01092017_198305022011011001.pdf"></div> -->

        <!-- <div id="viewer" class="pdf-viewer" data-url="http://192.168.88.100/jombang/pegawai/assets/bootstrap-pdf-viewer/sample.pdf"></div> -->
        <div id="viewer" class="pdf-viewer" data-url="http://192.168.88.100/jombang/siapasn/uploads/8300/rcMxO0Jlrz.pdf?SK_JABATAN_01092017_198305022011011001.pdf"></div>

        <!-- jQuery -->
        <!-- <script src="assets/bootstrap-pdf-viewer/lib/jquery-1.9.1.js"></script> -->

        <!-- Twitter Bootstrap -->
        <!-- <script src="assets/bootstrap-pdf-viewer/lib/twitter-bootstrap/js/bootstrap.js"></script> -->

        <!-- Bootstrap PDF Viewer -->
        <script src="assets/bootstrap-pdf-viewer/lib/pdf.js"></script>
        <script src="assets/bootstrap-pdf-viewer/js/bootstrap-pdf-viewer.js"></script>

        <script src="assets/bootstrap-pdf-viewer/js/bootstrap-pdf-form-builder.js"></script>
        <script src="assets/bootstrap-pdf-viewer/js/bootstrap-pdf-form-common.js"></script>

        <script>
          var viewer, formBuilder;

          $(function() {
            viewer = new PDFViewer($('#viewer'));
            formBuilder = new PDFFormBuilder(viewer, {
              hideOpenFormButton: true, // Default: false
              hideSaveFormButton: false  // Default: false
            });

            formBuilder.setToolbarAction('#save-form', function() {
              console.log(this.serializeFormLayers());
            });
          });
        </script>

        <!-- <script>
          var viewer;

          $(function() {
            viewer = new PDFViewer($('#viewer'));
          });
        </script> -->

      </div>

    </div>
    
  </div>
</div>