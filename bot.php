<?php

$access_token = 'Mt12Kqh7r34Z1+7GWu1xjfrRuTp9CT1a7yEAuR3L44D3Y3KcF/3+A/jOdnAnksK7+B0EOCb1fK6igsICweLIIiXeg1PtyMU6R4kP/buqaoBSaOYACdr1fIywMDhNfTJEdYGlB0QShO9Ye9TRc0HIPwdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
$msg = file_get_contents("http://www.med.cmu.ac.th/eiu/eis/ODC/index.php/TIP/linebot");
$post = $msg;
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

            $temp = explode(':', $event['message']['text']);
            $num = count($temp);
            if ($num >= 1) {
                if ($temp[0] == 'mis' || $temp[0] == 'Mis') {
                    if ($num >= 2) {
                        switch ($temp[1]) {
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
                            case "kpi":
                            $text = $post;
                            $msg = [
                                    'type' => 'text',
                                    'text' => $text
                                ];
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
                }
            } else {
                $text = 'ยังไม่มีบริการในรายการนี้ ช่วยเหลือพิมพ์ "mis:?"';
            }
        }
    }
}
echo "OK";
?>
