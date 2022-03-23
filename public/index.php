<?php

require_once __DIR__ . '/../vendor/autoload.php';

if (
  php_sapi_name() !== 'cli' && // Pas en mode ligne de commande
  preg_match('/\.(?:png|jpg|jpeg|gif|svg|ico)$/', $_SERVER['REQUEST_URI']) // extension = asset
) {
  return false;
}

use App\Entity\User;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->loadEnv(__DIR__ . '/../.env');

$paths = ['src/Entity'];
$isDevMode = true;

$dbParams = [
  'driver'   => $_ENV['DB_DRIVER'],
  'host'     => $_ENV['DB_HOST'],
  'port'     => $_ENV['DB_PORT'],
  'user'     => $_ENV['DB_USER'],
  'password' => $_ENV['DB_PASSWORD'],
  'dbname'   => $_ENV['DB_NAME']
];

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, null, null, false);
$entityManager = EntityManager::create($dbParams, $config);

if (php_sapi_name() === 'cli') {
  return;
}

// Page
$user = new User();

$user->setName("Gray")
  ->setFirstname("Amanda")
  ->setUsername("Alex Payne")
  ->setPassword(password_hash('test', PASSWORD_BCRYPT))
  ->setEmail("mozefebid@nol.mg")
  ->setBirthDate(new DateTime('1985-05-03'));

var_dump($user);

$entityManager->persist($user);
$entityManager->flush();
