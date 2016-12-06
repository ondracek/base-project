<?php

namespace App\Model;

use Kdyby\Doctrine\EntityManager,
	Kdyby\Doctrine\EntityRepository;

abstract class BaseService {

	use \Nette\SmartObject;

	/** @var EntityManager */
	protected $em;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	/**
	 *
	 * @param string $class
	 * @return EntityRepository
	 */
	protected function getRepository($class = null) {
		if(empty($class)) {
			$substr = substr(get_called_class(), 0, -7);
			$class = $substr.'Entity';
		}
		return $this->em->getRepository($class);
	}

	/**
	 *
	 * @param array|\Traversable $data
	 * @return BaseEntity
	 * @throws \InvalidStateException
	 */
	public function createNewEntity($data = array(), array $whitelist = null)
	{
		$entityName = $this->getEntityName();
		if(!class_exists($entityName)) {
			throw new \InvalidStateException;
		}
		$entity = new $entityName;
		if($data) {
			$entity->assign($data, $whitelist);
		}
		return $entity;
	}

	/**
	 *
	 * @return string
	 */
	protected function getEntityName()
	{
		$class = get_class($this);
		$entityName = substr($class, 0, -7).'Entity';
		return $entityName;
	}

	/**
	 * @param $id
	 * @return null|BaseEntity
	 */
	public function find($id) {
		return $this->getRepository()->find($id);
	}

	/**
	 * @param array $ids
	 * @return BaseEntity[]
	 */
	public function findAll(array $ids = array()) {
		if($ids) {
			return $this->getRepository()->findBy(['id' => $ids]);
		}
		else {
			return $this->getRepository()->findAll();
		}
	}

	/**
	 * @param array $criteria
	 * @param array|null $orderBy
	 * @param null $limit
	 * @param null $offset
	 * @return BaseEntity[]
	 */
	public function findAllBy(array $criteria, array $orderBy = null, $limit = null, $offset = null) {
		return $this->getRepository()->findBy($criteria, $orderBy, $limit, $offset);
	}

	/**
	 * @param array $criteria
	 * @return int
	 */
	public function count(array $criteria = array()) {
		return $this->getRepository()->countBy($criteria);
	}

	/**
	 * @param BaseEntity $entity
	 */
	public function update(BaseEntity $entity) {
		$this->em->persist($entity);
		$this->em->flush();
	}

}
