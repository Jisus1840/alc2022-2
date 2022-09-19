<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Ver todos los permisos
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<? include_once ("../js/global_header.js");?>
<?
    $p = new permisos();
    $p->revisarpermisos('2004',$usersessionpermisos);
?>
<script language="javascript">

    $(document).ajaxStart(function() {
        $("#loading").show();
    });

    $(document).ready(function(){
        $("i").on("click",function(){
            var id = this.id;
            var arr = id.split("|");
            switch(arr[0]) {
                case'verinfo':
                    var page = "../includes/global_verinfolicenciaprovisional.php?id="+arr[1];
                    var $dialog = $('<div></div>')
                        .html('<iframe style="border: 0px; " src="' + page + '" width="100%" height="100%"></iframe>')
                        .css({overflow:"hidden"})	
                        .dialog({
                               autoOpen: false,
                               modal: true,
                               show: { effect: "fold", duration: 1000 },
                               hide: {effect: "fold", duration: 1000 },
                               height: 525,
                               width: 700,
                               title: "Información"
                       });
                       $dialog.dialog('open');
                       break; 
                case'mapa':	
                    var page = "../includes/global_verubicacion.php?latitud="+arr[2]+"&longitud="+arr[3];
                    var $dialog = $('<div></div>')
                        .html('<iframe style="border: 0px; " src="' + page + '" width="100%" height="100%"></iframe>')
                        .css({overflow:"hidden"})	
                        .dialog({
                               autoOpen: false,
                               modal: true,
                               show: { effect: "fold", duration: 1000 },
                               hide: {effect: "fold", duration: 1000 },
                               height: 525,
                               width: 700,
                               title: "Ubicación"
                       });
                       $dialog.dialog('open');
                       break; 
                default:
            }
        });
    });

    $(document).ajaxStop(function() {
        $("#loading").hide();
    });
</script>
<? 
$inputbusqueda = isset($_GET['inputbusqueda']) ? $_GET['inputbusqueda'] : '';
$inputbusquedastatus = isset($_GET['inputbusquedastatus']) ? $_GET['inputbusquedastatus'] : '';
?>
<div id="loading" style="display:none">
    <img id="loading-image" src="../images/global_loading.gif"/>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-11 col-md-offset-1 col-md-pull-1 animate-box" data-animate-effect="fadeInLeft">
                <?
                //paginador
                $connclass  	= new DBmysqli();
                $conn 			= $connclass->conn;
                $limit      	= ( isset( $_GET['limit'] ) ) ? $_GET['limit'] : 50;
                $page      		= ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1;
                $links      	= ( isset( $_GET['links'] ) ) ? $_GET['links'] : 2;
                $morelinks      = ( isset( $_GET['inputbusqueda'] ) ) ? "&inputbusqueda=".$_GET['inputbusqueda'] : "";

                $getquery = new licencias();
                $query = $getquery->getqueryallpermisos($inputbusqueda,$inputbusquedastatus);
                $Paginator  	= new Paginator($conn, $query);
                $results    	= $Paginator->getData($limit, $page);
                ?>
                <?php echo $Paginator->createLinks($links, 'pagination',$morelinks ); ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Licencia</th>
                            <th scope="col">Propietario</th>
                            <th scope="col">Colonia</th>
                            <th scope="col">Zona</th>
                            <th scope="col">CP</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?
                    if($results <> ''){
                        if(count($results->data) > 0){
                            foreach ($results->data as $row){ 
                                ?>
                                <tr>
                                    <td><?=$row['permisos_folio']?></td>
                                    <td><?=$row['nombrepropietario']?></td>
                                    <td><?=$row['colonia_nombre']?></td>
                                    <td><?=$row['zona_nombre']?></td>
                                    <td><?=$row['colonia_cp']?></td>
                                    <td width="120px">
                                        <!--info-->
                                        <i id="verinfo|<?=$row['permisos_id']?>" style="cursor:pointer; font-size: 1.5em;" title="Ver Info" class="icon-eye"></i>
                                        <!--mapa-->
                                        <i id="mapa|<?=$row['permisos_id']?>|<?=$row['permisos_latitud']?>|<?=$row['permisos_longitud']?>" style="cursor:pointer; font-size: 1.5em;" title="Ver Ubicación" class="icon-map"></i>
                                    </td>
                                </tr>
                                <?
                            }
                        }
				    }
				    ?>
                    </tbody>
                </table>
                <br>
		        <? echo $Paginator->createLinks($links, 'pagination',$morelinks ); ?>
            </div>
        </div>
    </div>
</div>