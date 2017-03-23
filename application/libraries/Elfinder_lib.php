<?php
/**
 * Created by PhpStorm.
 * User: azygm
 * Date: 16.11.2016
 * Time: 18:48
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elfinder/elFinderConnector.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elfinder/elFinder.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elfinder/elFinderVolumeDriver.class.php';
//include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elfinder/elFinderVolumeLocalFileSystem.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elfinder/elFinderVolumeFTP.class.php';

class Elfinder_lib
{
    public function __construct($opts)
    {
        $connector = new elFinderConnector(new elFinder($opts));
        $connector->run();
    }
}