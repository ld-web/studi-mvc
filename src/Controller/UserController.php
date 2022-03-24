<?php

namespace App\Controller;

use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManager;

class UserController
{
  public function create(EntityManager $em)
  {
    $user = new User();

    $user->setName("Gray")
      ->setFirstname("Amanda")
      ->setUsername("Alex Payne")
      ->setPassword(password_hash('test', PASSWORD_BCRYPT))
      ->setEmail("mozefebid@nol.mg")
      ->setBirthDate(new DateTime('1985-05-03'));

    var_dump($user);

    $em->persist($user);
    $em->flush();
  }
}
