<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * updateUser
     *
     * @param User $user
     * @return void
     */
    public function updateUser(User $user)
    {
        try {
            $this->managet->persist($user);
            $this->manager->flush();
        } catch (\Throwable $th) {
            throw $this->createNotFoundException(
                $th->getMessage()
            );
        }
    }
}
