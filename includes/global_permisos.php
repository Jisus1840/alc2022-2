<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Permisos
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<? include_once ("../js/global_header.js");?>
<?
    $p = new permisos();
    $p->revisarpermisos('2011',$usersessionpermisos);
?>
<script language="javascript">

    $(document).ajaxStart(function() {
        $("#loading").show();
    });

    $(document).ready(function(){
        //Get tipo tramite
        var items1="";
        $.getJSON("../ajax/global_getusuariosactivos.php",function(data){
            items1+="<option value=''></option>";
            $.each(data,function(index,item){
                items1+="<option value='"+item.id+"'>"+item.nombre+"</option>";
            });
            $("#usuariopermisosid").html(items1); 
        });

        $("#usuariopermisosid").change(function(){
            rellenaformulario(this.value);
        });
        
        //Permiso
        $('input:checkbox').change(function(){
            if ($('#usuariopermisosid').val() == ''){
                alert ("Debes seleccionar un usuario");
                $('#usuariopermisosid').focus()
            }else{
                var idusuario = $('#usuariopermisosid').val();
                var idmenu = this.value;
                var permiso = $(this).is(':checked');
                $.ajax({
                    url: '../ajax/global_permisos.php',
                    dataType: "text",
                    data: {
                        'idusuario' : idusuario,
                        'idmenu' : idmenu,
                        'permiso' : permiso
                    },  
                    type: 'post',
                    beforeSend: function() {
                        $("#loading").show();	
                    },
                    success: function(data) { 
                        if (data != ''){
                            alert (data);
                        }
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
            }
        });
    });

    $(document).ajaxStop(function() {
        $("#loading").hide();
    });

    function rellenaformulario(id){
        $('input:checkbox').prop('checked',false);
        $.getJSON("../ajax/global_getpermisosbyusuario.php?idusuario="+id,function(data){
            $.each(data,function(index,item){
                //Por cada menu encontrado activarlo en el checkbox
                $("#ckb_"+item.idmenu).prop( "checked", true );
            });
        });
    }

</script>
	
<div id="loading" style="display:none">
    <img id="loading-image" src="../images/global_loading.gif"/>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-11 col-md-offset-1 col-md-pull-1 animate-box" data-animate-effect="fadeInLeft">
                <form id="miFormulario" name="miFormulario">
				<input type="hidden" name="usuarioid" id="usuarioid" value="<?=$usersession[0]['usuarios_id']?>" />
				<div class="form-row">
					<div class="form-group col-md-6">
						<label for="usuariopermisos">Usuario</label>
                        <select class="form-control" id="usuariopermisosid" name="usuariopermisosid">
                        </select>
					</div>
				</div>
                
                <div class="form-row">
                    <div class="form-group col-md-12">
						<br>
                            <h3>Menú</h3><hr>
                        <br>
					</div>
					<div class="form-group col-md-4">
                        
                        <!-- Trámites VU -->
						<input type="checkbox" id="ckb_1003" value="1003"> &nbsp;<b>Trámites</b><br>
                        &emsp;&emsp;<input type="checkbox" id="ckb_2007" value="2007"> &nbsp;Ver Trámites<br>
                        &emsp;&emsp;<input type="checkbox" id="ckb_2006" value="2006"> &nbsp;Catálogo de Trámites<br>
                        &emsp;&emsp;<input type="checkbox" id="ckb_2008" value="2008"> &nbsp;Escanear Trámites<br>
                        &emsp;&emsp;<input type="checkbox" id="ckb_2009" value="2009"> &nbsp;Ver recibos de escaneo<br>
                        &emsp;&emsp;<input type="checkbox" id="ckb_2099" value="2099"> &nbsp;Ver Pagos <br>
                        <br>
                        
                        <!-- Licencias -->
						<input type="checkbox" id="ckb_1001" value="1001"> &nbsp;<b>Licencias</b><br>
                        &emsp;&emsp;<input type="checkbox" id="ckb_2001" value="2001"> &nbsp;Ver Licencias<br>
                        &emsp;&emsp;<input type="checkbox" id="ckb_2002" value="2002"> &nbsp;Editar Licencias<br>
                        &emsp;&emsp;<input type="checkbox" id="ckb_2003" value="2003"> &nbsp;Todas las Licencias<br>
                        <br>
                        
                        <!-- Permisos Especiales -->
						<input type="checkbox" id="ckb_1002" value="1002"> &nbsp;<b>Permisos Especiales</b><br>
                        &emsp;&emsp;<input type="checkbox" id="ckb_2004" value="2004"> &nbsp;Ver Permisos<br>
                        &emsp;&emsp;<input type="checkbox" id="ckb_2005" value="2005"> &nbsp;Editar Permisos<br>
                        <br>
                        
					</div>
                    <div class="form-group col-md-4">
                        
                        <!-- Indicadores -->
						<input type="checkbox" id="ckb_1004" value="1004"> &nbsp;<b>Indicadores</b><br>
                        &emsp;&emsp;<input type="checkbox" id="ckb_2010" value="2010"> &nbsp;Indicadores<br>
                        <br>
                        
                        <!-- Catálogos -->
                        <input type="checkbox" id="ckb_1005" value="1005"> &nbsp;<b>Catálogos</b><br>
                        &emsp;&emsp;<input type="checkbox" id="ckb_33" value="33"> &nbsp;RFC<br>
                        &emsp;&emsp;<input type="checkbox" id="ckb_3" value="3"> &nbsp;Personas<br>
                        &emsp;&emsp;<input type="checkbox" id="ckb_13" value="13"> &nbsp;Giro<br>
                        &emsp;&emsp;<input type="checkbox" id="ckb_5" value="5"> &nbsp;Zonas<br>
                        &emsp;&emsp;<input type="checkbox" id="ckb_7" value="7"> &nbsp;Colonias<br>
                        &emsp;&emsp;<input type="checkbox" id="ckb_4" value="4"> &nbsp;Usuarios<br>
                        &emsp;&emsp;<input type="checkbox" id="ckb_6" value="6"> &nbsp;Estados<br>
                        &emsp;&emsp;<input type="checkbox" id="ckb_8" value="8"> &nbsp;Municipios<br>
                        <br>

                        <!-- Citas -->
						<input type="checkbox" id="ckb_1009" value="1009"> &nbsp;<b>Citas</b><br>
                        &emsp;&emsp;<input type="checkbox" id="ckb_22" value="22"> &nbsp;Agendar<br>
                        &emsp;&emsp;<input type="checkbox" id="ckb_23" value="23"> &nbsp;Ver<br>
                        &emsp;&emsp;<input type="checkbox" id="ckb_24" value="24"> &nbsp;Admin Tipo Cita<br>
                        &emsp;&emsp;<input type="checkbox" id="ckb_25" value="25"> &nbsp;Admin Usuarios<br>
                        &emsp;&emsp;<input type="checkbox" id="ckb_26" value="26"> &nbsp;Admin Relación Cita / Usuarios<br>
					</div>
                    <div class="form-group col-md-4">
                        
                        <!-- Permisos -->
                        <input type="checkbox" id="ckb_1007" value="1007"> &nbsp;<b>Permisos</b><br>
                        &emsp;&emsp;<input type="checkbox" id="ckb_2011" value="2011"> &nbsp;Permisos<br>
                        <br>
                        
                        <!-- Bitácora -->
                        <input type="checkbox" id="ckb_1008" value="1008"> &nbsp;<b>Bitácora</b><br>
                        &emsp;&emsp;<input type="checkbox" id="ckb_2012" value="2012"> &nbsp;Bitácora<br>
                        <br>
					</div>
				</div>		
			</form>
            </div>
        </div>
    </div>
</div>