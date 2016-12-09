<?php
namespace App;

trait IpCastTrait {
	public function asIp($value) {
		return long2ip($value);
	}

	public function fromIp($value) {
		return ip2long($value);
	}

	public function ipToArray($value) {
		return is_numeric($value) ? ip2long($value) : $value;
	}

}