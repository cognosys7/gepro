<?php
function muestraVista() {
    $lCollection = Collection::Singleton();
    $PaginaFormulario = $lCollection->Get('PaginaFormulario');
    ?>
    <!--ESTILOS PARA UTILIZAR-->   
        <link href="../lib/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/> 
        <link href="../lib/css/pivot/c3.min.css" rel="stylesheet" type="text/css"/>
        <link href="../lib/css/pivot/chosen.min.css" rel="stylesheet" type="text/css"/>
        <link href="../lib/css/pivot/pivot.css" rel="stylesheet" type="text/css"/>

        <script src="../lib/js/pivot/d3.min.js" type="text/javascript"></script>
        <script src="../lib/js/query-ui/jquery.ui.touch-punch.min.js" type="text/javascript"></script>
        <script src="../lib/js/query-ui/jquery.csv-0.71.min.js" type="text/javascript"></script>
        <script src="../lib/js/query-ui/chosen.jquery.js" type="text/javascript"></script>
        <script src="../lib/js/pivot/c3.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="../lib/js/google/jsapi"></script>
        <script src="../lib/js/query-ui/jquery-ui.min.js" type="text/javascript"></script>           
        <script src="../lib/js/pivot/pivot.js" type="text/javascript"></script>
        <script src="../lib/js/pivot/export_renderers.js" type="text/javascript"></script>
        <script src="../lib/js/pivot/d3_renderers.js" type="text/javascript"></script>
        <script src="../lib/js/pivot/c3_renderers.js" type="text/javascript"></script>
        <script src="../lib/js/google/gchart_renderers.js" type="text/javascript"></script>    
    <script type="text/javascript">
        $(function () {
            $("#tabs").tabs({active: 0});         
            MostrarItemsPivot()
        });    
        function MostrarItemsPivot() {
            var renderers = $.extend(
                    $.pivotUtilities.renderers,
                    $.pivotUtilities.c3_renderers,
                    $.pivotUtilities.d3_renderers,
                    $.pivotUtilities.export_renderers
                    );
            $.getJSON("mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&Accion=MostrarItemsPivot&AccionLocal=1", function (mps) {
                $("#Tabla").pivotUI(mps, {renderers: renderers
                });
            });
        }
    </script>
    <style>
            body { font-family: Verdana; }
            .c3-line, .c3-focused {stroke-width: 3px !important;}
            .c3-bar {stroke: white !important; stroke-width: 1;}
            .c3 text { font-size: 12px; color: grey;}
            .tick line {stroke: white;}
            .c3-axis path {stroke: grey;}
            .c3-circle { opacity: 1 !important; }
    </style>
    <div class="box">
        <div class="box-content">
            <div id="tabs">
                <ul>
                    <li><a href="#tabs-2">Consulta Dinámica de Items</a></li>
                </ul>    
                <div id="tabs-2" style="overflow: auto;">                                       
                    <div id="Tabla" style="margin: 30px;" ></div>                       
                </div>  
            </div>                
        </div>                                     
    </div>      
    <br><br>
    <?php
}
?>