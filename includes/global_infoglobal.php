<?
include '../config/global_includes.php';
$du = new documentosupload();
$aviso = $du->get_imagen_aviso();
?>
<!--<br><br><br><br><br><br><br><br><br><br>

<h4>¿Qué trámites puedes solicitar?</h4>

    <ul style="font-size:18px;color:black ">
        <br>
        <li>
            <b>Solicitud de Licencia</b> que expeda o sirvan en cualquier modalidad de bebidas alcohólicas.
            <br>
            <i>(Si deseas obtener una licencia con venta de bebidas alcohólicas)</i>
        </li>
        <br>
        <li>
            <b>Cambios a tu licencia.</b> Para más información consulta los cambios de titular, comodatario, domicilio, giro, nombre genérico y razón social de las licencias - CAPÍTULO TERCERO - a partir del Artículo 47 del <a href="../docs/reglamento.pdf" target="_blank">Reglamento de la Unidad Administrativa de Alcoholes.</a>
            <ul>    
                <li>
                    <b>Cambio de Propietario</b>
                    <br>
                    <i>(Cambio de propietario. Propietario es la persona que cumple con sus derechos y obligaciones de una licencia de Alcoholes)</i>
                </li>
                <li>
                    <b>Cambio de Comodatario</b>
                    <br>
                     <i>(Cambio de comodatario. Persona que toma prestado una licencia en comodato)</i>
                </li>
                <li>
                    <b>Cambio de Domicilio</b>
                    <br>
                     <i>(Cambio de domicilio de tu negocio)</i>
                </li>
                <li>
                    <b>Cambio de Giro</b>
                    <br>
                     <i>(Cambio de Giro de tu negocio)</i>
                </li>
                <li>
                    <b>Cambio de Tipo de Licencia</b>
                    <br>
                     <i>(Cambio de Tipo de Licencia. LICENCIA TIPO B (Venta de cualquier tipo de bebidas alcohólicas) o LICENCIA TIPO A (Venta exclusiva de cerveza)</i>
                </li>
            </ul>
        </li>
        <br>
        <li>
            <b>Solicitud de Permiso Especial</b>
            <br>
            <i>(Si tienes algún evento donde se llevará a cabo la venta al menudeo de bebidas alcohólicas en envase abierto y/o copeo como, exhibiciones, reuniones, convenciones, fiestas patronales, eventos sociales y deportivos, espectáculos y/o conciertos, etc.)</i>
        </li>
        <br>
        <li>
            <b>Refrendo</b>
            <br>
            <i>(Pago anual de tu licencia, es decir, es un acto administrativo por el cuál se renueva una licencia)</i>
        </li>
    </ul>
<table width="500px">
    <tr>
        <td width="450px">
            <p style="color:red">
                <i>
                * No olvides que para iniciar un trámite deberás tener los documentos ya digitalizados, guardarlos en un lugar de tu computadora donde los puedas buscar fácilmente ya que se te pedirán cuando inicies tu trámite.
                </i>
            </p>
        </td>
        <td width="150px" align="center">
            <p style="font-size:10px">
                Da click en la siguiente<br>
                imagen, para conocer los<br>
                requisitos.<br>
                <img src="../images/flecharoja.jpg" width="100px">
            </p>
        </td>
        <td width="200px">
            <h3 style="color:red"><b>REQUISITOS</b></h3><br>
            <a href="../gui/global_startrequisitos.php" target="_blank" title="Ver requisitos">
                <img src="../images/requistos.jpg" width="150px">
            </a>
        </td>
    </tr>
</table>
<br>-->
<br>
<h4 style="text-align: center;">Tus Derechos y Obligaciones</h4>
<p style="text-align: justify !important;">Si ya tienes una licencia de Alcoholes o estas interesado en obtener una, es fundamental que conozcas el <b>Reglamento para los establecimientos que expeden o sirven bebidas alcohólicas en el Municipio de Saltillo, Coahuila de Zaragoza.</b>
</p>

<table>
    <tr>
        <th style="text-align: center;">REGLAMENTO</th>
        <th style="text-align: center;">LEY DE INGRESOS / COSTOS DE LICENCIAS</th>
        <th style="text-align: center;">FORMATOS</th>
    </tr>
    <tr>
        <td style="text-align: center;">
            <a href="../docs/leyingresos2021.pdf" target="_blank">
                <img src="../images/downloadpdf.jpg" width="100px">
            </a>
        </td>
        <td style="text-align: center;">
            <a href="../docs/leyingresos_2022.pdf" target="_blank">
                <img src="../images/downloadpdf.jpg" width="100px">
            </a>
        </td>
        <td style="text-align: center;">
            <a href="../gui/global_formatos.php">
                <img src="../images/downloadpdf.jpg" width="100px">
            </a>
        </td>
    </tr>
</table>


<!--
        <td align="center" width="33%" style="vertical-align:top;">
            <h4>Costos</h4>
            Si ya tienes una licencia de Alcoholes y deseas hacer un cambio o estas interesado en obtener una puedes consultar los costos que deberás cubrir según la Ley de Ingresos del Municipios de Saltillo, Coahuila de Zaragoza para el ejercicio fiscal del año 2020.
        </td>
        -->
<div class="x-column x-sm x-1-2">
    <h4 style="text-align: center;">Horarios</h4>
    <p style="text-align: center;">Conoce los horarios de venta conforme a los tipos de giro que existen</p>
    <div style="text-align: center;">
        <a href="../gui/global_starthorarios.php" target="_blank">
            <img src="../images/horario.jpeg" width="150px">
        </a>
    </div>
</div>
<div class="x-column x-sm x-1-2">
    <h4 style="text-align: center;">Avisos</h4>
    <div style="text-align: center;">
        <a href="global_avisos_cga.php" target="_blank">
            <img id="aviso_cga" src="../images/avisos_cga.jpeg" width="300px" height="500px">
        </a>
    </div>
</div>
<br>
<br>
<br>
<p style="text-align: center;">
    Correo de contacto: alcoholes@saltillo.gob.mx
</p>




<!--
        <td align="center" width="33%" valign="top">
            <a href="../docs/costos.pdf" target="_blank">
                <img src="../images/costos.jpg" width="200px">
            </a>
        </td>
        -->



<!--
<br><br>
<table>
    <tr>
        <td width="500px">
            <h4>Acceso al Sistema</h4>
            <p>Recuerda que es importante que recuerdes tu correo y RFC que utilizarás ya que con ellos podrás consultar y dar seguimiento a tu trámite las veces que deseas.</p>
            <br>
            <img src="../images/flecharoja.jpg" width="300px">
        </td>
        <td width="700px">
            <a href="../gui/global_loginext.php" target="_blank">
                <img src="../images/ejemplo13.jpg" width="700px">
            </a>
        </td>
    </tr>
</table>
-->