var $ = jQuery.noConflict();
$(document).ready(function() {
  $('.cep').mask('99999-999');
  function calculaCepAjax(){
    var cep = $("#cepajax").val() != '' ? $("#cepajax").val() : "0";
    var base_url = window.location.origin;
    $("#infoCep").hide();
    $(".error-cep").hide();
    $.ajax({
      url: base_url+"/busca_cep_php/ajax/ajax-address.php",
      method: 'POST',
      data: { 'cep': cep },
      beforeSend: function() {
        $('#loading').show();
      },
      success: function(data){
        // console.log(data);
        var address = JSON.parse(JSON.stringify(data))
        eval('var obj='+address);
        $('#loading').hide();
        if(typeof address.error === 'undefined' && (address === "{error: 'null'}" || address === "{error: 'errorCep'}")){
          var valueReturn = cep == "0" ? "Cep não foi informado!" : "CEP Informado: "+cep+" - É invalido!";
          $(".error-cep").html(valueReturn);
          $(".error-cep").show();
        }else if(typeof address.error === 'undefined' && address === "{error: 'errorServer'}"){
          var valueReturn = cep == "0" ? "Cep não foi informado!" : "Falha ao calcular cep, tente novamente";
          $(".error-cep").html(valueReturn);
          $(".error-cep").show();
        }else{
          $(".info-address-cep").html("CEP Informado: "+obj.cep);
          $(".info-address-endereco").html("Endereço: "+obj.logradouro);
          $(".info-address-bairro").html("Bairro: "+obj.bairro);
          $(".info-address-cidade").html("Cidade: "+obj.localidade);
          $(".info-address-estado").html("Estado: "+obj.uf);
          $("#infoCep").show();
        }
      }
    });
  }
  // Calcular o frete com a ação de click
  $("#seatchAddressByCep").on("click", function() {
    calculaCepAjax();
  });
  // Calcular o frete quando tirar o foco do input
  $("#cepajax").on("blur", function() {
    calculaCepAjax();
  });
});