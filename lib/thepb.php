<?php

class thepb {
    Private $apikey = "";
    Private $lang = "";
    Public $private = 0;
    Public $data = "";

	/*
	 *  thepb::post([
	 *    'apikey' => <key>,
	 *    'lang'   => <language>,
	 *    'private'=> truthy or falsey value
	 *  ], <data>);
	 */
	
    public static function post($arr, $data) {
        $paste = new thepb;
        $paste->setKey($arr['apikey']);
        if (array_key_exists('lang',$arr) == true) {
            $paste->setLang($arr['lang']);
        }
        if (array_key_exists('private', $arr) == true) {
            $paste->private = $arr['private'];
        }
        $paste->data = $data;
        return $paste->send();
    }

    public function setLang($lang) {
		if (strlen($lang) < 1) { return false; }
        $validated = $this->get("/languages/validate/".$lang);
		$res = json_decode($validated, true);
        if ($res['valid'] == true) {
            $this->lang = $lang;
            return true;
        }
        return false;
    }

    public function setKey($key = null) {
        if ($key === null) {
            throw new Exception("THEPB_NO_KEY");
        }
        if (preg_match("/^[A-F0-9]{8}(?:-?[A-F0-9]{4}){3}-?[A-F0-9]{12}$/i", $key) > 0) {
			$this->apikey = $key;
			return true;
		}
        throw new Exception("THEPB_INVALID_KEY");
    }

	public static function validateKey($key) {
		$validated = $this->get("/keys/validate", false, ["apikey" => $key]);
        $res = json_decode($validated, true);
        if ($res['valid'] == true) {
            $this->apikey = $key;
            return true;
        }
		return false;
	}
	
    public function send() {
        if ($this->apikey == "") {
            throw new Exception("THEPB_NO_KEY");
        }
        if ($this->data == "") {
            throw new Exception("THEPB_NO_DATA");
        }
        $res = $this->get("/paste/submit", true, [
            'lang' => ( $this->lang != "" ? $this->lang : "plain" ),
            'privacy' => ( $this->private ? '2' : '1' ),
            'paste' => $this->data
        ]);
        return json_decode($res, true);
    }

    private function get($url,$needKey = false,$post = null) {
        $isPost = false;
        $url = "https://api.thepb.in/v1" . $url;
        if ($post != null) {
            $isPost = true;
            $data = $post;
            $fields = http_build_query($data);
        }

        try {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            if ($needKey) {
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'X-ThePB-Key: '.$this->apikey
                ]);
            }
            if ($isPost) {
                curl_setopt_array($ch,array(
                    CURLOPT_POST            => count($data),
                    CURLOPT_POSTFIELDS      => $fields
                ));
            }
            $result = curl_exec($ch);
        } catch (Exception $e) {
            if ($isPost) {
                $options = array(
                    'http'  => array(
                        'header'    => 'Content-type: application/x-www-form-urlencoded\r\n',
                        'method'    => 'POST',
                        'content'   => $fields
                    )
                );
                if ($needKey) {
                    $options['http']['header'] .= "X-ThePB-Key: " . $this->apikey . "\r\n";
                }
                $context = stream_context_create($options);
                $result = file_get_contents($url, false, $context);
            }
            else {
                $result = file_get_contents($url);
            }
        }
        return $result;
    }
}
?>
