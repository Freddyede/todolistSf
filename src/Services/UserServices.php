<?php

namespace App\Services;

use App\Abstract\AbstractService;

class UserServices extends AbstractService
{
    public function findBy(array $filter, bool $activeMany = false)
    {
        return !$activeMany
            ?
            // fn x() {...};
                // script src={{asset('assets/scripts/main.js')}}></script>
                 // link href={{asset('assets/styles/main.css')
            :
                $this->em->getRepository(AbstractService::USER_ENTITY_TARGET)->findBy($filter);
    }
}