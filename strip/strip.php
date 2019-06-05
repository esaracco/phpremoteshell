#!/usr/bin/php
<?php
/*
 * Copyright (C) 2008
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

if ($argc > 1)
{
  display_help ();
  exit (0);
}

system ('php -w ../prs.php > prs.php');
$d = file_get_contents ('prs.php');
$d = preg_replace ('/<\?php  \?>/', "<?php
/* PRSDATA

*/
?>", $d);
file_put_contents ('prs.php', $d);

?>

	* Previous size was : <?php echo filesize ('../prs.php')?> bytes
	* New size is : <?php echo filesize ('prs.php')?> bytes
	* Input file was : ../prs.php
	* Output file is : ./prs.php

<?php

function display_help ()
{
?>

	Syntax: ./strip.php
	Strip PRS file for comments and spaces

<?php
}
?>
