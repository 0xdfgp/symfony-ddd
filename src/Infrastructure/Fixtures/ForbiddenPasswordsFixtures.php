<?php
declare(strict_types=1);

namespace App\Infrastructure\Fixtures;

use App\Domain\Safebox\ForbiddenPassword;
use App\Domain\Safebox\ForbiddenPasswordRepository;
use App\Domain\Safebox\PlainPassword;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ForbiddenPasswordsFixtures extends Fixture
{
    /**
     * @var ForbiddenPasswordRepository
     */
    private $repository;

    public function __construct(ForbiddenPasswordRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $handle = fopen(__DIR__ . '/passwords.txt', "r");

        while(($row = fgetcsv($handle)) !== FALSE) {
            $password = new ForbiddenPassword($row[0]);
            $this->repository->save($password);
        }
    }
}
