<?php

class integBX24
{

    public $auth = array(
        'domain' => 'avtogorod43.bitrix24.ru',
        'access_token' => 'lmku10n5ao4l9lv0'
    );

    public $queryUrl = 'https://avtogorod43.bitrix24.ru/rest/22/lmku10n5ao4l9lv0/';

    public function getData($method, $params)
    {
        $auth = $this->auth;
        $c = curl_init('https://' . $auth['domain'] . '/rest/22/' . $auth['access_token'] . '/' . $method);
        $params["auth"] = $auth["access_token"];
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_POST, true);
        curl_setopt($c, CURLOPT_POSTFIELDS, http_build_query($params));
        $response = curl_exec($c);
        $response = json_decode($response, true);
        echo '<pre>';
        print_r($response['result']);
    }

//    Лиды

    public function addLead() {

        define('CRM_HOST', 'avtogorod43.bitrix24.ru');
        define('CRM_PORT', '443');
        define('CRM_PATH', '/crm/configs/import/lead.php');
        define('CRM_LOGIN', 'uda78@yandex.ru');
        define('CRM_PASSWORD', 'dyewhnxnkgavgscx');

        $postData = array(
            'TITLE' => 'Добавлен заявка №' . $_POST['id'],
            'UF_CRM_1529585224' => $_POST['date'],
            'UF_CRM_1529585335' => $_POST['time'],
            'UF_CRM_1529585403' => $_POST['gruz'],
            'UF_CRM_1529863399' => $_POST['path'],
            'UF_CRM_1529585592' => $_POST['deadline'],
            'COMPANY_TITLE' => $_POST['zakaz'],
            'NAME' => $_POST['contact'],
            'PHONE_MOBILE' => $_POST['tel'],
            'UF_CRM_1512545867' => $_POST['gortel'],
            'UF_CRM_1529585800' => $_POST['disp'],
            'UF_CRM_1529585885' => $_POST['marka'],
            //'UF_CRM_1529585907' => $_POST['pricep'],
            'COMMENTS' => $_POST['comment'],
            //'UF_CRM_1529607515' => $_POST['perevoz'],
            'UF_CRM_1529607569' => $_POST['summaper'],
            'UF_CRM_1529607719' => $_POST['obkm'],
            'UF_CRM_1529607766' => $_POST['stavkakubm'],
            'UF_CRM_1529607798' => $_POST['kolkubm'],
            'UF_CRM_1529586033' => $_POST['ch'],
            'UF_CRM_1529586054' => $_POST['stavkach'],
            'UF_CRM_1529586073' => $_POST['km'],
            'UF_CRM_1529586097' => $_POST['stavkakm'],
            'UF_CRM_1529586229' => $_POST['money'],
            'UF_CRM_1529587820' => $_POST['money2'],
            'UF_CRM_1529587836' => $_POST['money3'],
            'OPPORTINUTY' => $_POST['summa'],
            'UF_CRM_1529586259' => $_POST['combuh'],
            "SOURCE_ID" => "SELF",
            "STATUS_ID" => "NEW",
        );

        // добавляем в массив параметры авторизации
        if (defined('CRM_AUTH')) {
            $postData['AUTH'] = CRM_AUTH;
        } else {
            $postData['LOGIN'] = CRM_LOGIN;
            $postData['PASSWORD'] = CRM_PASSWORD;
        }

        // открываем сокет соединения к облачной CRM
        $fp = fsockopen("ssl://".CRM_HOST, CRM_PORT, $errno, $errstr, 30);
        if ($fp) {
            // производим URL-кодирование строки
            $strPostData = '';
            foreach ($postData as $key => $value)
                $strPostData .= ($strPostData == '' ? '' : '&').$key.'='.urlencode($value);

            // подготавливаем заголовки
            $str = "POST ".CRM_PATH." HTTP/1.0\r\n";
            $str .= "Host: ".CRM_HOST."\r\n";
            $str .= "Content-Type: application/x-www-form-urlencoded\r\n";
            $str .= "Content-Length: ".strlen($strPostData)."\r\n";
            $str .= "Connection: close\r\n\r\n";

            $str .= $strPostData;

            fwrite($fp, $str);

            $result = '';
            while (!feof($fp))
            {
                $result .= fgets($fp, 128);
            }
            fclose($fp);

            //Получение ID
            $response = explode("\r\n\r\n", $result);
            $json_in = array("{'", "'}", "':'", "','");
            $json_out = array('{"', '"}', '":"', '","');
            $json = str_replace($json_in, $json_out, $response[1]);
            $json_arr = json_decode($json, true);
//            echo '<pre>';
//                var_dump($json_arr);
//            echo '</pre>';
            return $json_arr['ID'];

        } else {
            //echo 'Не удалось подключиться к CRM '.$errstr.' ('.$errno.')';
        }

    }

    public function updLead($fields) {

        $id = $fields['bxlead'];
        $method = 'crm.deal.update.json';
        $title = "Обновление сделки";

        $postData = [
            'UF_CRM_1529862242' => $fields['id'],
            'TITLE' => $title,
            'UF_CRM_1529585224' => $fields['date'],
            'UF_CRM_1529585335' => $fields['time'],
            'UF_CRM_1529585403' => $fields['gruz'],
            'UF_CRM_1529585419' => $fields['path'],
            'UF_CRM_1529585592' => $fields['deadline'],
            'COMPANY_TITLE' => $fields['zakaz'],
            'NAME' => $fields['contact'],
            'PHONE_MOBILE' => $fields['tel'],
            'UF_CRM_1512545867' => $fields['gortel'],
            'UF_CRM_1529585800' => $fields['disp'],
            'UF_CRM_1529585885' => $fields['marka'],
            //'UF_CRM_1529585907' => $fields['pricep'],
            'COMMENTS' => $fields['comment'],
            'UF_CRM_1529607515' => $fields['perevoz'],
            'UF_CRM_1529607569' => $fields['summaper'],
            'UF_CRM_1529607719' => $fields['obkm'],
            'UF_CRM_1529607766' => $fields['stavkakubm'],
            'UF_CRM_1529607798' => $fields['kolkubm'],
            'UF_CRM_1529586033' => $fields['ch'],
            'UF_CRM_1529586054' => $fields['stavkach'],
            'UF_CRM_1529586073' => $fields['km'],
            'UF_CRM_1529586097' => $fields['stavkakm'],
            'UF_CRM_1529586229' => $fields['money'],
            'UF_CRM_1529587820' => $fields['money2'],
            'UF_CRM_1529587836' => $fields['money3'],
            'OPPORTUNITY' => $fields['summa'],
            'UF_CRM_1529586259' => $fields['combuh']
        ];

        $queryData = http_build_query([
                'ID' => $id,
                'fields' => $postData,
                'params' => [
                    "REGISTER_SONET_EVENT" => "Y"
                ]
            ]
        );
        $curl = curl_init();
        curl_setopt_array($curl,
            [
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_POST => 1,
                CURLOPT_HEADER => 0,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $this->queryUrl . $method,
                CURLOPT_POSTFIELDS => $queryData,
            ]
        );
        $result = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($result, 1);

        if (isset($result)) {

            //print_r($result);

            if (array_key_exists('error', $result)) {
                echo "Ошибка при сохранении лида: " . $result['error_description'] . " ";
            }
        }
    }

    public function updLeadID($fields) {

        $id = $fields['lead_id'];
        $title = 'Обновление ID лида';
        $method = 'crm.lead.update.json';

        $postData = [
            'TITLE' => $title,
            'CONTACT_ID' => $fields['cont_id'],
            'COMPANY_ID' => $fields['comp_id'],
        ];

        $queryData = http_build_query([
                'ID' => $id,
                'fields' => $postData,
                'params' => array(
                    "REGISTER_SONET_EVENT" => "Y"
                )
            ]
        );
        $curl = curl_init();
        curl_setopt_array($curl,
            [
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_POST => 1,
                CURLOPT_HEADER => 0,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $this->queryUrl . $method,
                CURLOPT_POSTFIELDS => $queryData,
            ]
        );
        $result = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($result, 1);

        if (isset($result)) {
            print_r($result);
            if (array_key_exists('error', $result)) {
                echo "Ошибка при сохранении лида: " . $result['error_description'] . " ";
            }
            return $result['result'];
        }

    }

//  Сделки

    public function addDeal($fields) {

        $title = 'Новая сделка';
        $method = 'crm.deal.add.json';

        $postData = [
            'TITLE' => $title,
            'LEAD_ID' => $fields['bxlead'],
            'COMPANY_ID' => $fields['bxcompany'],
            'CONTACT_ID' => $fields['bxcontact'],
            'UF_CRM_1529585224' => $fields['date'],
            'UF_CRM_1529585335' => $fields['time'],
            'UF_CRM_1529585403' => $fields['gruz'],
            'UF_CRM_1529585419' => $fields['path'],
            'UF_CRM_1529585592' => $fields['deadline'],
            'COMPANY_TITLE' => $fields['zakaz'],
            'NAME' => $fields['contact'],
            'PHONE_MOBILE' => $fields['tel'],
            'UF_CRM_5A4E137D5753A' => $fields['gortel'],
            'UF_CRM_1529585800' => $fields['disp'],
            'UF_CRM_1529585885' => $fields['marka'],
            //'UF_CRM_1529585907' => $fields['pricep'],
            'COMMENTS' => $fields['comment'],
            //'UF_CRM_1529607515' => $fields['perevoz'],
            'UF_CRM_1529607569' => $fields['summaper'],
            'UF_CRM_1529607719' => $fields['obkm'],
            'UF_CRM_1529607766' => $fields['stavkakubm'],
            'UF_CRM_1529607798' => $fields['kolkubm'],
            'UF_CRM_1529586033' => $fields['ch'],
            'UF_CRM_1529586054' => $fields['stavkach'],
            'UF_CRM_1529586073' => $fields['km'],
            'UF_CRM_1529586097' => $fields['stavkakm'],
            'UF_CRM_1529586229' => $fields['money'],
            'UF_CRM_1529587820' => $fields['money2'],
            'UF_CRM_1529587836' => $fields['money3'],
            'OPPORTUNITY' => $fields['summa'],
            'UF_CRM_1529586259' => $fields['combuh']
        ];

        $queryData = http_build_query([
                'fields' => $postData,
                'params' => array(
                    "REGISTER_SONET_EVENT" => "Y"
                )
            ]
        );
        $curl = curl_init();
        curl_setopt_array($curl,
            [
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_POST => 1,
                CURLOPT_HEADER => 0,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $this->queryUrl . $method,
                CURLOPT_POSTFIELDS => $queryData,
            ]
        );
        $result = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($result, 1);

        if (isset($result)) {

            //print_r($result);

            if (array_key_exists('error', $result)) {
                echo "Ошибка при сохранении лида: " . $result['error_description'] . " ";
            }
            return $result['result'];
        }

    }

    public function updDeal($fields) {

        $id = $fields['bxdeal'];
        $method = 'crm.deal.update.json';
        $title = "Обновление сделки";

        $postData = [
            'UF_CRM_1529862242' => $fields['id'],
            'TITLE' => $title,
            'UF_CRM_1529585224' => $fields['date'],
            'UF_CRM_1529585335' => $fields['time'],
            'UF_CRM_1529585403' => $fields['gruz'],
            'UF_CRM_1529585419' => $fields['path'],
            'UF_CRM_1529585592' => $fields['deadline'],
            'COMPANY_TITLE' => $fields['zakaz'],
            'NAME' => $fields['contact'],
            'PHONE_MOBILE' => $fields['tel'],
            'UF_CRM_5A4E137D5753A' => $fields['gortel'],
            'UF_CRM_1529585800' => $fields['disp'],
            'UF_CRM_1529585885' => $fields['marka'],
            //'UF_CRM_1529585907' => $fields['pricep'],
            'COMMENTS' => $fields['comment'],
            'UF_CRM_1529607515' => $fields['perevoz'],
            'UF_CRM_1529607569' => $fields['summaper'],
            'UF_CRM_1529607719' => $fields['obkm'],
            'UF_CRM_1529607766' => $fields['stavkakubm'],
            'UF_CRM_1529607798' => $fields['kolkubm'],
            'UF_CRM_1529586033' => $fields['ch'],
            'UF_CRM_1529586054' => $fields['stavkach'],
            'UF_CRM_1529586073' => $fields['km'],
            'UF_CRM_1529586097' => $fields['stavkakm'],
            'UF_CRM_1529586229' => $fields['money'],
            'UF_CRM_1529587820' => $fields['money2'],
            'UF_CRM_1529587836' => $fields['money3'],
            'OPPORTUNITY' => $fields['summa'],
            'UF_CRM_1529586259' => $fields['combuh']
        ];

        $queryData = http_build_query([
                'ID' => $id,
                'fields' => $postData,
                'params' => [
                    "REGISTER_SONET_EVENT" => "Y"
                ]
            ]
        );
        $curl = curl_init();
        curl_setopt_array($curl,
            [
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_POST => 1,
                CURLOPT_HEADER => 0,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $this->queryUrl . $method,
                CURLOPT_POSTFIELDS => $queryData,
            ]
        );
        $result = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($result, 1);

        if (isset($result)) {

            //print_r($result);

            if (array_key_exists('error', $result)) {
                echo "Ошибка при сохранении лида: " . $result['error_description'] . " ";
            }
        }
    }

    public function updDealID($fields) {

        $id = $fields['deal_id'];
        $title = 'Обновление ID';
        $method = 'crm.deal.update.json';

        $postData = [
            'TITLE' => $title,
            'CONTACT_ID' => $fields['cont_id'],
            'COMPANY_ID' => $fields['comp_id'],
            'LEAD_ID' => $fields['lead_id'],
        ];

        $queryData = http_build_query([
                'ID' => $id,
                'fields' => $postData,
                'params' => array(
                    "REGISTER_SONET_EVENT" => "Y"
                )
            ]
        );
        $curl = curl_init();
        curl_setopt_array($curl,
            [
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_POST => 1,
                CURLOPT_HEADER => 0,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $this->queryUrl . $method,
                CURLOPT_POSTFIELDS => $queryData,
            ]
        );
        $result = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($result, 1);

        if (isset($result)) {
            print_r($result);
            if (array_key_exists('error', $result)) {
                echo "Ошибка при сохранении лида: " . $result['error_description'] . " ";
            }
            return $result['result'];
        }

    }

    public function delDeal($id) {

        $method = 'crm.lead.delete.json';
        $queryData = http_build_query([
                'ID' => $id
            ]
        );
        $curl = curl_init();
        curl_setopt_array($curl,
            [
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_POST => 1,
                CURLOPT_HEADER => 0,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $this->queryUrl . $method,
                CURLOPT_POSTFIELDS => $queryData,
            ]
        );
        $result = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($result, 1);

        if (isset($result)) {

            if (array_key_exists('error', $result)) {
                echo "Ошибка при удалении лида: " . $result['error_description'] . " ";
            }
        }
    }

// Контакты

    public function addContact($fields) {

        $title = 'Новый контакт';
        $method = 'crm.contact.add.json';

        $postData = [
            //'UF_CRM_1529862242' => $fields['id'],
            'TITLE' => $title,
            'UF_CRM_1529585224' => $fields['date'],
            'UF_CRM_1529585335' => $fields['time'],
            'UF_CRM_1529585403' => $fields['gruz'],
            'UF_CRM_1529585419' => $fields['path'],
            'UF_CRM_1529585592' => $fields['deadline'],
            'COMPANY_TITLE' => $fields['zakaz'],
            'NAME' => $fields['contact'],
            'PHONE_MOBILE' => $fields['tel'],
            'UF_CRM_5A2B9BF52BA29' => $fields['gortel'],
            'UF_CRM_1529585800' => $fields['disp'],
            'UF_CRM_1529585885' => $fields['marka'],
            //'UF_CRM_1529585907' => $fields['pricep'],
            'COMMENTS' => $fields['comment'],
            //'UF_CRM_1529607515' => $fields['perevoz'],
            'UF_CRM_1529607569' => $fields['summaper'],
            'UF_CRM_1529607719' => $fields['obkm'],
            'UF_CRM_1529607766' => $fields['stavkakubm'],
            'UF_CRM_1529607798' => $fields['kolkubm'],
            'UF_CRM_1529586033' => $fields['ch'],
            'UF_CRM_1529586054' => $fields['stavkach'],
            'UF_CRM_1529586073' => $fields['km'],
            'UF_CRM_1529586097' => $fields['stavkakm'],
            'UF_CRM_1529586229' => $fields['money'],
            'UF_CRM_1529587820' => $fields['money2'],
            'UF_CRM_1529587836' => $fields['money3'],
            'OPPORTUNITY' => $fields['summa'],
            'UF_CRM_1529586259' => $fields['combuh']
        ];

        $queryData = http_build_query([
                'fields' => $postData,
                'params' => array(
                    "REGISTER_SONET_EVENT" => "Y"
                )
            ]
        );
        $curl = curl_init();
        curl_setopt_array($curl,
            [
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_POST => 1,
                CURLOPT_HEADER => 0,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $this->queryUrl . $method,
                CURLOPT_POSTFIELDS => $queryData,
            ]
        );
        $result = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($result, 1);

        if (isset($result)) {

            //print_r($result);

            if (array_key_exists('error', $result)) {
                echo "Ошибка при сохранении лида: " . $result['error_description'] . " ";
            }
            return $result['result'];
        }

    }

    public function updContact($fields) {

        $id = $fields['bxcont'];
        $method = 'crm.contact.update.json';

        $postData = [
            //'UF_CRM_1529862242' => $fields['id'],
            'TITLE' => $fields['contact'],
            'SECOND_NAME' => $fields['zakaz'],
            'LAST_NAME' => $fields['contact'],
            'UF_CRM_1529585224' => $fields['date'],
            'UF_CRM_1529585335' => $fields['time'],
            'UF_CRM_1529585403' => $fields['gruz'],
            'UF_CRM_1529585419' => $fields['path'],
            'UF_CRM_1529585592' => $fields['deadline'],
            'COMPANY_TITLE' => $fields['zakaz'],
            'NAME' => $fields['contact'],
            'PHONE_MOBILE' => $fields['tel'],
            'UF_CRM_5A2B9BF52BA29' => $fields['gortel'],
            'UF_CRM_1529585800' => $fields['disp'],
            'UF_CRM_1529585885' => $fields['marka'],
            //'UF_CRM_1529585907' => $fields['pricep'],
            'COMMENTS' => $fields['comment'],
            'UF_CRM_1529607515' => $fields['perevoz'],
            'UF_CRM_1529607569' => $fields['summaper'],
            'UF_CRM_1529607719' => $fields['obkm'],
            'UF_CRM_1529607766' => $fields['stavkakubm'],
            'UF_CRM_1529607798' => $fields['kolkubm'],
            'UF_CRM_1529586033' => $fields['ch'],
            'UF_CRM_1529586054' => $fields['stavkach'],
            'UF_CRM_1529586073' => $fields['km'],
            'UF_CRM_1529586097' => $fields['stavkakm'],
            'UF_CRM_1529586229' => $fields['money'],
            'UF_CRM_1529587820' => $fields['money2'],
            'UF_CRM_1529587836' => $fields['money3'],
            'OPPORTUNITY' => $fields['summa'],
            'UF_CRM_1529586259' => $fields['combuh']
        ];

        $queryData = http_build_query([
                'ID' => $id,
                'fields' => $postData,
                'params' => array(
                    "REGISTER_SONET_EVENT" => "Y"
                )
            ]
        );
        $curl = curl_init();
        curl_setopt_array($curl,
            [
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_POST => 1,
                CURLOPT_HEADER => 0,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $this->queryUrl . $method,
                CURLOPT_POSTFIELDS => $queryData,
            ]
        );
        $result = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($result, 1);

        if (isset($result)) {

            //print_r($result);

            if (array_key_exists('error', $result)) {
                echo "Ошибка при сохранении лида: " . $result['error_description'] . " ";
            }
            return $result['result'];
        }

    }

    public function updContactID($fields) {

        $id = $fields['cont_id'];
        $title = 'Обновление ID';
        $method = 'crm.contact.update.json';

        $postData = [
            'TITLE' => $title,
            'CONTACT_ID' => $fields['cont_id'],
            'COMPANY_ID' => $fields['comp_id'],
            'UF_CRM_5A2B9BF52BA29' => $fields['tel2'],
        ];

        $queryData = http_build_query([
                'ID' => $id,
                'fields' => $postData,
                'params' => array(
                    "REGISTER_SONET_EVENT" => "Y"
                )
            ]
        );
        $curl = curl_init();
        curl_setopt_array($curl,
            [
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_POST => 1,
                CURLOPT_HEADER => 0,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $this->queryUrl . $method,
                CURLOPT_POSTFIELDS => $queryData,
            ]
        );
        $result = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($result, 1);

        if (isset($result)) {
            print_r($result);
            if (array_key_exists('error', $result)) {
                echo "Ошибка при сохранении лида: " . $result['error_description'] . " ";
            }
            return $result['result'];
        }

    }

// Компания

    public function addCompany($fields) {

        //$title = 'Новая компания';
        $method = 'crm.company.add.json';

        $postData = [
            //'UF_CRM_1529862242' => $fields['id'],
            'TITLE' => $fields['zakaz'],
            'UF_CRM_1529585224' => $fields['date'],
            'UF_CRM_1529585335' => $fields['time'],
            'UF_CRM_1529585403' => $fields['gruz'],
            'UF_CRM_1529585419' => $fields['path'],
            'UF_CRM_1529585592' => $fields['deadline'],
            'COMPANY_TITLE' => $fields['zakaz'],
            'NAME' => $fields['contact'],
            'PHONE_MOBILE' => $fields['tel'],
            'PHONE_WORK' => $fields['gortel'],
            'UF_CRM_1529585800' => $fields['disp'],
            'UF_CRM_1529585885' => $fields['marka'],
            //'UF_CRM_1529585907' => $fields['pricep'],
            'COMMENTS' => $fields['comment'],
            //'UF_CRM_1529607515' => $fields['perevoz'],
            'UF_CRM_1529607569' => $fields['summaper'],
            'UF_CRM_1529607719' => $fields['obkm'],
            'UF_CRM_1529607766' => $fields['stavkakubm'],
            'UF_CRM_1529607798' => $fields['kolkubm'],
            'UF_CRM_1529586033' => $fields['ch'],
            'UF_CRM_1529586054' => $fields['stavkach'],
            'UF_CRM_1529586073' => $fields['km'],
            'UF_CRM_1529586097' => $fields['stavkakm'],
            'UF_CRM_1529586229' => $fields['money'],
            'UF_CRM_1529587820' => $fields['money2'],
            'UF_CRM_1529587836' => $fields['money3'],
            'OPPORTUNITY' => $fields['summa'],
            'UF_CRM_1529586259' => $fields['combuh']
        ];

        $queryData = http_build_query([
                'fields' => $postData,
                'params' => array(
                    "REGISTER_SONET_EVENT" => "Y"
                )
            ]
        );
        $curl = curl_init();
        curl_setopt_array($curl,
            [
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_POST => 1,
                CURLOPT_HEADER => 0,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $this->queryUrl . $method,
                CURLOPT_POSTFIELDS => $queryData,
            ]
        );
        $result = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($result, 1);

        if (isset($result)) {

            //print_r($result);

            if (array_key_exists('error', $result)) {
                echo "Ошибка при сохранении лида: " . $result['error_description'] . " ";
            }
            return $result['result'];
        }

    }

    public function updCompany($fields) {

        $id = $fields['bxcompany'];
        $title = 'обновление компании';
        $method = 'crm.company.update.json';

        $postData = [
            //'UF_CRM_1529862242' => $fields['id'],
            'TITLE' => $title,
            'SECOND_NAME' => $fields['zakaz'],
            'LAST_NAME' => $fields['contact'],
            'UF_CRM_1529585224' => $fields['date'],
            'UF_CRM_1529585335' => $fields['time'],
            'UF_CRM_1529585403' => $fields['gruz'],
            'UF_CRM_1529585419' => $fields['path'],
            'UF_CRM_1529585592' => $fields['deadline'],
            'COMPANY_TITLE' => $fields['zakaz'],
            'NAME' => $fields['contact'],
            'PHONE_MOBILE' => $fields['tel'],
            'PHONE_WORK' => $fields['gortel'],
            'UF_CRM_1529585800' => $fields['disp'],
            'UF_CRM_1529585885' => $fields['marka'],
            //'UF_CRM_1529585907' => $fields['pricep'],
            'COMMENTS' => $fields['comment'],
            'UF_CRM_1529607515' => $fields['perevoz'],
            'UF_CRM_1529607569' => $fields['summaper'],
            'UF_CRM_1529607719' => $fields['obkm'],
            'UF_CRM_1529607766' => $fields['stavkakubm'],
            'UF_CRM_1529607798' => $fields['kolkubm'],
            'UF_CRM_1529586033' => $fields['ch'],
            'UF_CRM_1529586054' => $fields['stavkach'],
            'UF_CRM_1529586073' => $fields['km'],
            'UF_CRM_1529586097' => $fields['stavkakm'],
            'UF_CRM_1529586229' => $fields['money'],
            'UF_CRM_1529587820' => $fields['money2'],
            'UF_CRM_1529587836' => $fields['money3'],
            'OPPORTUNITY' => $fields['summa'],
            'UF_CRM_1529586259' => $fields['combuh']
        ];

        $queryData = http_build_query([
                'ID' => $id,
                'fields' => $postData,
                'params' => array(
                    "REGISTER_SONET_EVENT" => "Y"
                )
            ]
        );
        $curl = curl_init();
        curl_setopt_array($curl,
            [
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_POST => 1,
                CURLOPT_HEADER => 0,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $this->queryUrl . $method,
                CURLOPT_POSTFIELDS => $queryData,
            ]
        );
        $result = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($result, 1);

        if (isset($result)) {

            //print_r($result);

            if (array_key_exists('error', $result)) {
                echo "Ошибка при сохранении компании: " . $result['error_description'] . " ";
            }
            return $result['result'];
        }

    }

    public function updCompanyID($fields) {

        $id = $fields['comp_id'];
        $title = 'Обновление компании';
        $method = 'crm.contact.update.json';

        $postData = [
            'TITLE' => $title,
            'CONTACT_ID' => $fields['cont_id'],
            'COMPANY_ID' => $fields['comp_id'],
            'UF_CRM_5A2B9BF52BA29' => $fields['tel2'],
        ];

        $queryData = http_build_query([
                'ID' => $id,
                'fields' => $postData,
                'params' => array(
                    "REGISTER_SONET_EVENT" => "Y"
                )
            ]
        );
        $curl = curl_init();
        curl_setopt_array($curl,
            [
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_POST => 1,
                CURLOPT_HEADER => 0,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $this->queryUrl . $method,
                CURLOPT_POSTFIELDS => $queryData,
            ]
        );
        $result = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($result, 1);

        if (isset($result)) {
            print_r($result);
            if (array_key_exists('error', $result)) {
                echo "Ошибка при сохранении лида: " . $result['error_description'] . " ";
            }
            return $result['result'];
        }

    }
}