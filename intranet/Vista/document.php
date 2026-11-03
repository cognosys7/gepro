<?php 
require_once('../Configuracion.php');
$Pagina = isset($_REQUEST['Pagina'])? $_REQUEST['Pagina'] : "";
?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
  <meta charset="UTF-8">
  <link rel="shortcut icon" href="../institucion.ico" />
  <title><?php echo PRONIED; ?></title>
  <link href="<?php echo RECURSOSPROY?>/js/viewerPDF/jquery.touchPDF.css" rel="stylesheet" media="screen" />
	<style>
		body , html{
			background-color: #404040;
			height: 100%;
			padding: 0;
			margin: 0;
		}
	</style>
</head>
<body>
<div id="myPDF" style="height: 100%; width: 100%; margin: auto;"></div>
<script type="text/javascript" src="<?php echo RECURSOSPROY?>/js/viewerPDF/pdf.compatibility.js"></script>
<script type="text/javascript" src="<?php echo RECURSOSPROY?>/js/viewerPDF/pdf.js"></script>
<script type="text/javascript" src="<?php echo RECURSOSPROY?>/js/viewerPDF/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo RECURSOSPROY?>/js/viewerPDF/jquery.touchSwipe.js"></script>
<script type="text/javascript" src="<?php echo RECURSOSPROY?>/js/viewerPDF/jquery.touchPDF.js"></script>
<script type="text/javascript" src="<?php echo RECURSOSPROY?>/js/viewerPDF/jquery.panzoom.js"></script>
<script type="text/javascript" src="<?php echo RECURSOSPROY?>/js/viewerPDF/jquery.mousewheel.js"></script>
<script type="text/javascript">
    $(function() {
        $("#myPDF").pdf( {
            source: "formatosConvenios/<?php echo $Pagina;?>.pdf"
        } );
    });
</script>
</body>
</html>