<?php
   include 'Net/SCP.php';
   include 'Net/SSH2.php';
   $ssh = new Net_SSH2('192.168.132.76');
   if (!$ssh->login('ftpmkey', 'P0ss1bl3')) {
       exit('bad login');
   }
   $scp = new Net_SCP($ssh);
   //$scp->put('abcd', str_repeat('x', 1024*1024));
   $scp->get('abcd','abcd');
?>