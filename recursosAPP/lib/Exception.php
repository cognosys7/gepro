<?php

/**
 * data related exceptions
 */
class DataException extends Exception{};

/**
 * error exception, converted error
 */
if (!class_exists("ErrorException")) {
	class ErrorException extends Exception{};
}

/**
 * fatal exception, converted fatal error
 */
class FatalException extends Exception{};

/**
 * globale for storing exceptionmessage
 */

$GLOBALS["gExceptionMessage"] = "";

/**
 * use a javascript popup for echoing exception
 */
function AlertException() {
    if (strlen($GLOBALS["gExceptionMessage"])) {
    ?>
    <script language="javascript" type="text/javascript">
        alert("<?php echo rtrim($GLOBALS["gExceptionMessage"]); ?>");
    </script>
    <?php
		$GLOBALS["gExceptionMessage"] = "";
    }
}

/**
 * echo exception to screen in html format
 */
function EchoException() {
    if (strlen($GLOBALS["gExceptionMessage"])) {
        echo nl2br(rtrim($GLOBALS["gExceptionMessage"]));
		$GLOBALS["gExceptionMessage"] = "";
	}
}

/**
 * Handle exception, store the exception message in a file by date and hour
 * @param @aException exception to handle
 */
function HandleException($aException) {
    // Example: Error_0115.log -> It means that the day 1 at the time 15:00 the file was geneerated
    $lFilename = PATH_LOG."/Error_".date("dH",time()).".log";
    
	if ($aException instanceof DataException) {
		if (DISPLAY_DATA_EXCEPTIONS)
			$GLOBALS["gExceptionMessage"] .= $aException->getMessage()."\r\n";
        
		if (LOG_DATA_EXCEPTIONS)
			error_log(date("d-m-Y H:i:s",time())." Data Exception: \r\n".$aException->getMessage()."\r\n".$aException->getTraceAsString()."\r\n",3,$lFilename);
	}
	else if ($aException instanceof ErrorException) {
		if (DISPLAY_ERROR_EXCEPTIONS)
			$GLOBALS["gExceptionMessage"] .= $aException->getMessage()."\r\n";
        
		if (LOG_ERROR_EXCEPTIONS)
			error_log(date("d-m-Y H:i:s",time())." Error Exception: \r\n".$aException->getMessage()."\r\n".$aException->getTraceAsString()."\r\n",3,$lFilename);
	}
	else if ($aException instanceof FatalException) {
		if (DISPLAY_FATAL_EXCEPTIONS)
			$GLOBALS["gExceptionMessage"] .= $aException->getMessage()."\r\n";
        
		if (LOG_FATAL_EXCEPTIONS)
			error_log(date("d-m-Y H:i:s",time())." Fatal Exception: \r\n".$aException->getMessage()."\r\n".$aException->getTraceAsString()."\r\n",3,$lFilename);
	}
	else
		throw $aException;
}

/**
 * Exception handler for uncaught exceptions
 * @param $aException exception to handle
 */
function UncaughtExceptionHandler($aException) {
    $lFilename = PATH_LOG."/Error_".date("dH",time()).".log";

    // En PHP 8 los errores fatales (Error) tambien llegan aqui; sin esto no quedarian en ningun log
    error_log("PHP Fatal error:  Uncaught " . get_class($aException) . ": " . $aException->getMessage()
        . " in " . $aException->getFile() . ":" . $aException->getLine());

	if (DISPLAY_UNCAUGHT_EXCEPTIONS)
		$GLOBALS["gExceptionMessage"] .= $aException->getMessage()."\r\n";
    
	if (LOG_UNCAUGHT_EXCEPTIONS)
		error_log(date("d-m-Y H:i:s",time())." Uncaught Exception: \r\n".$aException->getMessage()."\r\n".$aException->getTraceAsString()."\r\n",3,$lFilename);
}

// set exception handler for uncaught exceptions
set_exception_handler("UncaughtExceptionHandler");


/**
 * Error handler, converts error to exception
 * @param $aErrorNumber error number
 * @param $aErrorMessage error message
 * @param $aErrorFile error file, is not used
 * @param $aErrorLine error line, is not used
 * @param $aErrorContext error context, is not used
 */
function ErrorHandler($aErrorNumber, $aErrorMessage, $aErrorFile, $aErrorLine, $aErrorContext) {
	HandleException(new ErrorException($aErrorMessage,$aErrorNumber));
}

// set error handler
//set_error_handler("ErrorHandler");

// handle all errors
//error_reporting(E_ALL & ~E_NOTICE);
error_reporting(E_ALL);
//error_reporting(E_ERROR);

?>