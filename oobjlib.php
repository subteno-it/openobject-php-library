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
include_once('xmlrpc.php');

/*
 * Manage the connection and calls to the OpenERP Server
 */
class openerp_connection {
	private $url, $port;

	function __construct($url='localhost', $port=8069, $dbname='demo', $username='admin', $password='admin') {
		$this->url = $url;
		$this->port = $port;
		$this->dbname = $dbname;
		$this->username = $username;
		$this->password = $password;

		// Retrieve user id
		$this->userid = $this->call('common', 'login', array($dbname, $username, $password));
	}

	public function call($component, $method, $arg=null) {
		$xmlrpc_connection = new xmlrpc_client('http://' . $this->url . '/xmlrpc/' . $component, $this->port);
		$res = $xmlrpc_connection->call($method, $arg);
		if(is_array($res) && array_key_exists('faultCode', $res)) {
			throw new Exception($res['faultCode']);
		}
		return $res;
	}
}

/*
 * Allow to call methods on OpenERP models like on every PHP objects
 */
class openerp_object {
	private $connection, $model;

	function __construct($connection, $model) {
		$this->connection = $connection;
		$this->model = $model;
	}

	public function __call($method, $arg=null) {
		$call_arg = array_merge(array($this->connection->dbname, $this->connection->userid, $this->connection->password, $this->model, $method), $arg);
		return $connection = $this->connection->call('object', 'execute', $call_arg);
	}
}
?>
