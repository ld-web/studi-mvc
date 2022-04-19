<?php

namespace App\Controller;

use Twig\Environment;

abstract class AbstractController
{
  protected Environment $twig;

  public function __construct(Environment $twig)
  {
    $this->twig = $twig;
  }
}
