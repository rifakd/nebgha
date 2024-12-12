<?php

namespace App\Service;

use App\Repository\EvenementRepository;

class EvenementService
{
    private EvenementRepository $repository;

    public function __construct(EvenementRepository $repository)
    {
        $this->repository = $repository;
    }

    public function searchEventsByType(?string $type): array
    {
        $queryBuilder = $this->repository->createQueryBuilder('e');

        if ($type) {
            $queryBuilder->andWhere('e.type = :type')
                ->setParameter('type', $type);
        }
    
        return $queryBuilder->getQuery()->getResult();
    }
}