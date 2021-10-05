<?php

namespace App\Repository;

use App\Entity\Activity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Activity|null find($id, $lockMode = null, $lockVersion = null)
 * @method Activity|null findOneBy(array $criteria, array $orderBy = null)
 * @method Activity[]    findAll()
 * @method Activity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActivityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Activity::class);
    }

    /**
     * updateActivity
     *
     * @param Activity $activity
     * @return void
     */
    public function updateActivity(Activity $activity)
    {
        try {
            $this->managet->persist($activity);
            $this->manager->flush();
        } catch (\Throwable $th) {
            throw $this->createNotFoundException(
                $th->getMessage()
            );
        }
    }

    /**
     * removeActivity
     *
     * @param Activity $activity
     * @return void
     */
    public function removeActivity(Activity $activity)
    {
        try {
            $this->managet->remove($activity);
            $this->manager->flush();
        } catch (\Throwable $th) {
            throw $this->createNotFoundException(
                $th->getMessage()
            );
        }
    }
}
