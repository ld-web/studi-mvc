<?php

namespace App\DependencyInjection;

use InvalidArgumentException;
use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
  private array $services = [];

  public function get(string $id)
  {
    if (!$this->has($id)) {
      throw new ServiceNotFoundException($id);
    }

    return $this->services[$id];
  }

  public function has(string $id): bool
  {
    return array_key_exists($id, $this->services);
  }

  public function set(string $id, object $service)
  {
    if ($this->has($id)) {
      throw new InvalidArgumentException("Le service $id existe déjà");
    }

    $this->services[$id] = $service;
  }
}
