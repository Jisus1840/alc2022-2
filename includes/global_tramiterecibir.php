<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Tramite Recibe
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<? include_once ("../js/global_header.js");?>
<?
    $p = new permisos();
    $p->revisarpermisos('2008',$usersessionpermisos);
?>
<?
$tramites="";

if(isset($_POST)){
	if((isset($_POST['idTramite'])) and  ($_POST['idTramite'] != "")){
		if($_POST['hidTramites'] == ""){
			$postidtramiteaux = $_POST['idTramite'];
			//if (substr($postidtramiteaux,10,1) == "'") 
			$postidtramiteaux = str_replace("'",'-',$postidtramiteaux);
			//echo $postidtramiteaux;
			//echo $_POST['idTramite'];
			if (preg_match("/^[0-9]{1,}-[0-9]{2}$/", $postidtramiteaux)){
				$idTramite = str_pad($postidtramiteaux, 8, "0", STR_PAD_LEFT);
				$tramites = "'".$idTramite."'";
				$aux[0] = $tramites;	
            }else{
				echo '<script type="text/javascript" language="javascript"> 
				alert("Formato de trámite inválido"); 
				</script>';
				$aux[0] = "";
			}
		}else{
			$postidtramiteaux = str_pad($_POST['idTramite'], 8, "0", STR_PAD_LEFT);
			$postidtramiteaux = str_replace("'",'-',$postidtramiteaux);
			if (preg_match("/^[0-9]{1,}-[0-9]{2}$/", $postidtramiteaux)){
				$idTramite = $postidtramiteaux;
				$tramites = $_POST['hidTramites'] . ',' . "'".$idTramite."'";
				$aux = explode(',', $tramites);
            }else{
				echo '<script type="text/javascript" language="javascript"> 
				alert("Formato de trámite inválido"); 
				</script>';
				$tramites = $_POST['hidTramites'];
				$aux = explode(',', $tramites);
			}
		}
        
		$aux2 = array_unique($aux);
		$tramites = implode(',', $aux2);
	}
	//eliminar
	if(isset($_POST['hiddenvalue'])){
		if ($_POST['hiddenvalue'] != ""){
			$tramites = $_POST['hidTramites'];
			$eliminar[0] = "'".$_POST['hiddenvalue']."'";
			$result = array_diff(explode(",",$_POST['hidTramites']), $eliminar);
			$tramites = implode(',', $result);
		}
	}
	
}
if($tramites != ''){
	$objTramite = new ventanilla();
	$res = $objTramite->recibir($tramites);
}
?>
<script language="javascript">

    $(document).ajaxStart(function() {
        $("#loading").show();
    });

    $(document).ready(function(){
        //get perfiles de usuario login
        var items1="";
        $.getJSON("../ajax/global_getpermisosperfilescaneo.php",function(data){
            $.each(data,function(index,item){
                if (item.id == '<?=$_SESSION['alcoholes']['perfil_escaneo']?>'){
                    items1+="<option value='"+item.id+"' selected>"+item.nombre+"</option>";
                }else{
                    items1+="<option value='"+item.id+"'>"+item.nombre+"</option>";
                }
            });
            $("#perfilescaneo").html(items1); 
        });
        
        $("#perfilescaneo").change(function() { 
            $.ajax({
                url: '../ajax/global_cambiarpermisoperfilescaneo.php',
                dataType: "text",
                data: {
                    "idperfil" : $("#perfilescaneo").val()
                },
                type: 'post',
                beforeSend: function() {
                    $("#loading").show();	
                },
                success: function(data) { 
                    
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    alert (textStatus);
                    if (textStatus == "error"){
                        alert("Error: " + errorThrown); 
                    }
                },
                complete: function(data) { 
                    location.reload();
                }
            });
        });
        
        $("#emitirrecibo").click(function() { 
            $.ajax({
                url: '../ajax/global_tramitesrecibo.php',
                dataType: "text",
                data: {
                    "tramites" : $("#resultado").val()
                },
                type: 'post',
                beforeSend: function() {
                    $("#loading").show();	
                },
                success: function(data) { 
                    alert(data);
                    location.reload();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    alert (textStatus);
                    if (textStatus == "error"){
                        alert("Error: " + errorThrown); 
                    }
                },
                complete: function(data) { 
                    $("#loading").hide();
                }
            });
        });
            
            
    });

    $(document).ajaxStop(function() {
        $("#loading").hide();
    });
</script>
<div id="loading" style="display:none">
    <img id="loading-image" src="../images/global_loading.gif"/>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-11 col-md-offset-1 col-md-pull-1 animate-box" data-animate-effect="fadeInLeft">
                <table align="right">
                    <tr>
                        <td width="60px">
                            Perfil:
                        </td>
                        <td width="250px">
                            <select id="perfilescaneo" name="perfilescaneo" class="form-control">
                            </select>
                        </td>
                    </tr>
                </table>
                <form name="buscar" id="buscar" action="" method="post" target="_self">
                    <table width="100%" class="form_table">
                        <tr>
                            <td>
                                ID de Trámite<br />
                                <input name="idTramite" type="text" id="idTramite" size="35" value="" onblur="submit();" placeholder="Formato 00001-20" />
                                <input type="hidden" name="hidTramites" id="hidTramites" value="<?php echo $tramites;?>" />

                            </td>
                        </tr>
                    </table>
                    <input type="hidden" name="hiddenvalue" />  
                </form>
                <br />
        <table width="100%">
            <tr>
                <td align="center">
                    <table class="form_table" width="100%" style="font-size:20px">
                        <tr>
                            <th width="90px">
                                #
                            </th>
                            <th>
                                Estatus Actual
                            </th>
                            <th>
                                Estatus Update
                            </th>
                            <th>
                                Tipo Tramite
                            </th>
                            <th>
                                Fecha
                            </th>
                            <th>
                                Estado
                            </th>
                            <th width="135px">&nbsp; </th>
                        </tr>
                        <?php
                            if((isset($res)?$res:0) != 0){
                                for($i=0;$i<count($res);$i++){
                                    if ($i==0) $temp=0;
                                    if ($res[$i]['nomcasilla']<>"")
                                    $temp=$temp+1;
                        ?>
                        <tr>
                            <td style="font-size:18px">
                                <?php echo $res[$i]['idtramite'];?>
                            </td>
                            <td style="font-size:18px">
                                <?php echo $res[$i]['nomcasillaactual'];  ?>
                            </td>
                            <td style="font-size:18px; color:#<?=$res[$i]['color']?>">
                                <b><?php echo $res[$i]['nomcasilla'];  ?></b>
                            </td>
                            <td style="font-size:18px">
                                <?php echo $res[$i]['nomtramite']; ?>
                            </td>
                            <td style="font-size:18px">
                                <?php echo $res[$i]['fechacreacion']; ?>
                            </td>
                            <td style="font-size:18px; color:#<?=$res[$i]['colorstatus']?>">
                                <b><?php echo $res[$i]['nomstatus']; ?></b>
                            </td>
                            <td>
                                <b style="color: <?php echo ($res[$i]['valido'] == 1)? '#003399':'#FF0000'; ?>"><?php echo ($res[$i]['valido'] == 1)? 'Recepción Correcta':'No se puede recibir.'; ?></b>
                            </td>
                        </tr>
                        <?php
                                }
                            }
                        ?>
                    </table>
                </td>
            </tr>
        </table>
        
        <input type="hidden" name="resultado" id="resultado" value="<?=$tramites?>" />
        <br />
        <table class="form_table" width="100%">
            <tr>
                <td align="right">
                    <b><? if (isset($temp)) echo $temp; ?></b>&nbsp;&nbsp;<INPUT type="button" id="emitirrecibo" value="Emitir Recibo" class="btn btn-primary btn-send-message" />
                </td>
             </tr>
        </table>
        
            </div>
        </div>
    </div>
</div>