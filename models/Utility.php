<?php
namespace app\models;

use Yii;

/**
 * Description of Utility
 *
 * @author kmagua
 */
class Utility {
    public static $message;
    /**
     * Pass required parameters to send Email
     * @author Kenneth Magua <kenmagua@gmail.com>
     * @param string $to recipients email name
     * @param type $subject Email's Subject
     * @param type $msg email Body
     */
    public static function sendMail($to, $subject, $msg, $cc='', $attach = '', $from = 'noreply@govmail.ke')
    {
        $message = Yii::$app->mailer->compose();
        $message->setFrom($from)
        ->setTo($to)
        ->setSubject($subject)
        ->setHtmlBody(
            $msg
        );
        if($cc){
            $message->setCc($cc);
        }
        if($attach){
            $message->attach(\Yii::$app->basePath ."/web/$attach");
        }
        $message->send();
    }
    
    /**
     * Return csv data as array
     * @author Kenneth Magua <kenmagua@gmail.com>
     * @param type $file The csv file
     * @return array
     */
    public static function csv_to_array($file)
    {
        if(!file_exists($file) || !is_readable($file)){
            return false;
        }	    
        return array_map('str_getcsv', file($file));
    }
    
    public static function generateRandomString($length = 100) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }
    
    public static function get_percentages_from_array(&$data_item, $key, $total_item_count)
    {
        $data_item = round($data_item/$total_item_count * 100, 1);
    }
    
    public static function generateMpesaAccountString($length = 6) {
        return substr(str_shuffle(str_repeat($x='ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }
    
    /**
     * 
     */
    public static function callService($data, $url)
    {
        $curl = curl_init();

        curl_setopt_array($curl,
            array(
                CURLOPT_VERBOSE => true,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_HEADER => 1,
                CURLOPT_POSTFIELDS => $data,
                //CURLOPT_FILE => $fp,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_URL => $url,
                //CURLOPT_USERPWD => 'api@ict.go.ke' . ":" . 'qco5emQfxDAU',
                CURLOPT_HTTPHEADER => array(
                  "Authorization:Basic ". base64_encode('api@ict.go.ke' . ":" . 'qco5emQfxDAU'),
                  "Cache-Control: no-cache",
                  "Content-Type: application/xml",
                ),
            )
        );

        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
          $response = "cURL Error #:" . $err;
        }else{
            $data = substr($response, strpos($response, '<data>'));
            $xml = simplexml_load_string($data);
            if(strtolower(trim($xml->field[0])) == 'success'){
                \Yii::$app->session->setFlash('webservice_result','Submitted Successfully to ICTA.');
            }else if(strtolower(trim($xml->field[0])) == 'failure'){
                \Yii::$app->session->setFlash('webservice_result','Failured when submitting to ICTA: <strong>' . $xml->field[1] . '</strong>');
            }
            return;
        }
        \Yii::$app->session->setFlash('webservice_result', $response);
        return;
    }
}
