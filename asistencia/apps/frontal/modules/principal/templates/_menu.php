
<div id="menu_bar">
    <ul>
	<?php if($sf_user->isAuthenticated()): ?>
	     <?php if($sf_user->getDatosBasicos()->getUsuarioSistema()->getFirst()->getTipoUsuario()->getIdtipousuario() ===2): ?>				
		<li>
			<span class="head_menu">
				<span class="arrow">REGISTRO&#9660;</span>
			</span>
		    <div class="sub_menu">
			<ol>
				<li><a href="javascript:abrir('tipo de proyecto')" class="item_line">TIPO DE PROYECTO</a></li>
				<li><a href="javascript:abrir('tipo de empleado')" class="item_line">TIPO DE EMPLEADO</a></li>
				<li><a href="javascript:abrir('cargo')" class="item_line">CARGO</a></li>
				<li><a href="javascript:abrir('departamento')" class="item_line">DEPARTAMENTO</a></li>
				<li><a href="javascript:abrir('sede')" class="item_line">SEDE</a></li>
				<!--<li><a href="javascript:abrir('supervisor')" class="item_line">SUPERVISOR</a></li>-->
<!--                                <li><a href="javascript:abrir('nomina')" class="item_line">ACTUALIZAR CODIGO</a></li>-->
				<li><a href="javascript:abrir('empleado')" class="item_line">EMPLEADO</a></li>
				<li><a href="javascript:abrir('usuario')" class="item_line">USUARIO</a></li>
			</ol>
		    </div>
		</li>					
		<li>
			<span class="head_menu">
				<span class="arrow">CONFIGURACIÓN&#9660;</span>
			</span>
		    <div class="sub_menu">
			<ol>
				<li><a href="javascript:abrir('configuracion principal')" class="item_line">PRINCIPAL</a></li>
				<li><a href="javascript:abrir('dias feriados')" class="item_line">DIAS FERIADOS</a></li>
			</ol>
		    </div>
		</li>
	     <?php endif; ?>
           <?php if($sf_user->getDatosBasicos()->getUsuarioSistema()->getFirst()->getTipoUsuario()->getIdtipousuario() ===2 || $sf_user->getDatosBasicos()->getUsuarioSistema()->getFirst()->getTipoUsuario()->getIdtipousuario() ===1): ?>								
		<li>
			<span class="head_menu">
				<span class="arrow">PERMISO&#9660;</span>
			</span>
		    <div class="sub_menu">
			<ol>
                    <?php if($sf_user->getDatosBasicos()->getUsuarioSistema()->getFirst()->getTipoUsuario()->getIdtipousuario() ===2): ?>
				<li><a href="javascript:abrir('motivo nuevo')" class="item_line">NUEVO MOTIVO</a></li>
                    <?php endif; ?>
				<li><a href="javascript:abrir('permiso asignar')" class="item_line">ASIGNAR</a></li>
			</ol>
		    </div>
		</li>
	     <?php endif; ?>
               <?php if($sf_user->getDatosBasicos()->getUsuarioSistema()->getFirst()->getTipoUsuario()->getIdtipousuario() ===2 || $sf_user->getDatosBasicos()->getUsuarioSistema()->getFirst()->getTipoUsuario()->getIdtipousuario() ===1 || $sf_user->getDatosBasicos()->getUsuarioSistema()->getFirst()->getTipoUsuario()->getIdtipousuario() ===3): ?> 
                
		<li>
			<span class="head_menu">
				<span class="arrow">REPORTE&#9660;</span>
			</span>
		    <div class="sub_menu">
			<ol>
				<!--<li><a href="javascript:abrir('reporte general')" class="item_line">GENERAL</a></li>-->
				<li><a href="javascript:abrir('reporte especifico')" class="item_line">ESPECIFICO</a></li>
				<!--<li><a href="javascript:abrir('reporte estadistico')" class="item_line">ESTADISTICO</a></li>-->
				<li><a href="javascript:abrir('reporte horas extras')" class="item_line">HORAS EXTRAS</a></li>
				<li><a href="javascript:abrir('reporte permisos')" class="item_line">PERMISOS OTORGADOS</a></li>
			</ol>
		    </div>
		</li>
                  <?php endif; ?>
                  <?php if($sf_user->getDatosBasicos()->getUsuarioSistema()->getFirst()->getTipoUsuario()->getIdtipousuario() ===4): ?>								
		<li>
			<span class="head_menu">
				<span class="arrow">CARGAR PERMISO&#9660;</span>
			</span>
		    <div class="sub_menu">
			<ol>
                    <?php if($sf_user->getDatosBasicos()->getUsuarioSistema()->getFirst()->getTipoUsuario()->getIdtipousuario() ===2): ?>
				<li><a href="javascript:abrir('motivo nuevo')" class="item_line">NUEVO MOTIVO</a></li>
                    <?php endif; ?>
				<li><a href="javascript:abrir('permiso asignar')" class="item_line">ASIGNAR</a></li>
			</ol>
		    </div>
		</li>
	     <?php endif; ?>
                
		<li><span class="head_menu"><a href="javascript:abrir('cambiar clave')">CAMBIAR CONTRASEÑA</a></span></li>
	     <?php if($sf_user->getDatosBasicos()->getUsuarioSistema()->getFirst()->getTipoUsuario()->getIdtipousuario() ===2 || $sf_user->getDatosBasicos()->getUsuarioSistema()->getFirst()->getTipoUsuario()->getIdtipousuario() ===1): ?>				
		<li><span class="head_menu"><a href="javascript:abrir('registro movimiento')">REGISTRAR MOVIMIENTO</a></span></li>
          <li><span class="head_menu"><a href="javascript:abrir('asignar turno')">ASIGNAR TURNO</a></span></li>
	     <?php endif; ?>
		<li><span class="head_menu"><a href="javascript:cerrar_session()">Cerrar sesion</a></span></li>
	<?php else: ?>
		<li><span class="head_menu"><a href="javascript:inicio_session()">Inicio de sesion</a></span></li>
	<?php endif; ?>
                 	  
                
    </ul>
</div>
<?php //$var = $sf_user->getDatosBasicos()->getUsuarioSistema() ?>
<?php //foreach($var as $i =>$j): ?>
<?php //print $i->getTipoUsuario()(); ?>
<?php //echo "$i = $j,";?>
<?php //endforeach; ?>
<?php ?>
<?php //echo $sf_user->getDatosBasicos()->getUsuarioSistema()->getTipoUsuario()/*->getTipousuario()*/ ?>
