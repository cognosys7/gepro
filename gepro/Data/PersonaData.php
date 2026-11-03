<?php
define('CUENTA',
"EXEC dbo.paPersona 
     @TipoAccion= 'Count'
    ,@filtro = ?"
);

define('LISTA',
"EXEC dbo.paPersona
     @TipoAccion= 'SelGrd'
    ,@rp = ?
    ,@sortname = ?
    ,@sortorder = ?
    ,@page = ?
    ,@filtro = ?
    ,@codigoMensaje = ?
    ,@Mensaje = ?
    ,@nTotal = ?
"
);

//SELECCIONAR UN REGISTRO
define('SELECCIONA',
"EXEC dbo.paPersona
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"   
);

//////MANTENIMIENTO
define('INSERTA',
"EXEC dbo.paPersona
     @TipoAccion = 'Insert'
    ,@Departamento = ?
    ,@Provincia = ?
    ,@Distrito = ?
    ,@Nombre = ?
    ,@Descipcion = ?
    ,@Sexo = ?
    ,@Estudios = ?
    ,@FechaNacimiento = ?
    ,@FechaHoraRegistro = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('ACTUALIZA',
"EXEC dbo.paPersona
     @TipoAccion = 'Update'
    ,@pCodigo = ?
    ,@Departamento = ?
    ,@Provincia = ?
    ,@Distrito = ?
    ,@Nombre = ?
    ,@Descipcion = ?
    ,@Sexo = ?
    ,@Estudios = ?
    ,@FechaNacimiento = ?
    ,@FechaHoraRegistro = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);        

define('ELIMINA',
"EXEC dbo.paPersona
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);
