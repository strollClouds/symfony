<?php

namespace AdminBundle\Repository;

use AdminBundle\Entity\AdminPosition;
use Symfony\Component\HttpFoundation\Request;

/**
 * AdminRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AdminPositionRepository extends \Doctrine\ORM\EntityRepository
{
	protected $queryBuilder = null;
	protected $em = null;

	protected function mapRequest()
	{
		$this->em = $this->getEntityManager();
		$this->queryBuilder = $this->em->createQueryBuilder()->from($this->getEntityName(), 'ap');
	}

	/**
	 * 添加角色
	 * @param AdminPermission 
	 * @return int id
	 */
	public function add (AdminPosition $adminPosition)
	{	//print_r($adminPosition);die;
		$this->mapRequest();
		
		//\Doctrine\Common\Util\Debug::dump($permission);die;
		$this->em->persist($adminPosition);
		$this->em->flush();
		$this->em->clear();
		
		return $adminPosition->getId();
	}

	public function getPosition(Request $request)
	{
		$result = [];
		$this->mapRequest();
		$result['recordsTotal'] = $result['recordsFiltered'] = $this->queryBuilder->select('count(ap.id)')->getQuery()->getSingleScalarResult();

		$this->queryBuilder->select('ap');
		$this->queryBuilder->setFirstResult($request->get('start'))->setMaxResults($request->get('length'));

		$result['data'] = $this->queryBuilder->getQuery()->getArrayResult();
		return $result;
	}
}
