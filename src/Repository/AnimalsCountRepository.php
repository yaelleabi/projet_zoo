<?php

namespace App\Repository;

use App\Document\AnimalsCount;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;
use Doctrine\ODM\MongoDB\DocumentManager;

class AnimalsCountRepository extends DocumentRepository
{
    public function findOneByAnimalId(int $id): ?AnimalsCount
    {
        return $this->findOneBy(['animalId' => $id]);
    }
    public function __construct(DocumentManager $dm)
{
    $uow = $dm->getUnitOfWork();
    $classMetaData = $dm->getClassMetadata(AnimalsCount::class);
    parent::__construct($dm, $uow, $classMetaData);
}
}
