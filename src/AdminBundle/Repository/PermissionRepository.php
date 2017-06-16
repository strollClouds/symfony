<?php

namespace AdminBundle\Repository;

use AdminBundle\Entity\Permission;
/**
 * PermissionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PermissionRepository extends \Doctrine\ORM\EntityRepository
{

	protected function mapRequest(Permission $permission)
	{
		$permission->getParent() && $permission->setParent((int)$permission->getParent());
		return $permission;
	}

	public function add (Permission $permission)
	{	
		$this->mapRequest($permission);
		$query = $this->getEntityManager();
		$query->persist($permission);
		$query->flush();
		return $permission->getId();
	}


	public function getRoot()
	{
		/*$query = $this->getEntityManager();
		$result = $this->findBy(['label' => '测试']);
		var_dump($result->getResult());*/
		$query = $this->getEntityManager()->createQueryBuilder()
		->select('p')
		->from($this->getEntityName(), 'p')
		->where('p.lv = :lv')
		->setParameter('lv', '2')
		->getQuery();
		return $query->getResult();
		//return $query->getArrayResult();
	}
}