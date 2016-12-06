<?php

namespace App\Model;

abstract class BaseEntity {

	/**
	 * Performs mass value assignment (using setters)
	 *
	 * @param array|\Traversable $values
	 * @param array|null $whitelist
	 * @throws \InvalidArgumentException
	 */
	public function assign($values, array $whitelist = null)
	{
		if ($whitelist !== null) {
			$whitelist = array_flip($whitelist);
		}
		if (!is_array($values) and !($values instanceof \Traversable)) {
			$givenType = gettype($values) !== 'object' ? gettype($values) : 'instance of ' . get_class($values);
			throw new \InvalidArgumentException("Argument \$values in " . get_called_class() . "::assign must contain either array or instance of Traversable, $givenType given.");
		}
		foreach ($values as $property => $value) {
			if ($whitelist === null or isset($whitelist[$property])) {
				$this->__set($property, $value);
			}
		}
	}

	/**
	 * @return array
	 */
	public function toArray() {
		$reflection = new \ReflectionClass($this);
		$details = isset($this->id) ? ['id' => $this->getId()] : [];
		foreach ($reflection->getProperties(\ReflectionProperty::IS_PROTECTED) as $property) {
			if (!$property->isStatic()) {
				$value = $this->{$property->getName()};

				if ($value instanceof IEntity) {
					$value = $value->getId();
				} elseif ($value instanceof ArrayCollection || $value instanceof PersistentCollection) {
					$value = array_map(function (BaseEntity $entity) {
						return $entity->getId();
					}, $value->toArray());
				}
				$details[$property->getName()] = $value;
			}
		}
		return $details;
	}

	/**
	 * @param string $column
	 * @param string $lang
	 * @return mixed
	 */
	public function getTranslatedColumn($column, $lang) {
		$colName = $column.ucfirst($lang);
		return $this->$colName;
	}
}
