<?php

/*
	SQLyog
	Copyright 2003-2006, Webyog
    http://www.webyog.com    
    
	HTTP Tunneling Page
    
    This page exposes the MySQL API as a set of web-services which is consumed by SQLyog - the most popular GUI to MySQL.
    
    This page allows SQLyog to manage MySQL even if the MySQL port is blocked or remote access to MySQL is not allowed.
    
    By:
    Ritesh Nadhani <ritesh@webyog.com>
    Shunro Dozono <dozono@gmail.com>
    Peter Laursen <peter.laursen@webyog.com>
    Roy Varley  
    Andrey Adaikin, IVA Team, <IVATeam@gmail.com>

*/

/* PHP for PHP/MySQL tunneling */

/* check whether global variables are registered or not */
if (!get_cfg_var("register_globals")) { 
 extract($_REQUEST);
}

define ( "COMMENT_OFF", 0 );
define ( "COMMENT_HASH", 1 );
define ( "COMMENT_DASH", 2 );
define ( "COMMENT_START", 0 );

/* current element state while parsing XML received as post */

define ( "XML_NOSTATE", 0 );
define ( "XML_HOST", 1 );
define ( "XML_USER", 2 );
define ( "XML_DB", 3 );
define ( "XML_PWD", 4 );
define ( "XML_PORT", 5 );
define ( "XML_QUERY", 6 );
define ( "XML_CHARSET", 7 );

/* uncomment this line to create a debug log */
/*define ( "DEBUG", 1 );*/

/* current character in the query */
$curpos			= 0;

/* version constant */
/* You will need to change the version in processquery method too, where it shows: $versionheader = 'TunnelVersion:5.13.1' */
$tunnelversion          = '5.14';
$tunnelversionstring    = 'TunnelVersion:';
$phpversionerror        = 'PHP_VERSION_ERROR';
$phpmoduleerror         = 'PHP_MODULE_NOT_INSTALLED';

/* global variable to keep the state of current XML element */
$xml_state		= XML_NOSTATE;

/* global variables to track various informations about the query */

$host			= NULL;
$port			= NULL;
$db				= NULL;
$username		= NULL;
$pwd			= NULL;                                          
$charset        = NULL;
$batch			= 0;
$base			= 0;
$query			= NULL;

/* we stop all error reporting as we check for all sort of errors */
if ( defined("DEBUG") ) 
    error_reporting ( E_ALL );
else
    error_reporting ( 0 );

set_time_limit ( 0 );

/* we check if all the external libraries support i.e. expat and mysql in our case is built in or not */
/* if any of the libraries are not found then we show a warning and exit */

if ( AreModulesInstalled () == TRUE ) {
    WriteLog ( "Enter AreModulesInstalled" );
	ProcessQuery ();
    WriteLog ( "Exit AreModulesInstalled" );
}

function convertxmlchars ( $string )  
{   
    WriteLog ( "Enter convertxmlchars" );
    WriteLog ( "Input: " . $string );
	
    $result = $string;   
	
	$result = eregi_replace('&', '&amp;', $result);  
	$result = eregi_replace('<', '&lt;', $result);   
	$result = eregi_replace('>', '&gt;', $result);   
	$result = eregi_replace('\'', '&apos;', $result);
	$result = eregi_replace('\"', '&quot;', $result);

    WriteLog ( "Output: " . $result );
    WriteLog ( "Exit convertxmlchars" );
 
	return $result;  
}

/* we dont allow an user to connect directly to this page from a browser. It can only be accessed using SQLyog */

function ShowAccessError ()
{
	global 	$tunnelversion;

    WriteLog ( "Enter showaccesserror" );

    $errmsg  = '<p><b>Tunnel version: ' . $tunnelversion . '</b>.<p>This PHP page exposes the MySQL API as a set of webservices.<br><br>This page allows SQLyog to manage a MySQL server even if the MySQL port is blocked or remote access to MySQL is not allowed.<br><br>Visit <a href ="http://www.webyog.com">Webyog</a> to get more details about SQLyog.';

    echo ( '<html><head><title>SQLyog HTTP Tunneling</title></head><body leftmargin="0" topmargin="0"><img src="http://www.webyog.com/images/webban.jpg" alt="Webyog"><p>' );
    echo ( '<table width="100%" cellpadding="3" border="0"><tr><td><font face="Verdana" size="2">' . $errmsg . '</td</tr></table>' );

    /* we show PHP version error also if required */
    if ( CheckPHPVersion() == FALSE ) {
        echo ( '<table width="100%" cellpadding="3" border="0"><tr><td><font face="Verdana" size="2"><p><b>Error: </b>SQLyog HTTP Tunnel feature requires PHP version > 4.3.0</td></tr></table>' );
    }

    echo ( '</body></html>' );

    WriteLog ( "Exit showaccesserror" );
}

/* function checks if a required module is installed or not */

function AreModulesInstalled ()
{
	global 	$tunnelversion;
    global  $phpmoduleerror;
    global  $tunnelversionstring;

    WriteLog ( "Enter aremodulesinstalled" );

	$modules 		= get_loaded_extensions();
	$modulenotfound = '';

	if ( extension_loaded  ( "xml" ) != TRUE ) {
		$modulenotfound = 'XML';
	} else if ( extension_loaded  ( "mysql" ) != TRUE ) {
		$modulenotfound = 'MySQL';	
	} else {
		return TRUE;
	}

    if(isset($_GET['app']))
    {
        echo($tunnelversionstring);
        echo($phpmoduleerror);
        return FALSE;
    }

    $errmsg   = '<b>Error:</b> Extension <b>' . $modulenotfound . '</b> was not found compiled and loaded in the PHP interpreter. SQLyog requires this extension to work properly.';   
	$errmsg  .= '<p><b>Tunnel version: ' . $tunnelversion . '</b>.<p>This PHP page exposes the MySQL API as a set of webservices.<br><br>This page allows SQLyog to manage a MySQL server even if the MySQL port is blocked or remote access to MySQL is not allowed.<br><br>Visit <a href ="http://www.webyog.com">Webyog</a> to get more details about SQLyog.';

    echo ( '<html><head><title>SQLyog HTTP Tunneling</title></head><body leftmargin="0" topmargin="0"><img src="http://www.webyog.com/images/webban.jpg" alt="Webyog"><p>' );
    echo ( '<table width="100%" cellpadding="3" border="0"><tr><td><font face="Verdana" size="2">' . $errmsg . '</td</tr></table>' );
    echo ( '</body></html>' );

    WriteLog ( "Exit aremodulesinstalled" );
}

/* we can now use SQLyogTunnel.php to log debug informations, which will help us to point out the error */
function WriteLog ( $loginfo )
{
    if ( defined("DEBUG") ) 
    {
        $fp = fopen ( "yogtunnel.log", "a" );

        if ( $fp == FALSE )
            return;

        fwrite ( $fp, $loginfo . chr(13) );
        fclose ( $fp );
    }
}

function CheckPHPVersion()
{

    $phpversionstr  = phpversion();
    $versionarry    = explode(".", $phpversionstr, 2);

    /* We dont support v4.3.0 */
    if ( (integer)$versionarry[0] < 4 || 
         ((integer)$versionarry[0] == 4 && (integer)$versionarry[1] < 3 ))
    {
        return FALSE;
        
    } 
    else
    {
        return TRUE;
    }

    return TRUE;
}

function ProcessQuery ()
{

    global $tunnelversion;
    global $tunnelversionstring;
    global $phpversionerror;


    WriteLog ( "Enter processquery" );

    if ( CheckPHPVersion() == FALSE ) 
    {
        /*  now the call can be of three types
            1.) Specific to check tunnel version
            2.) Normal where it is expected that the PHP page is 4.3.0
            3.) From browser
            
            We check this by checking the query string which is sent if just a check is done by SQLyog */

        if(isset($_GET['app']))
        {
            echo($tunnelversionstring);
            echo($phpversionerror);
        }
        else
        {
            ShowAccessError();
        }

        return;
            
    }
    
    /* in special case, sqlyog just sends garbage data with query string to check for tunnel version. we need to process that now */
    if(isset($_GET['app']))
    {
        echo($tunnelversionstring);
        echo($tunnelversion);
        return;
    }

    /* Starting from 5.1 BETA 4, we dont get the data as URL encoded POST data, we just get it as raw data */
    $xmlrecvd = file_get_contents("php://input");

    /* Check whether the page is called from the browser */
    if ( strlen ( $xmlrecvd ) == 0 ) {
        ShowAccessError ();
        return;
    }

    WriteLog ( $xmlrecvd );

	global	$host;
	global	$port;
	global	$username;
	global	$pwd;
	global  $db;
	global 	$batch;
	global	$query;
	global	$base;

	$ret = GetDetailsFromPostedXML ( $xmlrecvd );

	if ( $ret == FALSE )
		return;

    /* connect to the mysql server */
    WriteLog ( "Trying to connect" );
	$mysql		= mysql_connect ( "$host:$port", $username, $pwd );
	if ( !$mysql )
	{
		HandleError ( mysql_errno(), mysql_error() );
        WriteLog ( mysql_error() );
		return;
	}

    WriteLog ( "Connected" );

	mysql_select_db ( str_replace ( '`', '', $db ), $mysql );

    /* Function will execute setnames in the server as it does in SQLyog client */
    SetName ( $mysql );

    /* set sql_mode to zero */
    SetNonStrictMode ( $mysql );

	if ( $batch ) {
		ExecuteBatchQuery ( $mysql, $query );
	}
	else 
		ExecuteSingleQuery ( $mysql, $query );

	mysql_close ( $mysql );

    WriteLog ( "Exit processquery" );
}

/* Start element handler for the parser */

function startElement ( $parser, $name, $attrs )
{
	global  $xml_state;
	global	$host;
	global	$port;
	global  $db;
	global	$username;
	global	$pwd;
	global 	$batch;
	global	$query;
	global	$base;

    WriteLog ( "Enter startelement" );

	if ( strtolower ( $name ) == "host" ) 
	{
		$xml_state 	= XML_HOST;
	}
	else if ( strtolower ( $name ) == "db" ) 
	{
		$xml_state	= XML_DB;
	}
    else if ( strtolower ( $name ) == "charset" ) 
    {
        WriteLog ( 'Got charset' );
        $xml_state  = XML_CHARSET;
    }
	else if ( strtolower ( $name ) == "user" ) 
	{
		$xml_state 	= XML_USER;
	}
	else if ( strtolower ( $name ) == "password" )
	{
		$xml_state	= XML_PWD;
	}
	else if ( strtolower ( $name ) == "port" )
	{
		$xml_state 	= XML_PORT;
	}
	else if ( strtolower ( $name ) == "query" )
	{
		$xml_state	= XML_QUERY;

		/* track whether the query(s) has to be processed in batch mode */
		$batch = (( $attrs['B'] == '1' )?(1):(0));
		$base  = (( $attrs['E'] == '1' )?(1):(0));  	
	}

    WriteLog ( "Exit startelement" );
}

/* End element handler for the XML parser */

function endElement ( $parser, $name )
{
    WriteLog ( "Enter endElement" );
    
    global $xml_state;
	
	$xml_state	=	XML_NOSTATE;

    WriteLog ( "Exit  endElement" );
}

/* Character data handler for the parser */

function charHandler ( $parser, $data )
{
	
	global  $xml_state;
	global	$host;
	global	$port;
	global  $db;
	global	$username;
	global	$pwd;
	global 	$batch;
	global	$query;
	global	$base;
    global  $charset;

    WriteLog ( "Enter charhandler" );

	if ( $xml_state == XML_HOST ) 
	{
		$host 		.= $data;
	}
	else if ( $xml_state == XML_DB ) 
	{
		$db 		.= $data;
	}
    else if ( $xml_state == XML_CHARSET ) 
    {
        $charset    .= $data;
    }
	else if ( $xml_state == XML_USER ) 
	{
		$username	.= $data;
	}
	else if ( $xml_state == XML_PWD )
	{
		$pwd		.= $data;
	}
	else if ( $xml_state == XML_PORT )
	{
		$port 		.= $data;
	}
	else if ( $xml_state == XML_QUERY )
	{
		if ( $base ) {
			$query		.= base64_decode ( $data );
		} else {
			$query		.= $data;	
		}
	}

    WriteLog ( "Exit charhandler" );
}

/* Parses the XML received and stores information into the variables passed as parameter */

function GetDetailsFromPostedXML ( $xmlrecvd )
{

    WriteLog ( "Enter getdetailsfrompostedxml" );

	$xml_parser		= xml_parser_create ();
	xml_set_element_handler($xml_parser, "startElement", "endElement");
	xml_set_character_data_handler ( $xml_parser, "charHandler" );

	$ret = xml_parse ( $xml_parser, $xmlrecvd );
	if ( !$ret ) 
	{
		HandleError ( xml_get_error_code ( $xml_parser ), xml_error_string ( xml_get_error_code ( $xml_parser ) ) );
		return FALSE;
	}

    xml_parser_free($xml_parser);

    WriteLog ( "Exit getdetailsfrompostedxml" );

	return TRUE;
}

/* Function writes down the correct XML for handling mysql_pconnect() error */

function HandleError ( $errno, $error )
{
	global         $tunnelversion;

    WriteLog ( "Enter handleerror" );
	
	echo "<xml v=\"" . $tunnelversion . "\"><e_i><e_n>$errno</e_n><e_d>" . convertxmlchars($error) . "</e_d></e_i></xml>";

    WriteLog ( "Exit handleerror" );
}

/* Process when only a single query is called. */

function ExecuteSingleQuery ( $mysql, $query )
{

	global			$tunnelversion;

    $result		= mysql_query ( $query, $mysql );

    WriteLog ( "Enter ExecuteSingleQuery" );

	if ( !$result ) {
		HandleError ( mysql_errno(), mysql_error() );
		return;
	}

	/* query execute was successful so we need to echo the correct xml */
	/* the query may or may not return any result */
    WriteLog ( "mysql_num_rows in ExecuteSingleQuery" );
	if ( !mysql_num_rows ( $result ) && !mysql_num_fields ( $result ) )
	{
		/* is a non-result query */
		echo "<xml v=\"" . $tunnelversion . "\">";
		echo "<e_i></e_i>";
		HandleExtraInfo ( $mysql );
		echo "<f_i c=\"0\"></f_i><r_i></r_i></xml>";
		return;
	}

	/* handle result query like SELECT,SHOW,EXPLAIN or DESCRIBE */
    echo '<xml v="' . $tunnelversion . '">';
	echo "<e_i></e_i>";
	
	/* add some extra info */
	HandleExtraInfo ( $mysql );

	/* add the field count information */
	$fieldcount		= mysql_num_fields ( $result );
	print ( $fieldcount );
	echo "<f_i c=\"$fieldcount\">";

	/* retrieve information about each fields */
	$i = 0;
	while ($i < $fieldcount ) 
	{
		$meta = mysql_fetch_field($result);

		echo "<f>";
		echo "<n>" . convertxmlchars($meta->name) . "</n>";
		echo "<t>" . convertxmlchars($meta->table) . "</t>";
		echo "<m>" . convertxmlchars($meta->max_length) . "</m>";
		echo "<d></d>";
		echo "<ty>" . GetCorrectDataType ( $result, $i ) . "</ty>";
		echo "</f>";

		$i++;
	}

	/* end field informations */
	echo "</f_i>";

	/* get information about number of rows in the resultset */
	$numrows	= mysql_num_rows ( $result );
	echo "<r_i c=\"$numrows\">";

	/* add up each row information */
	while ( $row = mysql_fetch_array ( $result ) )
	{
		$lengths = mysql_fetch_lengths ( $result );

		/* start of a row */
		echo "<r>";

		for ( $i=0; $i < $fieldcount; $i++ ) 
		{
			/* start of a col */
			echo "<c l=\"$lengths[$i]\">";

			if ( !isset($row[$i]) /*== NULL*/ ) 
			{
				echo "(NULL)";
			}
			else 
			{
				if ( mysql_field_type ( $result, $i ) == "blob" ) 
				{
					if ( $lengths[$i] == 0 ) 
					{
						echo "_";
					}
					else
					{
						echo convertxmlchars ( base64_encode ( $row[$i] ) );
					}
				}
				else
				{
					if ( $lengths[$i] == 0 ) 
					{
						echo "_";
					}
					else
					{
						echo convertxmlchars($row[$i]);	
					}
				}
			}

			/* end of a col */
			echo "</c>";
		}

		/* end of a row */
		echo "</r>";
	}

	/* close the xml output */
	echo "</r_i></xml>";
	
	/* free the result */
	mysql_free_result ( $result );

    WriteLog ( "Exit ExecuteSingleQuery" );
}

/* function finds and returns the correct type understood by MySQL C API() */

function GetCorrectDataType ( $result, $j )
{
	$data	= NULL;

    WriteLog ( "Enter GetCorrectDataType" );

	switch( mysql_field_type ( $result, $j ) )
	{
		case "int":
			if ( mysql_field_len ( $result, $j ) <= 4 )
			{
				$data = "smallint";
			}
			elseif ( mysql_field_len ( $result, $j ) <= 9 )
			{
				$data = "mediumint";
			}
			else
			{
				$data = "int";
			}
			break;
    
		case "real":
			if (mysql_field_len($result,$j) <= 10 )
			{
				$data = "float";                                             
			}
			else
			{
				$data = "double";
			}
			break;

		case "string":
			$data = "varchar";
			break;

		case "blob":
			$textblob = "TEXT";
			if ( strpos ( mysql_field_flags ($result,$j),"binary") )
			{
				$textblob = "BLOB";
			}
			if (mysql_field_len($result,$j) <= 255)
			{
				if ( $textblob == "TEXT" )
				{
                    $data = "tinytext";
                }
                else
                {
                    $data = "tinyblob";
                }
			}
			elseif (mysql_field_len($result, $j) <= 65535 )
			{
				if ( $textblob == "TEXT" ) {
                    $data = "mediumtext";
                }
                else
                {
                    $data = "mediumblob";
                }
			}
			else
			{
				if ( $textblob == "TEXT" ) {
                    $data = "longtext";
                }
                else
                {
                    $data = "longblob"; 
                }
			}
			break;

		case "date":
			$data = "date";
			break;

		case "time":
			$data = "time";
			break;

		case "datetime":
			$data = "datetime";
			break;
	}

    WriteLog ( "Exit GetCorrectDataType" );

	return (convertxmlchars($data));
}


/* Starting from SQLyog v5.1, we dont take the charset info from the server, instead SQLyog send the info 
   in the posted XML */

function SetName ( $mysql )
{

    global      $charset;

    WriteLog ( "Enter SetName" );

    if ( $charset === NULL ) 
        return;

    $query = 'SET NAMES ' . $charset;
    mysql_query ( $query, $mysql );

    WriteLog ( "Exit SetName" );

	return;
}

/* Function sets the MySQL server to non-strict mode as SQLyog is designed to work in non-strict mode */

function SetNonStrictMode ( $mysql )
{

    WriteLog ( "Enter SetNonStrictMode" );

	/* like SQLyog app we dont check the MySQL version. We just execute the statement and ignore the error if any */
    $query = "set sql_mode=''";
	$result = mysql_query ( $query, $mysql );
    if ( $result ) {
        mysql_free_result ( $result );
    }

    WriteLog ( "Exit SetNonStrictMode" );

	return;
}

/* Processes a set of queries. The queries are delimited with ;. Will return result for the last query only. */
/* If it encounters any error in between will return error values for that query */

function ExecuteBatchQuery ( $mysql, $query )
{

    WriteLog ( "Enter ExecuteBatchQuery" );

	$prev  = FALSE;
	$token = my_strtok ( $query, ";" );

	while ( $token )
	{
		$prev = $token;

		$token = my_strtok();

		if ( !$token )
		{
			return ExecuteSingleQuery ( $mysql, $prev );
		}

		$result = mysql_query ( $prev, $mysql );

		if ( !$result )  {
			return HandleError ( mysql_errno(), mysql_error() );
        }

		mysql_free_result ( $result );
	}

    WriteLog ( "Exit ExecuteBatchQuery" );

	return;
}

/* Output extra info used by SQLyog internally */

function HandleExtraInfo ( $mysql )
{

    WriteLog ( "Enter HandleExtraInfo" );

	echo "<s_v>" . mysql_get_server_info ( $mysql ) . "</s_v>";
	echo "<m_i></m_i>";
	echo "<a_r>" . mysql_affected_rows ( $mysql ) . "</a_r>";
	echo "<i_i>" . mysql_insert_id ( $mysql ) . "</i_i>";

    WriteLog ( "Exit HandleExtraInfo" );

}

/* implementation of my_strtok() in PHP */

/*
 * Description: string my_strtok(string $string, string $delimiter).
 *
 * Function my_strtok() splits a string ($string) into smaller
 * strings (tokens), with each token being delimited by the delimiter
 * string ($delimiter), considering string variables and comments
 * in the $string argument. Note that the comparision is case-insensitive.
 *
 * Returns FALSE if there are no tokens left.
 * Does not return empty tokens.
 * Does not return the "delimiter" command as a token.
 *
 * Usage:
 * The first call to my_strtok() uses the $string and $delimiter arguments.
 * Every subsequent call to my_strtok() needs no arguments at all, or only
 * the $delimiter argument to use, as it keeps track of where it is in the
 * current string. To start over, or to tokenize a new string you simply
 * call my_strtok() with the both arguments again to initialize it.
 * The delimiter can be changed by the command "delimiter new_delimiter" in
 * the $string argument (the command is case-insensitive).
 *
 * Example:
 *	$res = my_strtok($query, $delimiter);
 *	while ($res) {
 *		echo "token = $res<br>";
 *		$res = my_strtok();
 *	}
 *
 * Author: Andrey Adaikin, IVA Team, <IVATeam@gmail.com>
 * @version $Revision: 1.3 $, $Date: 2005/09/28 $
 */

function my_strtok($string = NULL, $delimiter = NULL) {

	static $str;			// lower case $string (equals to strtolower($string))
	static $str_original;	// stores $string argument
	static $len;			// length of the $string
	static $curr_pos;		// current position in the $string
	static $match_pos;		// position where the $delimiter is a substring of the $string
	static $delim;			// lower case $delimiter (equals to strtolower($delimiter))

	WriteLog ( "Enter my_strtok" );

	if (NULL === $delimiter) {
		if (NULL !== $string) {
			$delim = strtolower($string);
			$match_pos = -1;
		}
	} else {
		if (!is_string($string) || !is_string($delimiter)) {
			return FALSE;
		}
		$str_original = $string;
		$str = strtolower($str_original);
		$len = strlen($str);
		$curr_pos = 0;
		$match_pos = -1;
		$delim = strtolower($delimiter);
	}

	if ($curr_pos >= $len) {
		return FALSE;
	}

	if ("" == $delim) {
		$delim = ";";
		$match_pos = -1;
	}

	$dlen = strlen($delim);
	$result = FALSE;

	for ($i = $curr_pos; $i < $len; ++$i) {
		if ($match_pos < $i) {
			$match_pos = strpos($str, $delim, $i);
			if (FALSE === $match_pos) {
				$match_pos = $len;
			}
		}

		if ($i == $match_pos) {
			if ($i != $curr_pos) {
				$result = trim(substr($str_original, $curr_pos, $i - $curr_pos));
				if (strncasecmp($result, 'delimiter', 9) == 0 && (strlen($result) == 9 || FALSE !== strpos(" \t", $result{9}))) {
					$delim = trim(strtolower(substr($result, 10)));
					if ("" == $delim) { $delim = ";"; }
					$match_pos = -1;
					$result = FALSE;
				}
			}
			$i += $dlen;
			if ($match_pos < 0) {
				$dlen = strlen($delim);
			}
			$curr_pos = $i--;
			if ("" === $result) {
				$result = FALSE;
			}
			if (FALSE !== $result) {
				break;
			}
		} else if ($str{$i} == "'") {
			for ($j = $i+1; $j < $len; ++$j) {
				if ($str{$j} == "\\") ++$j;
				else if ($str{$j} == "'") break;
			}
			$i = $j;
		} else if ($str{$i} == "\"") {
			for ($j = $i+1; $j < $len; ++$j) {
				if ($str{$j} == "\\") ++$j;
				else if ($str{$j} == "\"") break;
			}
			$i = $j;
		} else if ($i < $len-1 && $str{$i} == "/" && $str{$i+1} == "*") {
			$j = $i+2;
			while ($j) {
				$j = strpos($str, "*/", $j);
				if (!$j || $str{$j-1} != "\\") { break; }
				++$j;
			}
			if (!$j) { break; }
			$i = $j+1;
		} else if ($str{$i} == "#") {
			$j = strpos($str, "\n", $i+1) or strpos($str, "\r", $i+1);
			if (!$j) { break; }
			$i = $j;
		} else if ($i < $len-2 && $str{$i} == "-" && $str{$i+1} == "-" && FALSE !== strpos(" \t", $str{$i+2})) {
			$j = strpos($str, "\n", $i+3) or strpos($str, "\r", $i+1);
			if (!$j) { break; }
			$i = $j;
		} else if ($str{$i} == "\\") {
			++$i;
		}
	}

	if (FALSE === $result && $curr_pos < $len) {
		$result = trim(substr($str_original, $curr_pos));
		if (strncasecmp($result, 'delimiter', 9) == 0 && (strlen($result) == 9 || FALSE !== strpos(" \t", $result{9}))) {
			$delim = trim(strtolower(substr($result, 10)));
			if ("" == $delim) { $delim = ";"; }
			$match_pos = -1;
			$dlen = strlen($delim);
			$result = FALSE;
		}
		$curr_pos = $len;
		if ("" === $result) {
			$result = FALSE;
		}
	}

	WriteLog ( "Exit my_strtok" );

	return $result;
}
?>
