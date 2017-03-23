<?php
/**
 * Doctrine CLI bootstrap for CodeIgniter
 *
 */

define('APPPATH','C:/Users/azygm/PhpstormProjects/mct/mct/application/');
define('BASEPATH', APPPATH . '/../');
define('ENVIRONMENT', 'development');

require 'C:/Users/azygm/PhpstormProjects/mct/mct/'.'vendor/autoload.php';
require APPPATH . 'libraries/Doctrine.php';

$doctrine = new Doctrine;
$em = $doctrine->em;

$helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
));

\Doctrine\ORM\Tools\Console\ConsoleRunner::run($helperSet);

?>