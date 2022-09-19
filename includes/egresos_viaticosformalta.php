<script>

    $(document).ajaxStart(function() {
        $("#loading").show();
    });

    $(document).ready(function(){

        $("#nuevomovimiento").on("click",function(){
            //Abrir Modal
            var page = "https://htmlcolorcodes.com/es/";
            var title = "Google";
            var $dialog = $('<div></div>')
                .html('<iframe style="border: 0px; " src="' + page + '" width="100%" height="100%"></iframe>')
                .css({overflow:"hidden"})	
                .dialog({
                       autoOpen: false,
                       modal: true,
                       show: { effect: "fold", duration: 1000 },
                       hide: {effect: "fold", duration: 1000 },
                       height: 700,
                       width: 600,
                       title: title
               });
               $dialog.dialog('open');
            });

    });   

    $(document).ajaxStop(function() {
        $("#loading").hide();
    });

</script>

<!-- Loading -->
<div id="loading" style="display:none">
    <img id="loading-image" src="../imagenes/loading.gif" width="100%"/>
</div>

<!-- Esta sección abarcará los botones que realizarán acciones en el sistema. -->
<div class="row pl-1 pr-1 mb-0">
    <div class="col s12">
        <div class="card">
            <div class="row p-1">
                <div class="col s12">
                    <h6 class="left m-2"><b>Solicitud de Viáticos</b></h6>
                </div>
                <div class="col s12">
                    <a id ="nuevomovimiento" class="waves-effect waves-green btn-flat btn-small mr-1"><i class="material-icons left">add</i>Nuevo movimiento</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Esta sección abarcará los filtros de búsqueda del sistema. -->
<div class="row pl-1 pr-1 mb-0">
    <div class="col s12 ">
        <div class="card">
            <div class="row valign-wrapper p-1">
                <div class="col s12 valing-wrapper">
                    <h6 class="ml-1"><b>Filtrar búsqueda</b></h6>
                </div>
            </div>
            <div class="row">
                <form class="col s12" id="formulario-filtrar-busqueda">
                    <div class="ml-1 row m-0">
                        <div class="input-field col s6 m2">
                            <select id="select-tipo-movimiento" class="select">
                            </select>
                        </div>
                        <div class="input-field col s6 m2">
                            <select id="select-tipo-combustible">
                            </select>
                        </div>
                        <div class="input-field col s6 m2">
                            <select id="select-tipo-estatus">
                            </select>
                        </div>
                        <div class="input-field col s6 m2">
                            <select id="select-tipo-contenedor">
                            </select>
                        </div>
                        <div class="input-field col s6 m2">
                            <input type="text" class="datepicker" id="desde">
                            <label for="desde">Desde</label>
                        </div>
                        <div class="input-field col s6 m2">
                            <input type="text" class="datepicker" id="hasta">
                            <label for="hasta">Hasta</label>
                        </div>
                    </div>
                    <div class="ml-1 row m-0 ">
                        <div class="input-field col s12 right-align">
                            <a class="waves-effect waves-light btn" id="boton-buscar" onclick=""><i class="material-icons left">search</i>Buscar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Botón que se encargará de refrescar la página. -->
<div class="fixed-action-btn">
    <a class="btn-floating btn-large pink darken-1 spin" onclick="refrescar_tabla()">
        <i class="large material-icons">refresh</i>
    </a>
</div>

<!-- Tabla con la información del sistema. -->
<div class="row mb-0">
    <div class="col s12">
        <div class="card p-2">
            <div class="input-field">
                <input id="empleadox" name="empleadox" placeholder="hollaaaa" type="text" />
            </div>
            <table class="centered highlight responsive-table" id="table-pagination">
                <thead>
                    <tr>
                        <th>Tipo movimiento</th>
                        <th>Fecha</th>
                        <th>Combustible</th>
                        <th>Contenedor</th>
                        <th>Autoriza</th>
                        <th>Estatus</th>
                        <th id="inventarios-gui-acciones" valign="left">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tabla-inventario">
                </tbody>
            </table>
        </div>
    </div>
</div>