<?php

namespace Web3\Contracts\Types;

use Web3\Contracts\Ethabi;
use Web3\Contracts\SolidityType;
use Web3\Contracts\Types\IType;

class Tuple extends SolidityType implements IType
{
	protected array $components = [];

	public function __construct()
	{
	}

	public function isType($name)
	{
		return (preg_match('/^tuple$/', $name) === 1);
	}

	public function isDynamicType()
	{
		return true;
	}

	public function setComponents(array $components)
	{
		$this->components = $components;
	}

	public function getComponents()
	{
		return $this->components;
	}

	public function inputFormat($value, $name)
	{
		if (! sizeof($this->components)) {
			throw new InvalidArgumentException('Components is required for tuple.');
		}

		$_values = array_values($value);
		$_data = [];

		foreach($this->components as $key => $type) {
			$_data[] = $_values[$key];
		}

		return $_data;
	}

	public function outputFormat($value, $name, $metadata)
	{
		$ethabi = Ethabi::factory();
		$types = $metadata['components'] ?? false;
		if (!is_array($types)) {
			throw new InvalidArgumentException('Output type is required for tuple.');
		}
		return $ethabi->decodeParameters(['outputs'=>$types], $value);
	}
}