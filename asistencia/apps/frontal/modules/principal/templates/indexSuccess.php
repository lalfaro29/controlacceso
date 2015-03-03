
<?php if(!$sf_user->isAuthenticated()): ?>
<form name="inicial" method="POST">
	<table class="inicial" align="center" width="40%">
		<caption>Control de Acceso</caption>
		<tr>
			<td align=center>Cedula de Identidad:<input id="cedula" type="text" size="16" value="" name="cedula" autocomplete="off"></td>
		</tr>
		<tr>
			<td align=center><div id="reloj"><?php echo date('d-m-Y h:i:s a') ?></div></td>
		</tr>
		<tr>
			<td align=center>
				<input type="submit" id="registrar_usuario" value="Registrar">
			</td>
		</tr>
	<!--	<tr>
			<td align=center>
                    <a href="http://10.90.20.89/MFAccesoInicial/inicio/default.htm" >Acceso a HelpDesk (Solo para personal tecnico) </a>
			</td>
		</tr> -->
	</table>
</form>
<script type="text/javascript">
$(document).ready(function(){
     $("#cedula").focus();

      jClock = function(jDate, jHora, jMin, jSec,am_pm) {
          am_pm = (am_pm)?am_pm:'<?=date('a')?>';
           $("#reloj").html(jDate + ' ' + jHora + ':' + jMin + ':' + jSec + ' '+am_pm); 
      }
      var jDate = '<?=date('d-m-Y')?>';
      var jHora = '<?=date('h')?>';
      var jMin = '<?=date('i')?>';
      var jSec = '<?=date('s')?>';
      var am_pm = '<?=date('a')?>';
      jClock(jDate, jHora,jMin,jSec);
      var jClockInterval = setInterval(function(){
          jSec++;
          if (jSec >= 60) {
                    jMin++;
                if (jMin >= 60) {
                    jHora++;
                     if (jHora > 23) {
                         jHora = '00';
                     }else if (jHora < 10) { jHora = '0'+jHora; }
                    jMin = '00';
                    } else if (jMin < 10) { jMin = '0'+jMin; }
                         jSec = '00';
                    } else if (jSec < 10) { jSec = '0'+jSec; }
          jClock(jDate, jHora,jMin,jSec,am_pm);
      }
     , 1000);






	$("#registrar_usuario").click(function(evento){
		evento.preventDefault();
		$("#cedula").attr("disabled","disabled");
		$("#registrar_usuario").attr("disabled","disabled");
		$("#registrar_usuario").attr("class","boton_inactivo")
		if($("#cedula").val() && $("#cedula").val()!=""){
			$.ajax({
				url: '<?php echo url_for(@principal) ?>',
				data:"cedula="+$("#cedula").val(),
				dataType:"json",
				success: function( resultado ) {
					if(!resultado.valido){
						if(resultado.tipo_dato=="jornada_completa"){
							data = "tipo_mensaje=jornada_incompleta"
							data+="&ventana=confirmacion"
							TINY.box.show({
								url:'<?php echo url_for(@mensajes) ?>',
								post:data,
								openjs:function(){
									$("#mensaje_si").click(function(evento){
										evento.preventDefault();
										TINY.box.hide();
										$.ajax({
											url: '<?php echo url_for(@registrar_salida) ?>',
											data:"cedula="+$("#cedula").val(),
											dataType:"json",
											success: function( resultado ){
												if( resultado.tipo_dato=="adelantado" ){
													data = "tipo_mensaje=adelantado"
													data+="&ventana=registro"
													TINY.box.show({
														url:'<?php echo url_for(@mensajes) ?>',
														post:data,
														width: 350,
														openjs:function(){
															$("#mensaje_aceptar").click(function(evento){
																evento.preventDefault();
																TINY.box.hide();
																if($('#motivo').val() !=""){
																	$.ajax({
																		url: '<?php echo url_for(@registrar_adelanto) ?>',
																		data:"cedula="+$("#cedula").val()+"&motivo_id="+$('#motivo option:selected').val(),
																		dataType:"json",
																		success: function( resultado ){
																			$("#cedula").val("");
																			$("#cedula").removeAttr("disabled");
																			$("#registrar_usuario").removeAttr("disabled");
																			$("#registrar_usuario").removeAttr("class");
																			alert(resultado.mensaje)
																		}
																	});
																}else{
																	alert('debe indicar un motivo valido')
																}
															});
														}
													})
												}
											}
										});
									});
									$("#mensaje_no").click(function(){
										TINY.box.hide();
										$("#cedula").val("");
										$("#cedula").removeAttr("disabled");
										$("#registrar_usuario").removeAttr("disabled");
										$("#registrar_usuario").removeAttr("class");
									})
								}
							})
						}else if(resultado.tipo_dato=="retrasado"){
							data = "tipo_mensaje=retraso"
							data+="&ventana=registro"
							TINY.box.show({
								url:'<?php echo url_for(@mensajes) ?>',
								post:data,
								openjs:function(){
									$("#mensaje_aceptar").click(function(evento){
										evento.preventDefault();
										TINY.box.hide();
											$.ajax({
												url: '<?php echo url_for(@registrar_retraso) ?>',
												data:"cedula="+$("#cedula").val()+"&motivo_id="+$('#motivo option:selected').val(),
												dataType:"json",
												success: function( resultado ){
													$("#cedula").val("");
													$("#cedula").removeAttr("disabled");
													$("#registrar_usuario").removeAttr("disabled");
													$("#registrar_usuario").removeAttr("class");
													alert(resultado.mensaje)
												}
											});
									});
								}
							});
						}else{
							alert(resultado.mensaje)
							$("#cedula").val("");
							$("#cedula").removeAttr("disabled");
							$("#registrar_usuario").removeAttr("disabled");
							$("#registrar_usuario").removeAttr("class");
						}
					}else{
						alert(resultado.mensaje)
						$("#cedula").val("");
						$("#cedula").removeAttr("disabled");
						$("#registrar_usuario").removeAttr("disabled");
						$("#registrar_usuario").removeAttr("class");
					}
				}
			});
		}else{
			alert("debe ingresar un numero de cedula valido");;
			$("#cedula").removeAttr("disabled");
			$("#registrar_usuario").removeAttr("disabled");
			$("#registrar_usuario").removeAttr("class");
		}
	});
});
</script>
<?php endif; ?>
