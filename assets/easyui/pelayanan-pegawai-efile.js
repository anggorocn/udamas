$(document).ready( function () {

  /*$("#klikbuttoniframe").click();
  vurl= "http://192.168.88.100/jombang/siapasn/uploads/8300/rcMxO0Jlrz.pdf?SK_JABATAN_01092017_198305022011011001.pdf";
  $('#infonewframe').attr('data', vurl);*/

  $('[id^="buttonframepdf"]').click(function(){
    infoid= $(this).attr('id');
    infoid= infoid.replace("buttonframepdf", "");
    buttonframepdf(infoid);
  });

  $('#iframedetil').on('hidden.bs.modal', function () {
    infoid= $("#labelglobalvpdf").val();
    labelvpdf= $("#labelvpdf"+infoid).val();
    $("#labelframepdf"+infoid).text(labelvpdf);
    $("#vnewframe").val("");
  })

  if(typeof vselectmaterial == "undefined")
  {
    vselectmaterial= "";
  }

  function isgambar(vext)
  {
    vreturn= "";
    if(vext == "jpg")
        {
          vreturn= "1";
        }

        return vreturn;
  }

  // validasi jquery batas file
  $("input[type='file']").on("change", function () {
    // console.log("asd"+this.files[0].size);
    if(this.files[0].size > 2000000) {
      mbox.alert("check file upload harus di bawah 2 MB", {open_speed: 0});
      $(this).val('');
    }

    // if (window.parent && window.parent.document)
    // {
    //   if (typeof window.parent.iframeLoaded === 'function')
    //   {
    //     parent.iframeLoaded();
    //   }
    // }
  });

  // set foto default
  if(typeof getarrlistpilihfilefield == "undefined"){}
  else
  {
    arrdefaultfoto= getarrlistpilihfilefield["foto"];
    if(Array.isArray(arrdefaultfoto) && arrdefaultfoto.length)
    {
      varrdefaultfoto= arrdefaultfoto.filter(item => item.selected === "selected");
      // console.log(varrdefaultfoto);

      if(Array.isArray(varrdefaultfoto) && varrdefaultfoto.length)
      {
        vurlblob= varrdefaultfoto[0]["vurlblob"];
        vurl= varrdefaultfoto[0]["vurl"];
        vurl= vurl.replace("../", "");
        vext= varrdefaultfoto[0]["ext"];
        if(isgambar(vext) == "1")
        {
          $("#infoimage").attr("src", vurl);
        }
      }
    }
  }

  function buttonframepdf(infoid) {
    $('[id^="buttonframepdf"]').hide();

    reqDokumenIndexId= $("#reqDokumenIndexId"+infoid+" option:selected").val();
    if(typeof getarrlistpilihfilefield == "undefined"){}
    else
    {
      getarrlistpilihfilepegawai= getarrlistpilihfilefield[infoid];
      // console.log(getarrlistpilihfilepegawai);return false;

      if(Array.isArray(getarrlistpilihfilepegawai) && getarrlistpilihfilepegawai.length)
      {
        varrlistpilihfilepegawai= getarrlistpilihfilepegawai.filter(item => item.index === reqDokumenIndexId);
        // console.log(varrlistpilihfilepegawai);return false;

        vurlblob= varrlistpilihfilepegawai[0]["vurlblob"];
        vurl= varrlistpilihfilepegawai[0]["vurl"];
        vurl= vurl.replace("../", "");
        vext= varrlistpilihfilepegawai[0]["ext"];

        $("#vnewframe").val(infoid);

        labelvpdf= $("#labelvpdf"+infoid).val();
        $("#labelframepdf"+infoid).text("Tutup " + labelvpdf);
        $("#labelglobalvpdf").val(infoid);
        $("#buttonframepdf"+infoid).show();

        $("#infonewimage, #infonewframe").hide();
        if(isgambar(vext) == "1")
        {
          $("#infonewimage").show();
          $("#infonewimage").attr("src", vurl);
          // console.log(varrlistpilihfilepegawai);
        }
        else
        {
          $("#infonewframe").show();
          var infonewframe= $('#infonewframe');
          vnewframe= $("#vnewframe").val();
          if(vnewframe == ""){}
          else
          {
            infourl= vlinkurlapi+vurl;
            if(vreplaceurlupload == "1")
            {
              infonewframe.attr('data', "");
              // infonewframe.attr('data', null);
              infonewframe.prop('data', "");
              // infonewframe.prop('data', null);
              $("#klikbuttoniframe").click();

              // infourl= infourl.replace(vsettingurlupload, "");
              var s_url= "api/file_content/content?reqUrl="+encodeURIComponent(infourl);
              // console.log(s_url);return false;
              $.ajax({'url': s_url,'success': function(dataajax){
                // dataajax= String(dataajax);
                // console.log(dataajax);
                infonewframe.attr('data', dataajax);
              }});
              // console.log("y");
            }
            else if(vreplaceurlupload == "2")
            {
              // console.log(vurl);
              // console.log(vsettingurlupload);
              // console.log(infourl);
              infourl= infourl.replace(vsettingurlupload, "");
              // console.log(infourl);
              infonewframe.attr('data', infourl);
              $("#klikbuttoniframe").click();
            }
            else if(vreplaceurlupload == "3")
            {
              infourl= infourl.replace(vsettingurlupload, "");
              infourl= vlinkurlapi+'/lib/pdfjs/web/viewer.html?file='+infourl;
              // console.log(infourl);

              infonewframe.attr("src", infourl);
              // infonewframe.contentWindow.location.reload();
              $("#klikbuttoniframe").click();
            }
            else
            {
              /*infonewframe.attr('data', "");
              infourl= "data:application/pdf;base64,"+vurlblob;*/
              // console.log(infourl);
              infonewframe.attr('data', infourl);
              $("#klikbuttoniframe").click();
            }

          }
        }
      }

    }

  }

  $('[id^="buttonframepdf"]').each(function(){
    vinfoid= $(this).attr('id');
    vinfoid= vinfoid.replace("buttonframepdf", "");

    setdokumenpilih(vinfoid, "");
  });
      
  $('[id^="reqDokumenPilih"]').change(function(){
    vinfoid= $(this).attr('id');
    vinfoid= vinfoid.replace("reqDokumenPilih", "");
    setdokumenpilih(vinfoid, "data");
  });

  $('[id^="reqDokumenIndexId"]').change(function(){
    vinfoid= $(this).attr('id');
    vinfoid= vinfoid.replace("reqDokumenIndexId", "");
    setinfonewframe(vinfoid, "data");
  });

  function setdokumenpilih(vinfoid, infomode)
  {
    reqDokumenPilih= $("#reqDokumenPilih"+vinfoid).val();

    if(infomode == ""){}
    else
    {
      $("#reqDokumenFileKualitasId"+vinfoid).val("");

      if(vselectmaterial == "1")
      {
        $("#reqDokumenFileKualitasId"+vinfoid).material_select();
      }
    }

    $("#buttonframepdf"+vinfoid+", #labeldokumenfileupload"+vinfoid+", #labeldokumendarifileupload"+vinfoid).hide();
    if(reqDokumenPilih == "1")
    {
      $("#reqDokumenFileId"+vinfoid).val("");
      $("#labeldokumenfileupload"+vinfoid).show();
    }
    else if(reqDokumenPilih == "2")
    {
      $("#labeldokumendarifileupload"+vinfoid).show();
      $("#buttonframepdf"+vinfoid).show();
      setinfonewframe(vinfoid, infomode);
    }
  }

  function setinfonewframe(vinfoid, infomode)
  {
    reqDokumenIndexId= $("#reqDokumenIndexId"+vinfoid).val();

    infoid= reqDokumenIndexId;
    // console.log(infoid+"-"+vinfoid);
    if(typeof getarrlistpilihfilefield == "undefined"){}
    else
    {
      getarrlistpilihfilepegawai= getarrlistpilihfilefield[vinfoid];
      // console.log(getarrlistpilihfilepegawai);

      if(Array.isArray(getarrlistpilihfilepegawai) && getarrlistpilihfilepegawai.length)
      {
        varrlistpilihfilepegawai= getarrlistpilihfilepegawai.filter(item => item.index === infoid);
        // console.log(varrlistpilihfilepegawai);

        if(Array.isArray(varrlistpilihfilepegawai) && varrlistpilihfilepegawai.length)
        {
          vurlblob= varrlistpilihfilepegawai[0]["vurlblob"];
          vurl= varrlistpilihfilepegawai[0]["vurl"];
          vurl= vurl.replace("../", "");
          vext= varrlistpilihfilepegawai[0]["ext"];
          reqDokumenFileId= varrlistpilihfilepegawai[0]["id"];
          reqDokumenFileKualitasId= varrlistpilihfilepegawai[0]["filekualitasid"];
          // reqDokumenFileRiwayatId= varrlistpilihfilepegawai[0]["inforiwayatid"];

          // console.log(reqDokumenFileId);
          if(vurl == ""){}
          else
          {
            // console.log(varrlistpilihfilepegawai);
            $("#reqDokumenFileId"+vinfoid).val(reqDokumenFileId);
            $("#reqDokumenPath"+vinfoid).val(vurl);
            $("#reqDokumenFileKualitasId"+vinfoid).val(reqDokumenFileKualitasId);
            // $("#reqDokumenFileRiwayatId"+vinfoid).val(reqDokumenFileRiwayatId);

            if(infomode == ""){}
            else
            {
              $("#infonewimage, #infonewframe").hide();
              if(isgambar(vext) == "1")
              {
                $("#infonewimage").show();
                $("#infonewimage").attr("src", vurl);
                // console.log(varrlistpilihfilepegawai);
              }
              else
              {
                $("#infonewframe").show();
                var infonewframe= $('#infonewframe');
                vnewframe= $("#vnewframe").val();
                if(vnewframe == ""){}
                else
                {
                  infourl= vlinkurlapi+vurl;
                  if(vreplaceurlupload == "1")
                  {
                    infonewframe.attr('data', "");
                    // infonewframe.attr('data', null);
                    infonewframe.prop('data', "");
                    // infonewframe.prop('data', null);
                    $("#klikbuttoniframe").click();

                    // infourl= infourl.replace(vsettingurlupload, "");
                    var s_url= "api/file_content/content?reqUrl="+encodeURIComponent(infourl);
                    // console.log(s_url);return false;
                    $.ajax({'url': s_url,'success': function(dataajax){
                      // dataajax= String(dataajax);
                      // console.log(dataajax);
                      infonewframe.attr('data', dataajax);
                    }});
                    // console.log("y");
                  }
                  else if(vreplaceurlupload == "2")
                  {
                    // console.log(vurl);
                    // console.log(vsettingurlupload);
                    // console.log(infourl);
                    infourl= infourl.replace(vsettingurlupload, "");
                    // console.log(infourl);
                    infonewframe.attr('data', infourl);
                    $("#klikbuttoniframe").click();
                  }
                  else if(vreplaceurlupload == "3")
                  {
                    infourl= infourl.replace(vsettingurlupload, "");
                    infourl= vlinkurlapi+'/lib/pdfjs/web/viewer.html?file='+infourl;
                    // console.log(infourl);

                    infonewframe.attr("src", infourl);
                    // infonewframe.contentWindow.location.reload();
                    $("#klikbuttoniframe").click();
                  }
                  else
                  {
                    /*infonewframe.attr('data', "");
                    infourl= "data:application/pdf;base64,"+vurlblob;*/
                    // console.log(infourl);
                    infonewframe.attr('data', infourl);
                    $("#klikbuttoniframe").click();
                  }

                }
              }

            }
          }

        }

      }
    }
  }

});

function copytoclipboard(element) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val($(element).text()).select();
  document.execCommand("copy");
  $temp.remove();
}