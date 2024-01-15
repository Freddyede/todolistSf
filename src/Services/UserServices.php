<?php

namespace App\Services;

use App\Abstract\AbstractService;

class UserServices extends AbstractService
{
    public function findBy(array $filter, bool $activeMany = false)
    {
        return !$activeMany
            ?
                $this->em->getRepository(AbstractService::USER_ENTITY_TARGET)->findOneBy($filter)
            :
                $this->em->getRepository(AbstractService::USER_ENTITY_TARGET)->findBy($filter);
    }
}