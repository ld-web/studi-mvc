<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once 'public/index.php';

return ConsoleRunner::createHelperSet($entityManager);
