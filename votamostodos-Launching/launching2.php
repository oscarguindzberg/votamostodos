<?
$email = $_REQUEST["email"];
$myFile = "subscribers.txt";
$fh = fopen($myFile, 'a');
fwrite($fh, $email);
fwrite($fh, "\n");
fclose($fh);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	
	<title>Votamos Todos</title>
	<script type="text/javascript">
	
	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-32153729-1']);
	  _gaq.push(['_trackPageview']);
	
	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();
	
	</script>	
  </head>
<body>
	<div id="wrap">
		<div id="header">
			<h1>Votamos Todos democracia participativa online</h1>
			<div class="logos-redes-sociales">
				<a href="http://www.twitter.com/votamostodos"><img src="img/icon-twitter.jpg" width="30" height="30" /></a>
				<a href="http://www.facebook.com/votamostodosargentina"><img src="img/icon-facebook.jpg" width="30" height="30" /></a>
			</div>
			<div id="menu">
				<ul>
					<li>Las leyes del congreso las votamos todos</li>
				</ul>
			</div>
			<img src="img/sombraDivisorPaAbajo.jpg" width="1000" height="15" />
		</div>
		<div id="contenido">
			<div id="slideHome">
				<h3>Donde vas a poder votar las leyes del congreso al mismo tiempo que los diputados y senadores</h3>
				<div class="prezi-player"><style type="text/css" media="screen">.prezi-player { width: 550px; } .prezi-player-links { text-align: center; }</style><object id="prezi_ttpuydr-6mdf" name="prezi_ttpuydr-6mdf" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="750" height="450"><param name="movie" value="http://prezi.com/bin/preziloader.swf"/><param name="allowfullscreen" value="true"/><param name="allowscriptaccess" value="always"/><param name="bgcolor" value="#ffffff"/><param name="flashvars" value="prezi_id=ttpuydr-6mdf&amp;lock_to_path=0&amp;color=ffffff&amp;autoplay=no&amp;autohide_ctrls=0"/><embed id="preziEmbed_ttpuydr-6mdf" name="preziEmbed_ttpuydr-6mdf" src="http://prezi.com/bin/preziloader.swf" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="750" height="450" bgcolor="#ffffff" flashvars="prezi_id=ttpuydr-6mdf&amp;lock_to_path=0&amp;color=ffffff&amp;autoplay=no&amp;autohide_ctrls=0"></embed></object><div class="prezi-player-links">
					<div class="textoPrezzi">
						<a title="Presentacion votamostodos.com" href="http://prezi.com/ttpuydr-6mdf/presentacion-votamostodoscom/">Presentacion votamostodos.com</a> on <a href="http://prezi.com">Prezi</a>
					</div>
				</div>
			</div>			
		</div>
		<img src="img/sombraDivisorParriba.jpg" width="1000" height="15" />
	  <div id="buscador">
			<h3>Gracias por dejar tus datos! Pronto nos contactaremos con vos.</h3>
		</div>
		<img src="img/sombraDivisorPaAbajo.jpg" width="1000" height="15" />
	  <div id="Noticias">
			<h3></h3>
		</div>			
	</div>	  
	<div id="footer">
		<div class="textoFooter">
			Copyright © Votamos Todos
		</div>	
		<div class="textoFooterCen" style="margin-left: 110px;">	
	 		<a href="http://www.twitter.com/votamostodos"><img src="img/icon-twitter.jpg" width="30" height="30" /></a>
			<a href="http://www.facebook.com/votamostodosargentina"><img src="img/icon-facebook.jpg" width="30" height="30" /></a>
		</div>	
		<div class="textoFooterDer" style=" margin-left: 120px;">	
	 		<a href="mailto:info@votamostodos.com.ar">info@votamostodos.com.ar</a>
			</div>
		</div>
	</div>
</body>
</html>