<?php

// autoload_psr4.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'think\\oracle\\' => array($vendorDir . '/topthink/think-oracle/src'),
    'think\\mongo\\' => array($vendorDir . '/topthink/think-mongo/src'),
    'think\\migration\\' => array($vendorDir . '/topthink/think-migration/src'),
    'think\\helper\\' => array($vendorDir . '/topthink/think-helper/src'),
    'think\\composer\\' => array($vendorDir . '/topthink/think-installer/src'),
    'think\\captcha\\' => array($vendorDir . '/topthink/think-captcha/src'),
    'think\\' => array($vendorDir . '/5ini99/think-addons/src', $baseDir . '/thinkphp/library/think', $vendorDir . '/topthink/think-image/src', $vendorDir . '/topthink/think-queue/src'),
    'app\\' => array($baseDir . '/application'),
    'Phinx\\' => array($vendorDir . '/topthink/think-migration/phinx/src/Phinx'),
    'PHPMailer\\PHPMailer\\' => array($vendorDir . '/phpmailer/phpmailer/src'),
    'Hashids\\' => array($vendorDir . '/hashids/hashids/lib/Hashids'),
);