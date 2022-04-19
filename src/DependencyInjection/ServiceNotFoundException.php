<?php

namespace App\DependencyInjection;

use Exception;
use Psr\Container\NotFoundExceptionInterface;

class ServiceNotFoundException extends Exception implements NotFoundExceptionInterface
{
  public function __construct(string $service)
  {
    $this->message = $service . " non trouvé dans le container";
  }
}
