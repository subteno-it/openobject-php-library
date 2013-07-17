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
/*
 * Simple XML-RPC client class, based on php extensions 'xmlrpc' and 'curl'
 */
class xmlrpc_client {
	private $url, $port;

	function __construct($url, $port) {
		$this->url = $url;
		$this->port = $port;
	}

	public function call($method, $arg=null) {
		$session = curl_init();

		// Do not get headers in response
		curl_setopt($session, CURLOPT_HEADER, false);
		// Send a POST query
		curl_setopt($session, CURLOPT_POST, true);
		// Return response as a string
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

		// Server information
		curl_setopt($session, CURLOPT_URL, $this->url);
		curl_setopt($session, CURLOPT_PORT, $this->port);

		// Query aguments
		curl_setopt($session, CURLOPT_POSTFIELDS, xmlrpc_encode_request($method, $arg));

		// Query execution
		$res = curl_exec($session);
		curl_close($session);

		return xmlrpc_decode($res);
	}
}
?>
