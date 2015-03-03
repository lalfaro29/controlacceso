
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
	<head>
		<title>Control de Acceso - Ministerio del poder popular para la planificación y finanzas</title>
		<link rel="shortcut icon" href="/web/images/logoCDC.ico" />  
                
                <?php if(in_array($_SERVER['REMOTE_ADDR'], array('10.11.1.11'))): ?>
                    <script type="text/javascript">
                        alert("para ingresar debe colocar la excepcion controlacceso.mpf.gob.ve en su navegador")
                        window.location="<?php echo url_for(@principal) ?>"
                    </script>
                <?php endif; ?>
                
                <?php $ip = $_SERVER['REMOTE_ADDR'];
                $arregloIp = explode(".",$ip);
                
                //if($arregloIp[2] == 20){
                    //if (!in_array($ip, array('10.90.20.24','10.90.20.199','10.90.20.175','10.90.20.112','10.90.20.132'))){?>
<!--                        <script type="text/javascript">
                            alert("ingrese su entrada/salida en la máquina que está ubicada en la entrada")
                            window.location="<?php //echo url_for(@principal) ?>"
                        </script>-->
                <?php //}
                //}?>
                
                <?php if(!$sf_user->isAuthenticated() && $sf_request->getPathInfo() !="/" ): ?>
                    <script type="text/javascript">
                        alert("debe iniciar una sesion valida para continuar")
                        window.location="<?php echo url_for(@principal) ?>"
                    </script>
                <?php endif; ?>
                
		<?php include_javascripts() ?>
		<?php include_stylesheets() ?>
		<?php  use_helper('jQuery'); ?>
	</head>
	<body>
		<div class="contenedor">
			<div class="cabecera">
				<?php  echo image_tag('logo'); ?>
			</div>
			<div class="contenido">
				<div>
					<?php include_partial('principal/menu') ?>
				</div>
				<?php echo $sf_content ?>
			</div>
		</div>
	</body>
</html>
<script type="text/javascript">
    function inicio_session(){
	TINY.box.show({
            url:'<?php echo url_for(@inicio_sesion) ?>',
            openjs:function(){
                $("#cancelar").click(function(){
                    TINY.box.hide();
                })
                $("#inicio_sesion").click(function(evento){
                    evento.preventDefault();
                    if($("#usuario").val() && $("#usuario").val()!=""){
                        TINY.box.hide();
                        $.ajax({
                            url: '<?php echo url_for(@validar_sesion) ?>',
                            data:"usuario="+$("#usuario").val()+"&clave="+$("#clave").val(),
                            dataType:"json",
                            success: function(resultado) {
                                if(resultado.valido == false){
                                    alert(resultado.mensaje);
                                }
                                window.location="<?php echo url_for(@principal) ?>"
                            }
                        });
                    }else{
                        alert("debe ingresar un usuario valido");
                    }
                });
            }
	})
    }

function cerrar_session(){
	$.ajax({
		url: '<?php echo url_for(@cerrar_sesion) ?>',
		dataType:"json",
		success: function( resultado ) {
			if(resultado.valido == false){
				alert(resultado.mensaje);
			}
			window.location="<?php echo url_for(@principal) ?>"
		}
	});
}
                
function abrir(pagina){
	switch(pagina){
		case "tipo de proyecto":
			TINY.box.show({
				url:'<?php echo url_for(@proyecto_new) ?>',
				 height: 265,
				 width: 510,
				openjs:function(){
						listado_proyecto = $('#listado_proyecto').dataTable( {
                                                                        "aoColumnDefs": [{ "bSortable": false, "aTargets": [ 0,1 ] } ],
									"bProcessing": true,
									"bServerSide": true,
									"sAjaxSource": "<?php echo url_for('@proyecto_lista') ; ?>",
									//"sPaginationType": "full_numbers",
									"bJQueryUI": true,
                                                                        "iDisplayLength":3,
                                                                        "bLengthChange": false,
									//"bFilter": true,
									"aaSorting": [[3, 'asc']],
									"fnServerData": function ( sSource, aoData, fnCallback ) {
										//aoData.push( { "name": "buscar", "value": $("#proyecto_busqueda").val() } );
										$.ajax( {
											"dataType": 'json', 
											"type": "POST", 
											"url": sSource, 
											"data": aoData, 
											"success": fnCallback
										} );
									}
								} );
					$("#proyecto_salir").click(function(){
						TINY.box.hide();
					})
					$("#proyecto_guardar").click(function(){	
						$.ajax({
							url: '<?php echo url_for(@proyecto_crear) ?>',
							data:$("#proyecto_form").serialize(),
							dataType:"json",
							"type": "POST",
							success: function( resultado ) {
                                                            alert(resultado)
                                                            limpiar_proyecto()
                                                            listado_proyecto.fnDraw();
							}
						});
					})
				}
			})
		break;
		case "tipo de empleado":
			TINY.box.show({
				url:'<?php echo url_for(@tipo_empleado_new) ?>',
				 height: 265,
				 width: 415,
				openjs:function(){
						tipo_empleado = $('#listado_tipo_empleado').dataTable( {
                                                                        "aoColumnDefs": [{ "bSortable": false, "aTargets": [ 0,1 ] } ],
									"bProcessing": true,
									"bServerSide": true,
									"sAjaxSource": "<?php echo url_for('@tipo_empleado_lista') ; ?>",
									//"sPaginationType": "full_numbers",
									"bJQueryUI": true,
                                                                        "iDisplayLength":3,
                                                                        "bLengthChange": false,
									"bFilter": false,
									"aaSorting": [[3, 'asc']],
									"fnServerData": function ( sSource, aoData, fnCallback ) {
										$.ajax( {
											"dataType": 'json', 
											"type": "POST", 
											"url": sSource, 
											"data": aoData, 
											"success": fnCallback
										} );
									}
								} );
					$("#tipo_empleado_salir").click(function(){
						TINY.box.hide();
					})
					$("#tipo_empleado_guardar").click(function(){
						$.ajax({
							url: '<?php echo url_for(@tipo_empleado_crear) ?>',
							data:$("#tipo_empleado_form").serialize(),
							dataType:"json",
							success: function( resultado ) {
                                                                alert(resultado);
                                                                limpiar_empleado()
                                                                tipo_empleado.fnDraw();
							}
						});
					})
				}
			})
		break;
		case "cargo":
			TINY.box.show({
				url:'<?php echo url_for(@cargo_new) ?>',
				 height: 265,
				 width: 415,
				openjs:function(){
						lista_cargos = $('#listado_cargo').dataTable( {
                                                                        "aoColumnDefs": [{ "bSortable": false, "aTargets": [ 0,1 ] } ],
									"bProcessing": true,
									"bServerSide": true,
									"sAjaxSource": "<?php echo url_for('@cargo_lista') ; ?>",
									"bJQueryUI": true,
                                                                        "iDisplayLength":3,
                                                                        "bLengthChange": false,
									"bFilter": false,
									"aaSorting": [[3, 'asc']],
									"fnServerData": function ( sSource, aoData, fnCallback ) {
										$.ajax( {
											"dataType": 'json', 
											"type": "POST", 
											"url": sSource, 
											"data": aoData, 
											"success": fnCallback
										} );
									}
								} );
					$("#cargo_salir").click(function(){
						TINY.box.hide();
					})
					$("#cargo_guardar").click(function(){
						$.ajax({
							url: '<?php echo url_for(@cargo_crear) ?>',
							data:$("#cargo_form").serialize(),
							dataType:"json",
							success: function( resultado ) {
                                                                alert(resultado);
                                                                limpiar_cargo()
                                                                lista_cargos.fnDraw();
							}
						});
					})
				}
			})
		break;
		case "departamento":
			TINY.box.show({
				url:'<?php echo url_for(@departamento_new) ?>',
				 height: 265,
				 width: 415,
				openjs:function(){
						lista_departamentos = $('#listado_departamento').dataTable( {
                                                                        "aoColumnDefs": [{ "bSortable": false, "aTargets": [ 0,1 ] } ],
									"bProcessing": true,
									"bServerSide": true,
									"sAjaxSource": "<?php echo url_for('@departamento_lista') ; ?>",
									"bJQueryUI": true,
                                                                        "iDisplayLength":3,
                                                                        "bLengthChange": false,
									"bFilter": false,
									"aaSorting": [[3, 'asc']],
									"fnServerData": function ( sSource, aoData, fnCallback ) {
										$.ajax( {
											"dataType": 'json', 
											"type": "POST", 
											"url": sSource, 
											"data": aoData, 
											"success": fnCallback
										} );
									}
								} );
					$("#departamento_salir").click(function(){
						TINY.box.hide();
					})
					$("#departamento_guardar").click(function(){
						$.ajax({
							url: '<?php echo url_for(@departamento_crear) ?>',
							data:$("#departamento_form").serialize(),
							dataType:"json",
							success: function( resultado ) {
                                                                alert(resultado);
                                                                limpiar_departamento()
                                                                lista_departamentos.fnDraw();
							}
						});
					})
				}
			})
		break;
		case "sede":
			TINY.box.show({
				url:'<?php echo url_for(@sede_new) ?>',
				 height: 265,
				 width: 415,
				openjs:function(){
						lista_sedes = $('#listado_sede').dataTable( {
                                                                        "aoColumnDefs": [{ "bSortable": false, "aTargets": [ 0,1 ] } ],
									"bProcessing": true,
									"bServerSide": true,
									"sAjaxSource": "<?php echo url_for('@sede_lista') ; ?>",
									"bJQueryUI": true,
                                                                        "iDisplayLength":3,
                                                                        "bLengthChange": false,
									"bFilter": false,
									"aaSorting": [[3, 'asc']],
									"fnServerData": function ( sSource, aoData, fnCallback ) {
										$.ajax( {
											"dataType": 'json', 
											"type": "POST", 
											"url": sSource, 
											"data": aoData, 
											"success": fnCallback
										} );
									}
								} );
					$("#sede_salir").click(function(){
                                            TINY.box.hide();
					})
					$("#sede_guardar").click(function(){
                                            $.ajax({
                                                url: '<?php echo url_for(@sede_crear) ?>',
                                                data:$("#sede_form").serialize(),
                                                dataType:"json",
                                                success: function( resultado ) {
                                                    alert(resultado);
                                                    limpiar_sede()
                                                    lista_sedes.fnDraw();
                                                }
                                            });
					})
				}
			})
		break;
                case "nomina":
                    TINY.box.show({
                        url:'<?php echo url_for(@usuario_confirmar_nomina) ?>',
                        height: 50,
                        width: 100,
                        openjs:function(){
                            $.ajax({
                                url: '<?php echo url_for(@usuario_actualizar) ?>',
                                dataType:"json",
                                success: function(resultado){
                                    alert(resultado.mensaje);
                                    window.location = window.location;
                                }
                            });
                        }
                    })
                    
		break;
		case "empleado":
                    window.location="<?php echo url_for(@usuario) ?>"
		break;
		case "usuario":
                    window.location="<?php echo url_for(@usuario_usuario) ?>"
		break;
		case "configuracion principal":
                    window.location="<?php echo url_for(@configuracion_new) ?>"
		break;
		case "dias feriados":
                    TINY.box.show({
                            url:'<?php echo url_for(@feriado_new) ?>',
                            height: 430,
                            width: 800,
                            openjs:function(){
                                    listado_feriados = $('#listado_feriados').dataTable( {
                                                            "bProcessing": true,
                                                            "bServerSide": true,
                                                            "sAjaxSource": "<?php echo url_for('@feriado_lista') ; ?>",
                                                            //"sPaginationType": "full_numbers",
                                                            "bJQueryUI": true,
                                                            "iDisplayLength":3,
                                                            "bLengthChange": false,
                                                            "bFilter": true,
                                                            "aaSorting": [[1, 'asc']],
                                                            "fnServerData": function ( sSource, aoData, fnCallback ) {
                                                                    //aoData.push( { "name": "buscar", "value": $("#proyecto_busqueda").val() } );
                                                                    $.ajax( {
                                                                            "dataType": 'json', 
                                                                            "type": "POST", 
                                                                            "url": sSource, 
                                                                            "data": aoData, 
                                                                            "success": fnCallback
                                                                    } );
                                                            }
                                                    } );
                              //  $('#feriado_form #feriado_feriadohoradesde').ptTimeSelect();
                              //  $('#feriado_form #feriado_feriadohorahasta').ptTimeSelect(); 
                                $("#feriados_un_dia").change(function(){
                                    if($("#feriados_un_dia option:selected").text() == "Varios Dias" || !$("#feriados_un_dia option:selected").val() ){
                                        $("#feriados_feriadofechhasta").removeAttr("readOnly")
                                        $("#feriados_feriadofechhasta").val("");
                                    }else if($("#feriados_un_dia option:selected").text() == "Un Dia" || $("#feriados_un_dia option:selected").val() ){
                                        $("#feriados_feriadofechhasta").attr("readOnly","readOnly");
                                        $("#feriados_feriadofechhasta").val("");
                                    }
                                })

                                $("#guardar_feriado").click(function(){
                                        if($("#feriados_feriado").val() =="" ){
                                            alert("debe indicar el nombre del feriado")
                                        }else if($("#feriados_feriadohoradesde").val() == ""){
                                            alert("debe indicar la hora de entrada del dia feriado")
                                        }else if($("#feriados_feriadohorahasta").val() == ""){
                                            alert("debe indicar la hora de salida del dia feriado")
                                        }else if($("#feriados_feriadofechdesde").val() == ""){
                                            alert("debe indicar la fecha que corresponde al feriado")
                                        }else if($("#feriados_un_dia option:selected").text()== "Varios Dias" && $("#feriados_feriadofechhasta").val() == ""){
                                            alert("el rango del feriado no es valido")
                                        }else if($("#feriados_porcentajeferiado").val() == ""){
                                            alert("debe indicar el porcentaje diurno del feriado")
                                        }else if($("#feriados_porcentajenocturno").val() == ""){
                                            alert("debe indicar el porcentaje nocturno del feriado")
                                        }else{
                                            $.ajax({
                                                    url: '<?php echo url_for(@feriado_guardar) ?>',
                                                    data:$("#feriado_form").serialize(),
                                                    dataType:"json",
                                                    type: "GET",
                                                    success: function( resultado ) {
                                                           if(resultado.valido){
                                                               limpiar_feriado()
                                                           }
							     listado_feriados.fnDraw();
                                                            alert(resultado.mensaje);
                                                    }
                                            });
                                        }
                                });
                                $("#cancelar_feriado").click(function(){
                                    TINY.box.hide();
                                })
                                $("#limpiar_feriado").click(function(){
                                    limpiar_feriado()
                                })
                            }
                    });
		break;
		case "cambiar clave":
                    TINY.box.show({
                            url:'<?php echo url_for(@usuario_confirmar_clave) ?>',
                            height: 140,
                            width: 390,
                            openjs:function(){
                                $("#guardar_confirmacion").click(function(evento){
                                        evento.preventDefault();
                                        clave= $("#clave").val();
                                        confirmacion= $("#confirmacion").val();
                                        if(clave =="" ){
                                            alert("debe seleccionar una clave valida")
                                        }else if(clave != confirmacion){
                                            alert("la confirmacion no es valida")
                                        }else{
                                            $.ajax({
                                                    url: '<?php echo url_for(@usuario_cambiar_clave) ?>',
                                                    data:"clave="+$("#clave").val(),
                                                    dataType:"json",
                                                    success: function( resultado ) {
                                                            TINY.box.hide();
                                                            alert(resultado);
                                                    }
                                            });
                                        }
                                });
                                $("#cancelar").click(function(){
                                    TINY.box.hide();
                                })
                            }

                    });
		break;
		case "motivo nuevo":
                    TINY.box.show({
                            url:'<?php echo url_for(@motivo_new) ?>',
                            height: 300,
                            width: 500,
                            openjs:function(){
                                listado_motivo = $('#listado_motivo').dataTable( {
                                                    "bProcessing": true,
                                                    "bServerSide": true,
                                                    "sAjaxSource": "<?php echo url_for('@motivo_lista') ; ?>",
                                                    //"sPaginationType": "full_numbers",
                                                    "bJQueryUI": true,
                                                    "iDisplayLength":3,
                                                    "bLengthChange": false,
                                                    "bFilter": true,
                                                    "aaSorting": [[0, 'asc']],
                                                    "fnServerData": function ( sSource, aoData, fnCallback ) {
                                                            $.ajax( {
                                                                    "dataType": 'json', 
                                                                    "type": "POST", 
                                                                    "url": sSource, 
                                                                    "data": aoData, 
                                                                    "success": fnCallback
                                                            } );
                                                    }
                                            } );
                                $("#eliminar_motivo").click(function(){
                                    if(confirm("¿realmente desea eliminar el motivo?")){
                                        $.ajax({
                                                url: '<?php echo url_for(@motivo_guardar) ?>',
                                                data:$("#motivo_form").serialize()+"&eliminar=true",
                                                dataType:"json",
                                                success: function( resultado ) {
                                                        limpiar_motivo()
                                                        alert(resultado);
                                                }
                                        });
                                    }
                                })
                                $("#guardar_motivo").click(function(evento){
                                        evento.preventDefault();
                                        $.ajax({
                                                url: '<?php echo url_for(@motivo_guardar) ?>',
                                                data:$("#motivo_form").serialize(),
                                                dataType:"json",
                                                success: function( resultado ) {
                                                        limpiar_motivo()
                                                        alert(resultado);
                                                }
                                        });
                                });
                                $("#cancelar_motivo").click(function(){
                                    limpiar_motivo()
                                })
                                $("#salir_motivo").click(function(){
                                    TINY.box.hide();
                                })
                            }

                    });
		break;
		case "supervisor":
                    window.location="<?php echo url_for(@coordinador) ?>"
		break;
		case "registro movimiento":
                    window.location="<?php echo url_for(@movimiento_registro_manual) ?>"
		break;
		case "reporte general":
                    window.location="<?php echo url_for("@movimiento_reporte?reporte=general") ?>"
		break;
		case "reporte especifico":
                    window.location="<?php echo url_for("@movimiento_reporte?reporte=especifico") ?>"
		break;
		case "reporte horas extras":
                    <?php if($sf_user->isAuthenticated()): ?>
                    window.location="<?php echo url_for("@movimiento_reporte?reporte=horas_extras&id=".$sf_user->getDatosBasicos()->getUsuarioSistema()->getFirst()->getUsuario()->getIdusuario()) ?>"
                    <?php endif; ?>
                break;
                case "reporte permisos":
                    window.location="<?php echo url_for("@movimiento_reporte?reporte=permisos") ?>"
		break;
		case "asignar turno":
                    window.location="<?php echo url_for("@movimiento_asignar_turno") ?>"
		break;
		case "permiso asignar":
                    window.location="<?php echo url_for("@permiso_asignar") ?>"
		break;
	}
}

                    
                        function limpiar_feriado(){
                            $("#feriados_feriado").val("");
                            $("#feriados_feriadohoradesde").val("");
                            $("#feriados_feriadohorahasta").val("");
                            $("#feriados_feriadofechdesde").val("");
                            $("#feriados_feriadofechhasta").val("");
                            $("#feriados_porcentajeferiado").val("");
                            $("#feriados_porcentajenocturno").val("");
                            $("#feriados_idferiado").val("");
                            $('#feriados_un_dia option[value="1"]').attr('selected', 'selected');
                            $("#feriados_tomar_anio").attr('checked',true);
                            $("#feriados_feriadofechhasta").attr("readOnly","readOnly");
                            $("#feriados_feriadofechhasta").val("");
                            $( "#eliminar_feriado" ).addClass("boton_inactivo")
                            $( "#eliminar_feriado" ).attr("disabled","disabled");
                        }

                        function feriado_seleccionar(idferiado,feriado,feriadofechdesde,feriadofechhasta,
                                feriadohoradesde,feriadohorahasta,porcentajeferiado,porcentajenocturno,
                                unDia,tomarAnio){
                            $("#feriados_feriado").val(feriado);
                            $("#feriados_feriadohoradesde").val(feriadohoradesde);
                            $("#feriados_feriadohorahasta").val(feriadohorahasta);
                            $("#feriados_feriadofechdesde").val(feriadofechdesde);
                            $("#feriados_feriadofechhasta").val(feriadofechhasta);
                            $("#feriados_porcentajeferiado").val(porcentajeferiado);
                            $("#feriados_porcentajenocturno").val(porcentajenocturno);
                            $("#feriados_idferiado").val(idferiado);
                            $('#feriados_un_dia option[value="'+((unDia)?'1':'0')+'"]').attr('selected', 'selected');
                            if(tomarAnio){
                                $("#feriados_tomar_anio").attr('checked',"checked");
                            }else{
                                $("#feriados_tomar_anio").removeAttr('checked');
                            }
                            if(unDia){
                                $("#feriados_feriadofechhasta").attr("readOnly","readOnly");
                                $("#feriados_feriadofechhasta").val("");
                            }else{
                                $("#feriados_feriadofechhasta").removeAttr("readOnly");
                            }
                            $( "#eliminar_feriado" ).removeClass("boton_inactivo")
                            $( "#eliminar_feriado" ).removeAttr("disabled")
                        }
                        function motivo_seleccionar(id, motivo){
                            $("#motivos_idmotivo").val(id)
                            $("#motivos_motivo").val(motivo)
                            $( "#eliminar_motivo" ).removeClass("boton_inactivo")
                            $( "#eliminar_motivo" ).removeAttr("disabled")
                        }
                        function limpiar_motivo(){
                            $("#motivos_idmotivo").val("")
                            $("#motivos_motivo").val("")
                            $( "#eliminar_motivo" ).addClass("boton_inactivo")
                            $( "#eliminar_motivo" ).attr("disabled")
                            if(listado_motivo){
                                listado_motivo.fnDraw();
                            }
                        }
                        
                        
                        function editar_proyecto(idproyecto,proyecto){
                            $("#proyectos_idproyecto").val(idproyecto)
                            $("#proyectos_proyecto").val(proyecto)
                        }
                        function eliminar_proyecto(proyecto){
                            if(confirm("¿ seguro que desea eliminar el proyecto ? ")){	
                                $.ajax({
                                        url: '<?php echo url_for(@proyecto_eliminar) ?>',
                                        data:"proyecto="+proyecto,
                                        dataType:"json",
                                        success: function( resultado ) {
                                                alert(resultado);
                                                limpiar_proyecto()
                                                listado_proyecto.fnDraw();
                                        }
                                });
                            }
                        }
                        function limpiar_proyecto(){
                                $("#proyectos_idproyecto").val("")
                                $("#proyectos_proyecto").val("")
                        }
                        
                        
                        function eliminar_empleado(empleado){
                            if(confirm("¿ seguro que desea eliminar el Tipo de empleado ? ")){	
                                $.ajax({
                                        url: '<?php echo url_for(@tipo_empleado_eliminar) ?>',
                                        data:"empleado="+empleado,
                                        dataType:"json",
                                        success: function( resultado ) {
                                                alert(resultado);
                                                limpiar_empleado()
                                                tipo_empleado.fnDraw();
                                        }
                                });
                            }
                        }
                        function limpiar_empleado(){
                                $("#tipo_empleado_idtipoempleado").val("")
                                $("#tipo_empleado_empleado").val("")
                        }
                        function editar_empleado(id,empleado){
                            $("#tipo_empleado_idtipoempleado").val(id)
                            $("#tipo_empleado_empleado").val(empleado)
                        }
                        
                        
                        function eliminar_cargo(cargo){
                            if(confirm("¿ seguro que desea eliminar el cargo ? ")){	
                                $.ajax({
                                        url: '<?php echo url_for(@cargo_eliminar) ?>',
                                        data:"cargo="+cargo,
                                        dataType:"json",
                                        success: function( resultado ) {
                                                alert(resultado);
                                                limpiar_cargo()
                                                lista_cargos.fnDraw();
                                        }
                                });
                            }
                        }
                        function limpiar_cargo(){
                                $("#cargos_idcargo").val("")
                                $("#cargos_cargo").val("")
                        }
                        function editar_cargo(id,cargo){
                            $("#cargos_idcargo").val(id)
                            $("#cargos_cargo").val(cargo)
                        }
                        
                        
                        function eliminar_departamento(departamento){
                            if(confirm("¿ seguro que desea eliminar el departamento ? ")){	
                                $.ajax({
                                        url: '<?php echo url_for(@departamento_eliminar) ?>',
                                        data:"departamento="+departamento,
                                        dataType:"json",
                                        success: function( resultado ) {
                                                alert(resultado);
                                                limpiar_departamento()
                                                lista_departamentos.fnDraw();
                                        }
                                });
                            }
                        }
                        function limpiar_departamento(){
                                $("#departamentos_iddepartamento").val("")
                                $("#departamentos_departamento").val("")
                        }
                        function editar_departamento(id,departamento){
                            $("#departamentos_iddepartamento").val(id)
                            $("#departamentos_departamento").val(departamento)
                        }
                        
                        
                        function eliminar_sede(sede){
                            if(confirm("¿ seguro que desea eliminarla sede ? ")){	
                                $.ajax({
                                        url: '<?php echo url_for(@sede_eliminar) ?>',
                                        data:"sede="+sede,
                                        dataType:"json",
                                        success: function( resultado ) {
                                                alert(resultado);
                                                limpiar_sede()
                                                lista_sedes.fnDraw();
                                        }
                                });
                            }
                        }
                        function limpiar_sede(){
                                $("#sedes_idsede").val("")
                                $("#sedes_sede").val("")
                        }
                        function editar_sede(id,sede){
                            $("#sedes_idsede").val(id)
                            $("#sedes_sede").val(sede)
                        }
                        
</script>
