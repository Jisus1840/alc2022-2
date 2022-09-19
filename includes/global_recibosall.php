<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Ver todos los recibos
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<? include_once ("../js/global_header.js");?>
<?
    $p = new permisos();
    $p->revisarpermisos('2009',$usersessionpermisos);
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
						case'verrecibo':
				            window.open("../gdocs/global_recibotramites.php?bloque="+arr[1]);
							break;
					  	default:
					}
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
                <?
                //paginador
                $connclass  	= new DBmysqli();
                $conn 			= $connclass->conn;
                $limit      	= ( isset( $_GET['limit'] ) ) ? $_GET['limit'] : 50;
                $page      		= ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1;
                $links      	= ( isset( $_GET['links'] ) ) ? $_GET['links'] : 15;
                $morelinks      = ( isset( $_GET['inputbusqueda'] ) ) ? "&inputbusqueda=".$_GET['inputbusqueda'] : "";

                $getquery = new ventanilla();
                $query = $getquery->getqueryallrecibos();
                $Paginator  	= new Paginator($conn, $query);
                $results    	= $Paginator->getData($limit, $page);
                ?>
                <?php echo $Paginator->createLinks($links, 'pagination',$morelinks ); ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Bloque</th>
                            <th scope="col"># trámites</th>
                            <th scope="col">Usuario</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?
                    if($results <> ''){
                        if(count($results->data) > 0){
                            foreach ($results->data as $row){ 
                                ?>
                                <tr>
                                    <td><?=$row['historialvu_bloque']?></td>
                                    <td><?=$row['numero']?></td>
                                    <td><?=$row['usuarios_nombre']?></td>
                                    <td>
                                        <i id="verrecibo|<?=$row['historialvu_bloque']?>" style="cursor:pointer; font-size: 1.5em;" title="Ver Info" class="icon-printer"></i>
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