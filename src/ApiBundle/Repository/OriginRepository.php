<?php

namespace ApiBundle\Repository;

/**
 * OriginRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OriginRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param int|string $idOrName
     *
     * @return Origin
     */
    public function findByIdOrName($idOrName)
    {
        $query = $this->createQueryBuilder('origin');

        if (is_numeric($idOrName)) {
            $query->where('origin.id = :id_or_name');
        } else {
            $query->where('origin.name = :id_or_name');
        }

        return $query
            ->setParameter('id_or_name', $idOrName)
            ->getQuery()
            ->getSingleResult()
        ;
    }
}
