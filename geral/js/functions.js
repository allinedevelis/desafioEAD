jQuery(document).ready(function($){
	if ($('.dateMask').length > 0){
		$(".dateMask").mask("00/00/0000", {placeholder: "__/__/____"});
	}
	if ($('.cepMask').length > 0){
		$('.cepMask').mask('00000-000');
	}
	if ($('.foneMask').length > 0){
		$('.foneMask').mask('0000-0000');
	}

	var cidadeID = ($("#cidadeID").length > 0) ? $("#cidadeID").val() : null;
	var estadoID = ($("#estadoID").length > 0) ? $("#estadoID").val() : null;
	if (estadoID > 0 && cidadeID > 0){
		getCidades(estadoID, cidadeID);
	}

	// Event delete 1 registro
	$(".btnDel").click(function(){
		var delID = $(this).attr('deleteid');
		if (delID.length > 0)
			deletar(delID);
	});

	$("#btnDelSelecionados").click(function(){
		var controller = $("#controller").val();
		var checkDel = $("input[name='del[]']:checked");
		var arrSelected = new Array();
		checkDel.each(function(){
			arrSelected.push($(this).val());
		});
		var stringSelected = arrSelected.join();
		window.location.href = URL_APP+'?controller='+controller+'&action=del&params='+stringSelected;

	});
	// Event onchange
	$(".defaultForm #estado").change(function(){
		var estadoID = $(this).val();
		getCidades(estadoID, cidadeID);
	})

	$("#frmLogin #btnEntrar").click(function(){
		var form = "frmLogin";
		var retorno = validaCampos(form);
		if (retorno == true)
			$("#"+form).submit();
	});

	$("#frmCliente #btnEnviar").click(function(){
		var form = "frmCliente";
		var retorno = validaCampos(form);
		if (retorno == true)
			$("#"+form).submit();
	});

	$("#frmContratacao #btnEnviar").click(function(){
		var form = "frmContratacao";
		var retorno = validaCampos(form);
		if (retorno == true)
			$("#"+form).submit();
	});

	$("#frmServico #btnEnviar").click(function(){
		var form = "frmServico";
		var retorno = validaCampos(form);
		if (retorno == true)
			$("#"+form).submit();
	});
});

function getCidades(estadoID, cidadeID){
	var controller = $("#controller").val();
	$.post( URL_APP+"?controller="+controller+"&action=listarCidades", 
		{ estadoID: estadoID, cidadeID: cidadeID })
  	.done(function( data ) {
    	$(".defaultForm #cidade").html(data);
  });
}

function deletar(ID){
	var controller = $("#controller").val();
	if (confirm("Deseja mesmo deletar esse registro?")){
		window.location.href = URL_APP+'?controller='+controller+'&action=del&params='+ID;
	}
}

function validaCampos(nomeDiv){
  /* SCRIPT VALIDACAO */
    var elem;
    var error = false;
    var msg = "Alguns campos estão incorretos!";
    jQuery("#"+nomeDiv+":visible [req='true']").each(function(){
      elem = jQuery(this);
      if (elem.val() == null || elem.val() == '' || elem.val() == 'null' || elem.val() == elem.attr('texto_default')){
        error = true;
        jQuery("#"+elem.attr('id')).css('border', '1px solid red');
      }else{
        if (elem.attr('id') == 'email'){
          if (js_validaremail(jQuery(this).val()) == false){
            error = true;
            msg += "\nDigite um e-mail válido!";
            jQuery("#"+elem.attr('id')).css('border', '1px solid red');
          }else{
            jQuery("#"+elem.attr('id')).css('border', 'none');
          }
        }else{
          jQuery("#"+elem.attr('id')).css('border', 'none');
        }
      }
    });

    if (error == true){
      alert(msg);
      return false;
    }else{
      return true;
    }
}