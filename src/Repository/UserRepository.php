<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    private $usersArray;

    public function __construct(RegistryInterface $registry)
    {
        // Populate array list with Users data
        $this->usersArray = [
            [
                'id' => 1,
                'email' => "test@ecommfarm.com",
            ],
            [
                'id' => 2,
                'email' => "otro@otro.com",
            ],
        ];

        parent::__construct($registry, User::class);
    }

    /*
     * Search User in Array by Id. If not Found, return false
     */
    public function getUserById(int $user_id)
    {
        foreach ($this->usersArray as $userA) {
            if($userA['id'] == $user_id) {
                // Create user
                $user = new User();
                $user->setId($userA['id']);
                $user->setEmail($userA['email']);

                return $user;
            }
        }

        return false;
    }
}
