<?php
function cabtabla() { ?>
    <div id="tablewrapper">
        <div id="tableheader">
            <div class="search" style="display: none">
                <select id="columns" onchange="sorter.search('query')">
                </select>
                <span class="details">
                    <span id="startrecord"></span>
                    <span id="endrecord"></span> 
                    <span id="totalrecords"></span>
                </span>			
            </div>
        </div>
<?php } ?>
<?php

function downtabla() { ?>
        <div id="tablefooter">
            <div id="tablenav">
                <div>
                    <img src="../Recursos/images/table/first.gif" width="16" height="16" alt="Primera Página" onclick="sorter.move(-1, true)" />
                    <img src="../Recursos/images/table/previous.gif" width="16" height="16" alt="Siguiente Página" onclick="sorter.move(-1)" />
                    <img src="../Recursos/images/table/next.gif" width="16" height="16" alt="Página Anterior" onclick="sorter.move(1)" />
                    <img src="../Recursos/images/table/last.gif" width="16" height="16" alt="Última Página" onclick="sorter.move(1, true)" />					
                </div>
                <div>
                    Ir a la P&aacute;gina <select id="pagedropdown"></select>
                </div>
            </div>
            <div id="tablelocation">
                <div class="page">P&aacute;gina <span id="currentpage"></span> de <span id="totalpages"></span></div>
            </div>
        </div>
    </div>
<?php } ?>