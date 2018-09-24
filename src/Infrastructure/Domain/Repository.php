<?php
declare(strict_types=1);

namespace App\Infrastructure\Domain;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

abstract class Repository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repository;

    /**
     * @var EntityManager|EntityManagerInterface
     */
    private $entityManager;

    /**
     * Repository constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository($this->className());
    }

    /**
     * @return EntityRepository
     */
    protected function repository(): EntityRepository
    {
        return $this->entityManager->getRepository($this->className());
    }

    /**
     * @return EntityManager|EntityManagerInterface
     */
    protected function entityManager()
    {
        return $this->entityManager;
    }

    /**
     * @return string
     */
    abstract protected function className(): string;
}
