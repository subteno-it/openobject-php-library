<?php
/******************************************************************************
 *  OpenObject PHP Library
 *  Copyright (C) 2013 Syleam (<http://syleam.fr>). Sylvain Garancher
 *                All Rights Reserved
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as
 *  published by the Free Software Foundation, either version 3 of the
 *  License, or (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *****************************************************************************/
?>
<?php
include_once('oobjlib.php');

$url = 'localhost';
$port = 8069;
$dbname = 'demo';
$username = 'admin';
$password = 'admin';

$connection = new openerp_connection($url, $port, $dbname, $username, $password);
$users_obj = new openerp_object($connection, 'res.users');
// List all the active users ids
$user_ids = $users_obj->search(array());
print_r($user_ids);

// List the first five users, including inactives
$user_ids = $users_obj->search(array(), null, 5, 'id', array('active_test' => false));

// Display the first five users name and id
$user_data = $users_obj->read($user_ids);
foreach($user_data as $user) {
	echo $user['name'] . ' (id : ' . $user['id'] . ')' . "\n";
}
?>
