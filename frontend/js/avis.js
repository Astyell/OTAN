/** avis.js
	* @author  : Alizéa Lebaron
	* @since   : 02/04/2024
	* @version : 1.0.0 - 02/04/2024
	*/

fetch('../js/avis.json').then(response => response.json()).then(data => 
{
	if (data.logo1       != null) {document.getElementById('logoG').innerHTML = '<img src="../img/download/logo1.png" alt="logo1" class="logo">';}
	if (data.logo2       != null) {document.getElementById('logoD').innerHTML = '<img src="../img/download/logo2.png" alt="logo2" class="logo">';}

	if (data.anneeProm   != null) {document.getElementById('annee')   .innerHTML = data.anneeProm;}
	if (data.nomChef     != null) {document.getElementById('chefDept').innerHTML = data.nomChef  ;}

	if (data.signChefDep != null) {document.getElementById('signDept').innerHTML = '<img src="../img/download/signChefDep.png" alt="signature dep" class="logo">';}

}).catch();
