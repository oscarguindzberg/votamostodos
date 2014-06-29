<?php 
include("header-php.php");

$url_votamostodos = $_REQUEST["url_votamostodos"];
$url_esta_ley = $site_url . $contexto . "ley/" . $url_votamostodos; 

$leyes=mysql_query("select * from ley where url_votamostodos='$url_votamostodos'", $link);
assertNotFalse($leyes);
$ley=mysql_fetch_array($leyes);
assertNotFalse($ley);
mysql_free_result($leyes);

$accion = $_REQUEST["accion"]; 
if ($accion=="votar_si" || $accion=="votar_no" ) {
	$usuarios=mysql_query("select * from usuario where id_facebook=$id_facebook", $link);
	$usuario=mysql_fetch_array($usuarios);
	mysql_free_result($usuarios);
	if (!$usuario){
		$user_profile = $facebook->api('/me','GET');
		$nombre = $user_profile['name'];
		$email = $user_profile['email'];
		$success = mysql_query("insert into usuario (id_facebook, nombre, email) values ($id_facebook, '$nombre', '$email')", $link);
		assertNotFalse($success);		
		$usuarios=mysql_query("select * from usuario where id_facebook=$id_facebook", $link);
		assertNotFalse($usuarios);		
		$usuario=mysql_fetch_array($usuarios);
		assertNotFalse($usuario);
		mysql_free_result($usuarios);
	}		
	$id_usuario=$usuario["id"];

	$votosDosVeces=mysql_query("select * from voto where id_ley = " . $ley["id"] . " and id_usuario = " . $id_usuario, $link);
	assertNotFalse($votosDosVeces);
	$votoDosVeces=mysql_fetch_array($votosDosVeces);
	mysql_free_result($votosDosVeces);
	
	if (!$votoDosVeces) {
		if ($accion=="votar_si") {
			$success = mysql_query("insert into voto (id_ley, id_usuario, voto, momento) values (" . $ley["id"] . "," . $id_usuario . ",true,now())", $link);
			assertNotFalse($success);
			$success = mysql_query("update ley set cant_votos_si=cant_votos_si+1 where id=". $ley["id"], $link);	
			assertNotFalse($success);
		}
		if ($accion=="votar_no") {
			$success = mysql_query("insert into voto (id_ley, id_usuario, voto, momento) values (" . $ley["id"] . "," . $id_usuario . ",false,now())", $link);
			assertNotFalse($success);
			$success = mysql_query("update ley set cant_votos_no=cant_votos_no+1 where id=". $ley["id"], $link);	
			assertNotFalse($success);
		}
		
		$leyes=mysql_query("select * from ley where url_votamostodos='$url_votamostodos'", $link);
		assertNotFalse($leyes);
		$ley=mysql_fetch_array($leyes);
		assertNotFalse($ley);
		mysql_free_result($leyes);

		$cantVotosResult=mysql_query("select count(*) as cantVotos from voto where id_usuario = " . $id_usuario, $link);
		assertNotFalse($cantVotosResult);
		$cantVotosArray=mysql_fetch_array($cantVotosResult);
		assertNotFalse($cantVotosArray);
		mysql_free_result($cantVotosResult);
		$cantVotos = $cantVotosArray["cantVotos"];
		if ($cantVotos==2) {
			$mostrarPopupRedesSociales = true;
		}		
	}
}

$cant_votos = $ley["cant_votos_si"] + $ley["cant_votos_no"];
if ($cant_votos>0) {
	$porcentaje_si = ceil(100 * $ley["cant_votos_si"] / $cant_votos);
	$porcentaje_no = floor(100 * $ley["cant_votos_no"] / $cant_votos);
} else {
	$porcentaje_si = 0;
	$porcentaje_no = 0;
}

if ($id_facebook){
	$votos=mysql_query("select voto.voto from voto, usuario where id_ley=" . $ley["id"] . " and voto.id_usuario=usuario.id and usuario.id_facebook=$id_facebook", $link);
	assertNotFalse($votos);
	$voto=mysql_fetch_array($votos);
	mysql_free_result($votos);
}

$header_title = "Votamos Todos - " . $ley["titulo_lleca"];
$header_og_title = "Ley de " . $ley["titulo_lleca"];
$current_url = $site_url . $contexto . "ley/" . $url_votamostodos;
$menu_button1_label = "conocenos";
$menu_button1_url = $site_url . $contexto . "conocenos.php";


$texto_tweet = "Vot&aacute; la ley de " . $ley["titulo_lleca"];
if ($voto){
	if ($voto["voto"]){
		$texto_tweet = "Vot&eacute; a favor. Ley de " . $ley["titulo_lleca"];
	} else {
		$texto_tweet = "Vot&eacute; en contra. Ley de " . $ley["titulo_lleca"];
	}
}


include("header-html.php");

if ($votoDosVeces) {
?>
	<script>
		$(function() {
			alert("No se puede votar mas de una vez la misma ley :)");
		});	
	</script>
<?
}

if ($mostrarPopupRedesSociales) {
?>
	<script>
		$(function() {
			mostrar_ocultar_popup();
		});	
	</script>
<?
}
?>			
	<script>
		function mostrar_ocultar_popup(){
			var box_elemento = document.getElementById('popup_suscripcion').style;
			if (box_elemento.display=='' || box_elemento.display=='none')
			{
				box_elemento.display = 'block';
			}
			else
			{
				box_elemento.display = 'none';
			}
		}
	</script>
	
	<!-- box de exito -->
	<div class="PopupVoto" id="popup_suscripcion">
		<div class="boxPopup">
			<a class="link-cerrar2" href="#" onclick="mostrar_ocultar_popup();return false;"></a>
			<div class="titulo-con-fondo-chico">
				<h2>TU VOTO HA SIDO COMPUTADO, GRACIAS POR PARTICIPAR.</h2>
			</div>
			<div class="contentPopUp">
				<!--			
				<br />
				-->
				<p style="line-height: 8px;">Seguinos en Twitter</p>
				<a href="https://twitter.com/VotamosTodos" class="twitter-follow-button" data-show-count="false" data-lang="es" data-size="large">Seguir a @VotamosTodos</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
				<div class="fb-like-box" data-href="http://www.facebook.com/votamostodosargentina" data-width="292" data-show-faces="true" data-stream="false" data-header="false">
				</div>  
				<a class="link-cerrar" href="#" onclick="mostrar_ocultar_popup();return false;">Cerrar esta ventana y continuar navegando.</a> <!-- cerrar -->  
			</div>
			<!--			
			<div class="titulo-con-fondo-chico">
				<h2>COMPART&Iacute; TU VOTO</h2>
			</div>
			<div class="contentPopUp">
				<p>Compart&iacute; tu voto en Twitter</p>
  			<p>Compart&iacute; tu voto en Facebook</p>
  			<div class="twitterBanner botonCompartirPopUp">
					<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?=$url_esta_ley?>" data-text="<?=$texto_tweet?>" data-size="large" data-via="votamostodos" data-lang="es" data-dnt="true"  data-count="none">Twittear</a>
					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script> 
				</div>
				<div class="fb-like botonCompartirPopUp" data-layout="button_count" data-width="150" data-show-faces="false" data-font="arial" href="<?=$url_esta_ley?>">
				</div>
			</div>
			-->
			<hr class="clear" />
		</div>
	</div>
	<!-- fin box de exito -->
                
	<div id="contenido">
		<div class="titulo-con-fondo">
			<h2 title="<?=$ley["titulo_real"]?>">Expediente <?=$ley["expediente"]?> : <?=recortar($ley["titulo_real"],70)?></h2>
		</div>
		<div class="banner-ley">
			<div class="contenido-banner">
				<div class="banner-parte-superior">
					<h5><a target="newTab" href="<?=$ley["url_diputados"]?>">Leer el proyecto de ley</a></h5>
					<div class="redes-sociales-banner">
						<div class="fb-like" data-layout="button_count" data-width="150" data-show-faces="false" data-font="arial" href="<?=$url_esta_ley?>">
						</div>
						<div class="twitterBanner">
							<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?=$url_esta_ley?>" data-text="<?=$texto_tweet?>" data-via="votamostodos" data-lang="es" data-dnt="true"  data-count="none">Twittear</a>
							<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script> 
						</div>
					</div>
				</div>
				<h1><?=$ley["titulo_lleca"]?></h1>
				<div class="cantidad-votos">
					<?=$cant_votos?> votos
				</div>

				<form name="votarForm" action="<?=$url_esta_ley?>" method="POST">
					<input id="accion" type="hidden" name="accion"/>
				</form>
				<script>
					function votar(voto){
						FB.getLoginStatus(function(response) {
						  if (response.status === 'connected') {
								document.getElementById('accion').value = voto;
							  document.forms["votarForm"].submit();				    
						  } else {
							  FB.login( function(response) { 
								  if (response.authResponse) {
									  FB.getLoginStatus( function(response) { 
										  if (response.status === 'connected') { 
											  document.getElementById('accion').value = voto; 
											  document.forms["votarForm"].submit();
											} 
										});
									}
								}, {scope: 'email'});
							  //alert("Hay que hacer click en 'Entrar' antes de poder votar.");
							}
						});
					}
				</script>
				<?
				if ($voto){
					if ($voto["voto"]){
				?>		
						<div class="banner-botones-voto-a-favor">
							<a href="#" style="cursor: default" onclick="return false;">
								<div class="boton-positivo">
									<p><?=$porcentaje_si?>%</p>
								</div>
							</a>
							<a href="#" style="cursor: default" onclick="return false;">
								<div class="boton-negativo">
									<p><?=$porcentaje_no?>%</p>
								</div>
							</a>
						</div>								
				<?
					} else {
				?>		
						<div class="banner-botones-voto-en-contra">
							<a href="#" style="cursor: default" onclick="return false;">
								<div class="boton-positivo">
									<p><?=$porcentaje_si?>%</p>
								</div>
							</a>
							<a href="#" style="cursor: default" onclick="return false;">
								<div class="boton-negativo">
									<p><?=$porcentaje_no?>%</p>
								</div>
							</a>
						</div>								
				<?
					}
				} else {
				?>					
					<div class="banner-botones">
						<a href="#" onclick="votar('votar_si');return false;">
							<div class="boton-positivo">
								<p><?=$porcentaje_si?>%</p>
							</div>
						</a>
						<a href="#" onclick="votar('votar_no');return false;">
							<div class="boton-negativo">
								<p><?=$porcentaje_no?>%</p>
							</div>
						</a>
					</div>								
				<?
				}
				?>										
			</div>
		</div>
		<div class="comentarios">
			<div class="fb-comments" data-href="<?=$url_esta_ley?>" data-num-posts="8" data-width="600">
      </div>
		</div>
		<div class="columnaDerecha">
			<div class="fondo-otras-leyes">
				<div class="otras-leyes">
					<h4>OTRAS LEYES ACTIVAS</h4>
					<?		
					$otras_leyes=mysql_query("select * from ley where url_votamostodos<>'$url_votamostodos' and activa=true order by prioridad", $link);						
					while($otra_ley=mysql_fetch_array($otras_leyes)) {
					?>					
						<h3>
							<a href="<?=$contexto?>ley/<?=$otra_ley["url_votamostodos"]?>"><?=recortar($otra_ley["titulo_lleca"],30)?></a>
						</h3>
					<?		
					}
					mysql_free_result($otras_leyes);						
					?>						
				</div>
			</div>
			<div class="redesSocialesColumndaDerecha">
				<a href="https://twitter.com/VotamosTodos" class="twitter-follow-button" data-show-count="false" data-lang="es" data-size="large">Seguir a @VotamosTodos</a>
					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
					<div class="fb-like-box" data-href="http://www.facebook.com/votamostodosargentina" data-width="266" data-show-faces="true" data-stream="false" data-header="false">
			</div>
		</div>
		<!--    ESTE DIV ES HAY QUE HABILITARLO CUANDO SE QUIERAN PONERL LINKS        -->
		<!--
		<div class="divisor-titulo">
			<h4>Mas informacion...</h4>
		</div>
		<div class="informacion-util">
			<h3>Definicion de ley de muerte digna u ortotanasia</h3>
		</div>
		-->
	</div>
<?
include("footer.php");
?>