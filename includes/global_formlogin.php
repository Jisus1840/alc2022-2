<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Login
*********************************************************************************
*/
?>
<script language="javascript">
    $(document).ajaxStart(function() {
        $("#loading").show();
    });

    $(document).ready(function(){
        $("#accesar").click(function(){

            event.preventDefault(); // stop the click to redirect to the URL in href

            //Peticion AJAX validar usuario y crear sesion
            if ($("#usuario").val() != '' && $("#password").val() != ''){
                $.ajax({
                    url: '../ajax/global_login.php',
                    dataType: "text",
                    async: true,
                    data: {
                        'usuario' : $('#usuario').val(),
                        'password' : $('#password').val()
                    },  
                    type: 'post',
                    beforeSend: function() {
                        $("#loading").show();	
                    },
                    success: function(data) { 
                        if (data == 1){
                            location.href='../gui/global_inicio.php';
                        }else{
                            alert ("Error: "+data);
                            $("#password").val("");
                            $("#usuario").val("");
                        }
                    },
                    complete: function(data) { 
                        $("#loading").hide();
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { 
                        alert (textStatus);
                        if (textStatus == "error"){
                            alert("Error: " + errorThrown); 
                        }
                    }
                });

            }else{
                alert ("Usuario y Contraseña son campos obligatorios");
                $("#usuario").focus();
            }
        });
    });

    $(document).ajaxStop(function() {
        $("#loading").hide();
    });    
</script>
<!--<i class="material-icons">chat</i>-->
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-11 col-md-offset-1 col-md-pull-1 animate-box" data-animate-effect="fadeInLeft">
                <form action="">
                    <div class="form-group">
                        <input id="usuario" name="usuario" type="text" class="form-control" placeholder="Usuario">
                    </div>
                    <div class="form-group">
                        <input id="password" name="password" type="password" class="form-control" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <input id="accesar" name="accesar" type="button" class="btn btn-primary btn-send-message" value="Entrar">
                    </div>
                    <a href="../gui/global_loginext.php" style="font-size:9px">Login como Usuario</a>
                </form>
            </div>
        </div>
    </div>
</div>
