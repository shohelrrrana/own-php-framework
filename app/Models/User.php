<?php

namespace App\Models;

use Core\Database\Model;

/**
 * The RegisterModel class
 * */
class User extends Model {
	public string $table = 'users';
	public string $name;
	public string $email;
	public string $password;
	public string $confirmPassword;

	public function createUser () {
		echo 'Create new user';
	}

	public function rules () : array {
		return [
			'name'            => [ self::RULE_REQUIRED ],
			'email'           => [ self::RULE_EMAIL, self::RULE_REQUIRED ],
			'password'        => [ self::RULE_REQUIRED, [ self::RULE_MIN, 'min' => 8 ], [ self::RULE_MAX, 'max' => 24 ] ],
			'confirmPassword' => [ self::RULE_REQUIRED, [ self::RULE_MATCH, 'match' => 'password' ] ],
		];
	}
}