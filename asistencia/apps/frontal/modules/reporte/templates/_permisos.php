<div>
    <style type="text/css">
        table{
                color: #000000;
                font-family: Arial,Verdana,Tahoma;
                font-size: 90px;
            }
        thead th,tfoot,th{
        /* font-weight: bold;*/
            text-align: center;
            text-transform: lowercase;
        }
        table td{
            text-align: left;
        }
        .fin{
            /*border: 2px solid #333366;*/
            background-color: #4E6CA3;
            color:white;
        }
        .tr{
            background-color: #DDDDDD;
        }
        thead{
            border: 1px;
        }
    </style>    
    <table align="center" width="2500">

        <tr>
            <th align="left" width="350"><b>Apellido y Nombre: </b></th>
            <td align="left"><?php 
            $secre = Doctrine_Core::getTable("Usuario")->buscarSecretaria(null,$movimiento[0]["id_usuario_r"]);
           
            if ($secre){
                foreach ($secre as $secretaria) {
                    $tipoEmpleado = Doctrine_Core::getTable("TipoEmpleado")->listarEmpleado($secretaria->getIdtipoempleado());
                     $depar=  Doctrine_Core::getTable("Departamento")->departamentoid($secretaria->getIddepartamento()); 
                    echo $secretaria->getNombre(). " " . $secretaria->getApellido(); 
            ?></td>
          <th align="left" width="300"><b>Dependencia:</b></th>
             <td align="left" width="1200"><?php if ($depar){
                foreach ($depar as $dpto) {
                    echo $dpto->getDepartamento();
                }
                }?></td>
        </tr><tr>
            <th align="left" width="350"> <b>Cédula: </b></th>
            <td align="left"><?php echo $secretaria->getCedula(); }} ?></td>
             <th align="left" width="300"><b>Tipo Empleado: </b></th>
            <td align="left"><?php 
            if ($tipoEmpleado){
                foreach ($tipoEmpleado as $tipo) {
                    echo $tipo->getEmpleado();
                }
                }
                ?></td>
        </tr>
        <tr>
            <td colspan="4" align="left"><b>Del </b> <?php echo $fecha_desde; ?> <b>al</b> <?php echo $fecha_hasta; ?></td>
        </tr>
        <tr>
           
            <th align="left" width="350"><b>Fecha de Impresión: </b></th>
            <td align="left"><?php echo date("d/m/Y h:i a") ?></td>
        </tr>
            
    </table><br><br>
    <table align="center" width="2500" border="2" >
        <thead>
            <tr>
                <th width="600"><b>Nombres y Apellidos</b></th>
                <th width="200"><b>Cédula</b></th>
                <th width="400"><b>Cargo</b></th>
                <th width="300"><b>Tipo de Permiso</b></th>
                <th width="600"><b>Motivo del Permiso</b></th>
                <th width="230"><b>Desde </b></th>
                <th width="230"><b>Hasta</b></th>
                <th width="300"><b>Tiempo del Permiso</b></th>
                <th width="240"><b>Fecha del Registro </b></th>
            </tr>
        </thead>
        <tbody>
   
            
            <?php 
              // $contadortiempo1=0;
               
                for($i=0,$j=0;$j<count($movimiento);$j++): 
            ?>
             <tr  class="<?php echo ($fin_feriado)?"fin":"tr"?>">
               
                <td width="600"><?php echo $movimiento[$i]["Usuario"]["nombre"]. " " . $movimiento[$i]["Usuario"]["apellido"]; ?></td>
                        <td width="200"><?php echo $movimiento[$i]["Usuario"]["cedula"]; ?></td>
                        <td width="400"><?php  echo$movimiento[$i]["Usuario"]["Cargo"]["cargo"];  ?></td>
                        <td width="300"><?php echo $movimiento[$i]["tipopermiso"]; ?></td>
                        <td width="600"><?php echo $movimiento[$i]["Motivo"]["motivo"]; ?></td>
                        <td width="230"><?php echo date("d-m-Y", (strtotime($movimiento[$i]["fechadesde"]))); ?></td>
                        <td width="230" ><?php echo date("d-m-Y", (strtotime($movimiento[$i]["fechahasta"])));  ?></td>
                        
                        <? if($movimiento[$i]["tipopermiso"]=="dias"){
                       
                        $totaldias=Asistencia::dias_transcurridos($movimiento[$i]["fechadesde"],$movimiento[$i]["fechahasta"]);
                    
                        if($totaldias==0){
                      
                        $contadortiempo1= 1 ." dias" ;
                        }else {
                            if($totaldias!=0){
                              
                                $contadortiempo=$totaldias+1;
                                $contadortiempo1=$contadortiempo." dias";
                            }
                        }
                        }else{
                             $totalhoras=$movimiento[$i]["horas"]; 
                            if($movimiento[$i]["tipopermiso"]=="parcial"){
                              $contadortiempo=$totalhoras; 
                              $contadortiempo1=$contadortiempo." horas";
                            }
                        }        
                            
                        ?>
                          <td width="300"> <?php echo $contadortiempo1; $contadortiempo1=null;?> </td> 
                        <td width="240" ><?php echo date("d-m-Y h:i:s a ", (strtotime($movimiento[$i]["fecha"])));; ?></td>
                        
                     
            </tr> 
                <?php
                 $i++;
             
              
                endfor;
                
           ?>
    
        
        

        </tbody>
    </table>
      <Table align="center" width="3100" border="2" >
    <tr border="2">
        <td   width="500"align="left"><b>Revisado y Aprobado por:</b></td><td width="2600" align="left"></td></tr>
       <tr> <td align="left"width="500" ><b>Observaciones:</b></td> <td width="2600" align="left"></td>
    </tr>
    </table>
</div>