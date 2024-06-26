<?php

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Infrastructure\Persistence\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\Entity\Thumbnail;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\ThumbnailRepositoryInterface;

/**
 * @extends ServiceEntityRepository<Thumbnail>
 */
class ThumbnailRepository extends ServiceEntityRepository implements ThumbnailRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Thumbnail::class);
    }

    public function save(Thumbnail $thumbnail): void
    {
        $em = $this->getEntityManager();
        $em->persist($thumbnail);
        $em->flush();
    }

    public function get(int $id): ?Thumbnail
    {
        return $this->find($id);
    }

    public function update(Thumbnail $thumbnail): void
    {
        $em = $this->getEntityManager();
        $em->flush();
    }


}
