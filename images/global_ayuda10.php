<h3 style="font-size: 38px;">COSTOS</h3><br>
<div style="font-size: 18px;">
<p>
    <b>Venta Libre de:</b>
	<ul>
		<li>Cerveza - $11,737.12</li>
		<li>Venta Libre de Cerveza y Vino - $31,847.96</li>
	</ul>

	<b>Por Unidad:</b><br><br>
	<ul>
		<li>Bote - $9.00</li>
		<li>Caguama - $10.20</li>
		<li>Descorche por botella (vinos y licores) - $125.00</li>
	</ul>
</p>

<p>Para calcular la cantidad a pagar, utiliza el siguiente ejemplo sólo marcando el número de cervezas (por unidad) que consieras que se van a vender en tu evento, donde dice # DE BOTELLAS o # DE BOTES pon la cantidad y automáticamente te dará el monto que deberás pagar el día que te presentes en la Coordinación de Alcoholes junto con la papelería requerida.</p>

<br>

<b>POR CERVEZA IGUAL O SUPERIOR A LOS 940 ML</b><br><br>
<table>
	<tr>
		<th width="33%">COSTO X BOTELLA (CAGUAMA)</th>
		<th width="34%"># DE BOTELLAS</t>
		<th width="33%">TOTAL</th>
	</tr>
	<tr>
		<td>$10.20</td>
		<td><input type="text" id="num_botellas" name="num_botellas" oninput="costo_botellas()" /></td>
		<td><span id="total_pagar_botellas"></span></td>
	</tr>
</table>

<b>POR CERVEZA IGUAL O MENOR A LOS 940 ML</b><br><br>
<table>
	<tr>	
		<th width="33%">COSTO X BOTE</th>
		<th width="34%"># DE BOTES</th>
		<th width="33%">TOTAL</th>		
	</tr>
	<tr>
		<td>$9.00</td>
		<td><input type="text" id="num_botes" name="num_botes" oninput="costo_botes()" /></td>
		<td><span id="total_pagar_botes" name="total_pagar_botes"></span></td>
	</tr>
</table>

<b>POR VINOS Y LICORES</b><br><br>
<table>
	<tr>	
		<th width="33%">COSTO X DESCORCHE</th>
		<th width="34%"># DE BOTELLAS O VINOS</th>
		<th width="33%">TOTAL</th>		
	</tr>
	<tr>
		<td>$125.00</td>
		<td><input type="text" id="num_descorche" name="num_descorche" oninput="costo_descorches()" /></td>
		<td><span id="total_pagar_descorches" name="total_pagar_descorches"></span></td>
	</tr>
</table>
</div>