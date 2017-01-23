<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface PersonRepository
 * @package namespace App\Repositories;
 */
interface PersonRepository extends RepositoryInterface
{
    public function legalAge($person);

    public function teen($person);

    public function tag($dateBirth);
}
