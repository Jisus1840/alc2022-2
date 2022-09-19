
function costo_botellas() {
	var num_botellas = document.getElementById("num_botellas").value;
	if(isNaN(num_botellas)) {
		alert('Sólo se aceptan valores numéricos');
		document.getElementById("num_botellas").value = '';
		document.getElementById("total_pagar_botellas").innerHTML = '';
	}	
	else if(num_botellas != '') {
		var costo = num_botellas*10.20;
		document.getElementById("total_pagar_botellas").innerHTML = '$ '+ costo.toFixed(2);
	}
	else {
		document.getElementById("total_pagar_botellas").innerHTML = '';
	}
}

function costo_botes() {
	var num_botes = document.getElementById("num_botes").value;
	if(isNaN(num_botes)) {
		alert('Sólo se aceptan valores numéricos');
		document.getElementById("num_botes").value = '';
		document.getElementById("total_pagar_botes").innerHTML = '';
	}		
	else if(num_botes != '') {
		var costo = num_botes*9;
		document.getElementById("total_pagar_botes").innerHTML = '$ '+ costo.toFixed(2);
	}
	else {
		document.getElementById("total_pagar_botes").innerHTML = '';
	}
}

function costo_descorches() {
	var num_descorche = document.getElementById("num_descorche").value;
	if(isNaN(num_descorche)) {
		alert('Sólo se aceptan valores numéricos');
		document.getElementById("num_descorche").value = '';
		document.getElementById("total_pagar_descorches").innerHTML = '';
	}	
	else if(num_descorche != '') {
		var costo = num_descorche*125;
		document.getElementById("total_pagar_descorches").innerHTML = '$ '+ costo.toFixed(2);
	}
	else {
		document.getElementById("total_pagar_descorches").innerHTML = '';
	}
}