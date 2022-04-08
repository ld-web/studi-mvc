<?php

namespace App\Controller;

use Twig\Environment;

class IndexController
{
  public function home(Environment $twig)
  {
    echo $twig->render('home.html.twig');
  }

  public function contact(Environment $twig)
  {
    echo $twig->render('contact.html.twig');
  }
}
