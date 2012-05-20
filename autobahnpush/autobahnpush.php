<?php
/******************************************************************************
**
**  Copyright 2012 Tavendo GmbH
**
**  Licensed under the Apache License, Version 2.0 (the "License");
**  you may not use this file except in compliance with the License.
**  You may obtain a copy of the License at
**
**      http://www.apache.org/licenses/LICENSE-2.0
**
**  Unless required by applicable law or agreed to in writing, software
**  distributed under the License is distributed on an "AS IS" BASIS,
**  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
**  See the License for the specific language governing permissions and
**  limitations under the License.
**
******************************************************************************/

function urlsafe_b64encode($string)
{
   $data = base64_encode($string);
   $data = str_replace(array('+','/'),array('-','_'),$data);
   return $data;
}

class AutobahnPushClient
{

	private $opts = array ();

	public function __construct($pushto, $appkey = null, $appsecret = null, $timeout = 5, $debug = false)
	{
		$this->opts['pushto'] = $pushto;
		$this->opts['appkey'] = $appkey;
		$this->opts['appsecret'] = $appsecret;
		$this->opts['timeout'] = $timeout;
		$this->opts['debug'] = $debug;
	}

	public function push($topic, $event, $eligible = null, $exclude = null)
	{
		$ch = curl_init();
		if ($ch === false)
		{
			die('Fatal: cURL could not be initialized.');
		}

      $msg = json_encode($event);

      $data = array('topicuri' => $topic);
      if ($this->opts['appkey'] !== null)
      {
         $timestamp = gmdate("Y-m-d\TH:i:s\Z");
         $sig = urlsafe_b64encode(hash_hmac('sha256', $topic . $this->opts['appkey'] . $timestamp . $msg, $this->opts['appsecret'], true));
         $data['timestamp'] = $timestamp;
         $data['appkey'] = $this->opts['appkey'];
         $data['signature'] = $sig;
      }
      if ($eligible !== null)
      {
         $data['eligible'] = join(',', $eligible);
      }
      if ($exclude !== null)
      {
         $data['exclude'] = join(',', $exclude);
      }

      $url = $this->opts['pushto'] . '/?' . http_build_query($data, '', '&');

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded", "User-Agent: AutobahnPushPHP") );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $msg);
		curl_setopt($ch, CURLOPT_TIMEOUT, $this->opts['timeout']);

		$response = curl_exec($ch);

		curl_close($ch);

      return $response;

		if ($response == "202 ACCEPTED\n" && $debug == false)
		{
			return true;
		}
		elseif ($this->opts['debug'] == true)
		{
			return $response;
		}
		else
		{
			return false;
		}
	}
}

?>
