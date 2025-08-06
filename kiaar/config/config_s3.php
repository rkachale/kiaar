<?php
require '/var/www/html/kiaar/vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
// Bucket Name
$bucket="kiaar";

//AWS access info
// if (!defined('awsAccessKey')) define('awsAccessKey', 'AKIAIC6CYHRDHNID57QQ');
// if (!defined('awsSecretKey')) define('awsSecretKey', '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');

if (!defined('awsAccessKey')) define('awsAccessKey', 'AKIAZLQRW7NL7LPHS3UZ');
if (!defined('awsSecretKey')) define('awsSecretKey', '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');

  $client = S3Client::factory(
      array(
      'region' => 'ap-south-1',
      'version'     => '2006-03-01',
      'credentials' => array('key'=>awsAccessKey,
                'secret'=>awsSecretKey)
       )
      );
?>
