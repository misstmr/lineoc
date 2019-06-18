<?php

$access_token = 'bk8QXEX9AmGpO+x4oHu2iANUDXFbKzSXGuMImi5w/uCzpzEYo2COQF4h2+5MZIv7g7Nptoqn32mo3PUBrf0yLmFZmq0dQ60WP4JVNuR2/i1O1vk1V9S08zf6FMEpPPHQ1d1WoqnYn8HbVTbKXFMyjwdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
$msg = file_get_contents("http://www.med.cmu.ac.th/eiu/eis/ODC/index.php/TIP/sendalert");
$alert = json_decode($msg);

// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
    // Loop through each event
    foreach ($events['events'] as $event) {
        // Reply only when message sent is in 'text' format
        if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
            // Get text sent	

            $replyToken = $event['replyToken'];
            $type = $event['source']['type'];
            if ($type == 'user') {
                $replyToken = $event['source']['userId'];
            } else {
                $replyToken = $event['source']['groupId'];
            }
            
            $url = 'http://www.med.cmu.ac.th/eiu/eis/ODC/index.php/TIP/put_line_log';
            $ch = curl_init($url);
            $data = array(
                'uid' => $replyToken,
                'log' => $event['message']['text']
            );
            $payload = json_encode($data);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            $temp = json_decode($result);
            curl_close($ch);



            $login = explode('.', $event['message']['text']);
            $num = count($login);
            if ($num >= 1) {

            if ($login[0] == 'A' || $login[0] == 'a') {
                 $url = 'http://www.med.cmu.ac.th/eiu/eis/ODC/index.php/TIP/put_line_authentication';
            $ch = curl_init($url);
           $data = array(
                'uid' => $replyToken,
                'username' => $login[1],
                'password' => $login[2]
            );
            $payload = json_encode($data);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            $temp = json_decode($result);
            curl_close($ch);

            $messages = 'Authentication '."\n". $temp->name ."\n".$temp->message;
            $msg = [
                            'type' => 'text',
                            'text' => $messages
                        ];
             
                    $data = [
                        'to' => $replyToken,
                        'messages' => [$msg],
                    ];
                    $post = json_encode($data);
                    $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
                    $url = 'https://api.line.me/v2/bot/message/push';
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                    $result = curl_exec($ch);
                    curl_close($ch);

                    echo $result . "\r\n";




            }
        } 

            $kpi = $event['message']['text'];
            $num = count($kpi);
            if ($num >= 1) {
                if($kpi=='kpi' || $kpi == 'Kpi'){

              $url = 'http://www.med.cmu.ac.th/eiu/eis/ODC/index.php/TIP/put_line_uid';
            $ch = curl_init($url);
            $data = array(
                'uid' => $replyToken
            );
            $payload = json_encode($data);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            $temp = json_decode($result);
            curl_close($ch);

                           $i=0;
                           foreach ($alert as  $temp) {
                            $i++;
$code = '\xF0\x9F\x98\xA1 ';
$utf8Byte = '\xF0\x9F\x94\xB4';

$pattern = '@\\\x([0-9a-fA-F]{2})@x';
$emoji = preg_replace_callback(
  $pattern,
  function ($captures) {
    return chr(hexdec($captures[1]));
  },
  $utf8Byte
);
$msgData =  ''.$emoji.' '.$temp->kpi_id.'-'.$temp->kpi_name.'( '.$temp->kpi_value.' '.' Target='.$temp->Target2.')';
        

$post = '{
  "to" : '.$replyToken.',
  "messages" :[{
  
      "type": "text",
      "text": "'.$msgData.'"
      
  }]

}';
$msg = [
                            'type' => 'text',
                            'text' => $msgData
                        ];

 $data = [
                        'to' => $replyToken,
                        'messages' => [$messages],
                    ];
 
 $msg = [
                            'type' => 'text',
                            'text' => $msgData
                        ];
$messages = $msg;
                    $url = 'https://api.line.me/v2/bot/message/push';
                    $data = [
                        'to' => $replyToken,
                        'messages' => [$messages],
                    ];
                    $post = json_encode($data);
                    $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                    $result = curl_exec($ch);
                    curl_close($ch); 
                }
                            exit();
                }
            }
            $temp = explode(':', $event['message']['text']);
            $num = count($temp);
            if ($num >= 1) {
                if ($temp[0] == 'mis' || $temp[0] == 'Mis' || $temp[0] == 'oc' || $temp[0] == 'OC') {
                    if ($num >= 2) {
                        switch ($temp[1]) {
                            case "kpi":
                                # code...
                          
                           
                           $i=0;
                           foreach ($alert as  $temp) {
                            $i++;
$msgData =  '-->RED! '.$temp->kpi_id.'-'.$temp->kpi_name.'( '.$temp->kpi_value.' '.' Target='.$temp->Target2.')';
        

$post = '{
  "to" : '.$replyToken.',
  "messages" :[{
  
      "type": "text",
      "text": "'.$msgData.'"
      
  }]

}';
$msg = [
                            'type' => 'text',
                            'text' => $msgData
                        ];

 $data = [
                        'to' => $replyToken,
                        'messages' => [$messages],
                    ];
 /*$url = 'https://api.line.me/v2/bot/message/push';
$post = json_encode($data);
$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
$ch[$i] = curl_init($url);

curl_setopt($ch[$i],CURLOPT_HTTPHEADER,$headers);

curl_setopt($ch[$i], CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

curl_setopt($ch[$i], CURLOPT_CUSTOMREQUEST, "POST");

curl_setopt($ch[$i], CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch[$i], CURLOPT_POSTFIELDS, $post);
curl_setopt($ch[$i], CURLOPT_FOLLOWLOCATION, 1);
curl_multi_add_handle($mh, $ch[$i]); 
 } 

$running = null;
  do {
    curl_multi_exec($mh, $running);
  } while($running > 0);

   foreach($ch as $id => $c) {
    $result[$id] = curl_multi_getcontent($c);
    curl_multi_remove_handle($mh, $c);
  }
 
  curl_multi_close($mh);  */
 $msg = [
                            'type' => 'text',
                            'text' => $msgData
                        ];
$messages = $msg;
                    $url = 'https://api.line.me/v2/bot/message/push';
                    $data = [
                        'to' => $replyToken,
                        'messages' => [$messages],
                    ];
                    $post = json_encode($data);
                    $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                    $result = curl_exec($ch);
                    curl_close($ch); 
                }
                            exit();
                                break;
                            case "worktime":
                                if ($temp[2] == "it") {
                                    $msg = [
                                        'type' => 'image',
                                        'originalContentUrl' => "https://img01.rl0.ru/ca3104ec634b6092cdfd483cbcfec3d4/c1024x1024/wfiles.brothersoft.com/s/superman-logo_6968-1024x1024.jpg",
                                        'previewImageUrl' => "https://upload.wikimedia.org/wikipedia/commons/thumb/6/66/Uvsun_trace_big.jpg/240px-Uvsun_trace_big.jpg"
                                    ];
                                }

                                break;
                            case "regis":

                                $actions = [
                                    'type' => 'uri',
                                    'label' => 'Login to Register',
                                    'uri' => 'http://www.med.cmu.ac.th/eiu/eis/ci_api'
                                ];

                                $template = [
                                    'type' => 'buttons',
                                    'thumbnailImageUrl' => 'https://secure-earth-92819.herokuapp.com/login_icon.jpeg',
                                    'title' => 'ลงทะเบียน',
                                    'text' => 'ลงทะเบียน Line ID กดเบาๆ => (Login to Register)',
                                    'actions' => [$actions]
                                ];

                                $msg = [
                                    'type' => 'template',
                                    'altText' => 'MIS MED CMU LOGIN',
                                    'template' => $template
                                ];

                                break;
                            case "Regis":
                                $actions = [
                                    'type' => 'uri',
                                    'label' => 'Login to Register',
                                    'uri' => 'http://www.med.cmu.ac.th/eiu/eis/ci_api'
                                ];

                                $template = [
                                    'type' => 'buttons',
                                    'thumbnailImageUrl' => 'https://secure-earth-92819.herokuapp.com/login_icon.jpeg',
                                    'title' => 'ลงทะเบียน',
                                    'text' => 'ลงทะเบียน Line ID กดเบาๆ => (Login to Register)',
                                    'actions' => [$actions]
                                ];

                                $msg = [
                                    'type' => 'template',
                                    'altText' => 'MIS MED CMU LOGIN',
                                    'template' => $template
                                ];
                                break;
                            case "?":
                                $text = "พิมพ์ mis:regis เพื่อลงทะเบียน ตอนนี้ท่านใช้งานผ่านช่องทาง " . $type . " เป็นทางลงทะเบียนแบบ " . $type . " id คือ " . $replyToken;
                                $msg = [
                                    'type' => 'text',
                                    'text' => $text
                                ];
                                break;
                            
                            default:
                                $text = "รายการ " . $temp[1] . " ยังไม่มีบริการ";
                                $msg = [
                                    'type' => 'text',
                                    'text' => $text
                                ];
                        }
                    } else {
                        $text = 'ยังไม่มีบริการ "' . $temp[1] . '" ช่วยเหลือพิมพ์ "mis:?"';
                        $msg = [
                            'type' => 'text',
                            'text' => $text
                        ];
                    }
                    if ($temp[0] == 'id') {
                        $msg = [
                            'type' => 'text',
                            'text' => $replyToken
                        ];
                    }

                    // Get replyToken
                    //  $replyToken = $event['source']['userId'];
                    // Build message to reply back
                    $messages = $msg;




                    // Make a POST Request to Messaging API to reply to sender
                    //$url = 'https://api.line.me/v2/bot/message/reply';
                    $url = 'https://api.line.me/v2/bot/message/push';
                    $data = [
                        'to' => $replyToken,
                        'messages' => [$messages],
                    ];
                    $post = json_encode($data);
                    $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                    $result = curl_exec($ch);
                    curl_close($ch);

                    echo $result . "\r\n";
                } else {
                    $text = 'ยังไม่มีบริการในรายการนี้ ช่วยเหลือพิมพ์ "mis:?"';
                    
                    $messages = $text;
                    $url = 'https://api.line.me/v2/bot/message/push';
                    $data = [
                        'to' => $replyToken,
                        'messages' => [$messages],
                    ];
                    $post = json_encode($data);
                    $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                    $result = curl_exec($ch);
                    curl_close($ch);

                    echo $result . "\r\n";
                }
            } else {
                $text = 'ยังไม่มีบริการในรายการนี้ ช่วยเหลือพิมพ์ "mis:?"';
                $messages = $text;
                $url = 'https://api.line.me/v2/bot/message/push';
                $data = [
                    'to' => $replyToken,
                    'messages' => [$messages],
                ];
                $post = json_encode($data);
                $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                $result = curl_exec($ch);
                curl_close($ch);

                echo $result . "\r\n";
            }
        }
    }
}
print_r($alert);
foreach ($alert as  $temp) {
        # code...
    
                                                           # code...
                           
$msgData =  '[-->RED!]'.$temp->kpi_id.'-'.$temp->kpi_name.'( '.$temp->kpi_value.' '.' Target='.$temp->Target2.')';
echo $msgData.'<br>';
}
echo "OK";
?>
