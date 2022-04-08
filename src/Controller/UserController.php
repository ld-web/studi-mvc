<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManager;
use Twig\Environment;

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

  public function list(Environment $twig, UserRepository $userRepository)
  {
    // récupérer tous les utilisateurs
    $users = $userRepository->findAll();

    // Transmettre à la vue la liste des utilisateurs à afficher
    echo $twig->render('users/list.html.twig', ['users' => $users]);
  }
}
