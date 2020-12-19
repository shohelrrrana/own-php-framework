<?php

namespace Core\Database;

abstract class Model extends DB {
	/**
	 * Put all errors
	 *
	 * @var array $errors
	 */
	public array $errors = [];

	/**
	 * Define rule constants
	 */
	public const RULE_REQUIRED = 'required';
	public const RULE_EMAIL    = 'email';
	public const RULE_MIN      = 'min';
	public const RULE_MAX      = 'max';
	public const RULE_MATCH    = 'match';

	/**
	 * For register rules
	 *
	 * @return array
	 */
	abstract public function rules () : array;

	/**
	 * Load all params which get from request
	 *
	 * @param array $data
	 *
	 * @return void
	 */
	public function loadData ( array $data ) {
		foreach ( $data as $key => $value ) {
			if ( property_exists( $this, $key ) ) {
				$this->$key = $value;
			}
		}
	}

	/**
	 * Check validation and caught errors
	 *
	 * @return bool
	 */
	public function validate () {
		foreach ( $this->rules() as $fieldName => $rules ) {
			$value = $this->{$fieldName};
			foreach ( $rules as $rule ) {
				$ruleName = $rule;
				if ( ! is_string( $rule ) ) {
					$ruleName = $rule[0];
				}

				if ( $ruleName === self::RULE_REQUIRED && empty( $value ) ) {
					$this->addError( $fieldName, self::RULE_REQUIRED );
				}
				if ( $ruleName === self::RULE_EMAIL && ! filter_var( $value, FILTER_VALIDATE_EMAIL ) ) {
					$this->addError( $fieldName, self::RULE_EMAIL );
				}
				if ( $ruleName === self::RULE_MIN && strlen( $value ) < $rule['min'] ) {
					$this->addError( $fieldName, self::RULE_MIN, $rule );
				}
				if ( $ruleName === self::RULE_MAX && strlen( $value ) > $rule['max'] ) {
					$this->addError( $fieldName, self::RULE_MAX, $rule );
				}
				if ( $ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']} ) {
					$this->addError( $fieldName, self::RULE_MATCH, $rule );
				}
			}
		}

		return empty( $this->errors );
	}

	/**
	 * Add error message
	 *
	 * @param string $fieldName
	 * @param string $rule
	 * @param array $params
	 *
	 * @return  void
	 */
	private function addError ( string $fieldName, string $rule, $params = [] ) {
		$message = $this->errorMessages()[ $rule ];
		foreach ( $params as $key => $value ) {
			$message = str_replace( "{{$key}}", $value, $message );
		}
		$this->errors[ $fieldName ][] = $message;
	}

	/**
	 * Error messages
	 *
	 * @return string[]
	 */
	private function errorMessages () {
		return [
			self::RULE_REQUIRED => 'The field is required.',
			self::RULE_EMAIL    => 'The field must be a valid email.',
			self::RULE_MIN      => 'Min length of this field must be {min}.',
			self::RULE_MAX      => 'Max length of this field must be {max}.',
			self::RULE_MATCH    => 'The field must be the same as {match}.',
		];
	}

	/**
	 * Check if has error
	 *
	 * @param $fieldName
	 *
	 * @return bool
	 */
	public function hasError ( $fieldName ) {
		return isset( $this->errors[ $fieldName ] );
	}

	/**
	 * Get error by input attribute
	 *
	 * @param $fieldName
	 *
	 * @return mixed|string
	 */
	public function getError ( $fieldName ) {
		return isset( $this->errors[ $fieldName ] ) ? $this->errors[ $fieldName ] : '';
	}

	/**
	 * Get all errors
	 *
	 * @return array
	 */
	public function getErrors () {
		return $this->errors;
	}
}