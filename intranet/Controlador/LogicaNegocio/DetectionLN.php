<?php
require_once(PATH_LIB . "/Collection.php");
require_once(PATH_LIB . '/util.php');
function ValidaSession() 
{
    $usuariosession = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : '';
    if ($usuariosession == "") 
    {
    ?>
        <script language="JavaScript" type="text/javascript">
            top.window.location='<?php echo INTRANET."/Vista/index.php";?>';
        </script>
    <?php
    exit;
    }
}
?>