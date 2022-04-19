<?php

namespace App\Controller;

class IndexController extends AbstractController
{
  public function home()
  {
    echo $this->twig->render('home.html.twig');
  }

  public function contact()
  {
    echo $this->twig->render('contact.html.twig');
  }
}
