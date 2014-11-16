<?
    require_once 'libs/google-api-php/autoload.php';



    $body = file_get_contents('php://input');
    // $file = 'log2.txt';

    // file_put_contents($file, $body);

    $headers = '';
    foreach(getallheaders() as $name => $value){
        $headers .= '(' . $name . ' - ' . $value . ') ';
    }
    // $headers = implode(", ", getallheaders());
?>
