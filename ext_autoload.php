<?php
$extensionPath = t3lib_extMgm::extPath('pb_besocial');

return array(
    'facebook'                      => $extensionPath . 'Resources/Libs/Sdk/facebook/src/facebook.php',
    'instagram'   => $extensionPath . 'Resources/Libs/Sdk/instagram/src/Instagram.php',
    'twitterAPIExchange'            => $extensionPath . 'Resources/Libs/Sdk/twitter/TwitterAPIExchange.php',
);
?>