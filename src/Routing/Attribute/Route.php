<?php

namespace App\Routing\Attribute;

use Attribute;

#[Attribute]
class Route
{
  private string $name;
  private string $path;
  private string $httpMethod;

  public function __construct(
    string $path,
    string $name = "default_route",
    string $httpMethod = "GET"
  ) {
    $this->path = $path;
    $this->name = $name;
    $this->httpMethod = $httpMethod;
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function setName(string $name): self
  {
    $this->name = $name;

    return $this;
  }

  public function getPath(): string
  {
    return $this->path;
  }

  public function setPath(string $path): self
  {
    $this->path = $path;

    return $this;
  }

  public function getHttpMethod(): string
  {
    return $this->httpMethod;
  }

  public function setHttpMethod(string $httpMethod): self
  {
    $this->httpMethod = $httpMethod;

    return $this;
  }
}
