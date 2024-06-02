$(document).ready(function(){
  if($(".alert").length > 0){
    $(".alert").fadeTo(2000, 500).slideUp(500, function(){
      $(".alert").slideUp(500);
    });
  }
  if($(".datatable").length > 0){
    $(".datatable").DataTable();
  }
  if($(".datepicker").length > 0){
    $(".datepicker").datepicker({
      format: 'yyyy-mm-dd'
    });
  }
  if($(".select2").length > 0){
    $(".select2").select2({
      theme: "bootstrap"
    });
  }
  $(".nama-supplier-select").change(function(){
    if($(this).val() != '') {
      $(".alamat-supplier-wrapper textarea").val(data_supplier[$(this).val()]);
      $(".alamat-supplier-wrapper").show();
    }else{
      $(".alamat-supplier-wrapper").hide();
    }
  });
  if($(".wrap-element-bahan-produk").length > 0){
    tambah_list_bahan_pada_produk($(".wrap-element-bahan-produk").find("select"));
  }
  $(".nama-bahan-select").on('change', function(){
    var wrap_el = $(this).parents(".wrap-element-bahan");
    if($(this).val() == 'other'){
      wrap_el.find(".nama-bahan-input").parents(".form-group").show();
      wrap_el.find(".nama-bahan-input").prop("disabled", false);
      wrap_el.find("input[name='satuan[]']").val('');
      wrap_el.find("input[name='satuan[]']").prop('readonly', false);
    }else{
      wrap_el.find(".nama-bahan-input").parents(".form-group").hide();
      wrap_el.find(".nama-bahan-input").prop("disabled", true);
      wrap_el.find("input[name='satuan[]']").val(data_satuan_bahan[$(this).val()]);
      wrap_el.find("input[name='satuan[]']").prop('readonly', true);
    }
  });
  $(".nama-produk-select").on('change', function(){
    var wrap_el = $(this).parents(".wrap-element-produk");
    wrap_el.find("input[name='harga_jual[]']").val(data_harga_produk[$(this).val()]);
  });
  $(".js-jumlah-produk").keyup(function(e){
    var harga_temp   = HapusTitik($("input[name=harga_jual]").val());
    var harga        = parseInt(harga_temp);
    var jumlah       = parseInt($(".js-jumlah-produk").val());
    var total_hrg_int= harga * jumlah;
    var total_hrg    = TambahTitik(total_hrg_int);
    if(!isNaN(total_hrg)){
      $("input[name=total_harga]").val(total_hrg);
    }
  });
  $(".js-jumlah-produk2").keyup(function(e){
    var wrap_el = $(this).parents(".wrap-element-produk");
    var harga_temp   = HapusTitik(wrap_el.find("input[name='harga_jual[]']").val());
    var harga        = parseInt(harga_temp);
    var jumlah       = parseInt(wrap_el.find(".js-jumlah-produk2").val());
    var total_hrg_int= harga * jumlah;
    var total_hrg    = TambahTitik(total_hrg_int);
    if(!isNaN(total_hrg)){
      wrap_el.find("input[name='total_harga[]']").val(total_hrg);
    }
  });
  $("input[name=sesuai_alamat_pendaftaran]").change(function(){
    if($(this).is(":checked")){
      $(this).parents(".form-group").find("textarea").prop('readonly', true);
      $(this).parents(".form-group").find("textarea").prop('disabled', true);
    }else{
      $(this).parents(".form-group").find("textarea").prop('readonly', false);
      $(this).parents(".form-group").find("textarea").prop('disabled', false);
    }
  });
  $(".btn-form-clone").click(function(){
    $(".form-clone:last").clone().appendTo(".wrap-form-clone");
  });
  $("button[type=cancel]").click(function(e){
    e.preventDefault();
    window.history.back();
  });
  $(".add-bahan-produk").click(function(e){
    e.preventDefault();
    var el_html_add =
      '<div class="form-row" style="margin-bottom:15px">'
        +'<div class="col-3">'
          +'<select class="form-control select2 list-bahan" name="id_bahan[]">'
            +'<option selected="" disabled="" value="">Bahan</option>'
          +'</select>'
        +'</div>'
        +'<div class="col-2">'
          +'<input type="number" step="any" class="form-control" placeholder="Jumlah" name="jumlah_bahan[]" required="">'
        +'</div>'
        +'<div class="col-1">'
      +'</div>';
    $(".wrap-element-bahan-produk").prepend(el_html_add);
    tambah_list_bahan_pada_produk($(".wrap-element-bahan-produk select:first"));
    $(".wrap-element-bahan-produk select:first").select2({
      theme: 'bootstrap'
    });
  });
});
function FormatCurrency(objNum){
   var num = objNum.value
   var ent, dec;
   if (num != '' && num != objNum.oldvalue){
     num = HapusTitik(num);
     if (isNaN(num)){
       objNum.value = (objNum.oldvalue)?objNum.oldvalue:'';
     } else {
       var ev = (navigator.appName.indexOf('Netscape') != -1)?Event:event;
       if (ev.keyCode == 190 || !isNaN(num.split('.')[1])){
         alert(num.split('.')[1]);
         objNum.value = TambahTitik(num.split('.')[0])+'.'+num.split('.')[1];
       }
       else{
         objNum.value = TambahTitik(num.split('.')[0]);
       }
       objNum.oldvalue = objNum.value;
     }
   }
}
function HapusTitik(num){
   return (num.replace(/\./g, ''));
}

function TambahTitik(num){
   numArr=new String(num).split('').reverse();
   for (i=3;i<numArr.length;i+=3)
   {
     numArr[i]+='.';
   }
   return numArr.reverse().join('');
}
function tambah_list_bahan_pada_produk(element){
  console.log(list_bahan_json);
  $.each(list_bahan_json, function(key, value){
    element.append("<option value='"+key+"'>"+value+"</option>");
    console.log(value)
  });
  element.select2({
    theme: "bootstrap"
  });
}
