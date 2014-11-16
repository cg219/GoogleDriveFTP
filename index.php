<?
    require_once 'libs/google-api-php/autoload.php';
    require_once 'config.php';

    session_start();

    $client = new Google_Client();
    $client->setClientId(CLIENT_ID);
    $client->setClientSecret(CLIENT_SECRET);
    $client->setRedirectUri(REDIRECT_URI);
    $client->addScope('https://www.googleapis.com/auth/drive');

    $service = new Google_Service_Drive($client);

    if(isset($_GET['code'])){
        $client->authenticate($_GET['code']);
        $_SESSION['token'] = $client->getAccessToken();
        $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
        header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
    }

    if(isset($_SESSION['token']) && $_SESSION['token']){
        $client->setAccessToken($_SESSION['token']);

        if($client->isAccessTokenExpired()){
            unset($_SESSION['token']);
        }
    }
    else{
        $authURL = $client->createAuthUrl();
    }

    if($client->getAccessToken()){
        $changes = $service->changes;
        $channels = $service->channels;
        $channel = new Google_Service_Drive_Channel();
        $channel->id = "imkreative-channel-test-0218";
        $channel->type = "web_hook";
        $channel->address = "https://dev.kreativeking.com/drive2ftp/notification.php";
        $watch = $changes->watch($channel);


        echo '<pre>';
        $dup = var_dump($changes);
        echo '</pre>';
    }

    // $res = curl_exec($curl);

    // if($res){
    //     curl_close($curl);
    // }


    // print_r($res);
?>

<!doctype html>
<html>
    <head>
        <title>Drive 2 FTP</title>
    </head>
    <body>
        <? if($authURL): ?>
        <a href="<? echo $authURL; ?>">Connect</a>
        <? else: ?>
        <p>Watch</p>
        <? endif; ?>
    </body>
</html>
