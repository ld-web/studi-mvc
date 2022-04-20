<?php

namespace App\Controller;

use App\Routing\Attribute\Route;

class IndexController extends AbstractController
{
  #[Route(path: "/", name: 'home')]
  public function home()
  {
    echo $this->twig->render('home.html.twig');
  }

  #[Route(path: "/contact", name: 'contact')]
  public function contact()
  {
    echo $this->twig->render('contact.html.twig');
  }
}
