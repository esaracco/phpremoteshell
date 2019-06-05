#!/usr/bin/php
<?php
/*
 * Copyright (C) 2005-2019
 * Emmanuel Saracco <emmanuel@esaracco.fr>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330,
 * Boston, MA 02111-1307, USA.
 */

if ($argc < 2)
{
  display_help ();
  exit (0);
}

$k = $argv[1];
system ('../strip/strip.php >/dev/null');
rename ('prs.php', 'prs-stripped.php');
$data = file_get_contents ('prs-stripped.php');
$data = preg_replace ('#^\s*<\?(php)?#', '', $data);
$data = preg_replace ('#\?>\s*$#', '', $data);
$data = encrypt ($data, $k);
$data = '@eval(decrypt(base64_decode("'.base64_encode($data).'"),rtrim((isset($_POST["cryptkey"]))?$_POST["cryptkey"]:$argv[3])));function keyED($txt,$encrypt_key){$encrypt_key = md5($encrypt_key);$ctr=0;$tmp=\'\';for ($i=0;$i<strlen($txt);$i++){if($ctr==strlen($encrypt_key))$ctr=0;$tmp.=substr($txt,$i,1)^substr($encrypt_key,$ctr,1);$ctr++;}return $tmp;}function decrypt($txt,$key){$txt=keyED($txt,$key);$tmp=\'\';for($i=0;$i<strlen($txt);$i++){$md5 = substr($txt,$i,1);$i++;$tmp.=(substr($txt,$i,1)^$md5);}return $tmp;}';

$data = '<?php error_reporting(0); ini_set(\'display_errors\', 0); if (php_sapi_name () != \'cli\' && $_SERVER[\'REQUEST_METHOD\']!=\'POST\'){header (\'HTTP/1.1 404 Not Found\');print"<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\"><html><head><title>404 Not Found</title></head><body><h1>Not Found</h1><p>The requested URL {$_SERVER[\'REQUEST_URI\']} was not found on this server.</p><hr>{$_SERVER[\'SERVER_SIGNATURE\']}</body></html>";exit ();} @eval(@base64_decode("' . base64_encode ($data) . '")) ?>';
file_put_contents ('prs.php', $data);
unlink ('prs-stripped.php');
?>

	* Given key was  : <?php echo $k?> 
	* Input file was : ../prs.php
	* Output file is : ./prs.php

	File has been stripped before being encrypted.

	Use the "launcher.html" HTML page to request PRS encrypted file.
	Just open it in a Web browser.

<?php

function display_help ()
{
?>

	Syntax: ./crypt.php KEY
	Encrypt PRS file with the given key

	Encrypted file should be uploaded on a server and requested using POST 
	method to submit the key used for encryption. 
	Once the file has been encrypted you can use the "launcher.html" HTML
	page to request it. Just open it in a Web browser.

<?php
}

function encrypt ($txt, $key) 
{ 
  srand ((double) microtime () * 1000000); 
  $encrypt_key = md5 (rand (0,32000)); 
  $ctr = 0; 
  $tmp = ''; 
  for ($i = 0; $i < strlen ($txt); $i++) 
  { 
    if ($ctr == strlen ($encrypt_key)) $ctr = 0; 
    $tmp.= substr($encrypt_key, $ctr, 1) .
                  (substr ($txt, $i, 1) ^ substr ($encrypt_key, $ctr, 1)); 
    $ctr++; 
  } 
  return keyED ($tmp, $key); 
}

function keyED ($txt, $encrypt_key) 
{ 
  $encrypt_key = md5 ($encrypt_key); 
  $ctr = 0; 
  $tmp = ''; 
  for ($i = 0; $i < strlen ($txt); $i++) 
  { 
    if ($ctr == strlen ($encrypt_key)) $ctr = 0; 
    $tmp .= substr ($txt, $i, 1) ^ substr ($encrypt_key, $ctr, 1); 
    $ctr++; 
  } 
  return $tmp; 
}
?>
