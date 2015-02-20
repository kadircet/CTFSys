<?php
//Author: Kadir CETINKAYA - breakv0id@0xdeffbeef

function decryptPost($post)
{
	//$data = base64_decode($data);
	
	$privKey = <<<EOK
-----BEGIN RSA PRIVATE KEY-----
<censored>
-----END RSA PRIVATE KEY-----
EOK;
	//$post = "";
	$privKey = openssl_get_privatekey($privKey);
	//openssl_private_decrypt($data, $post, $privKey);

	//$post = explode('&', $data);

	$res = array();
	foreach($post as $name => $value)
	{
		$decval = "";
		if(is_array($value)===true)
		{
			foreach($value as $key => $val)
			{
				if(ctype_print(base64_decode($val))===false && $name!="desc")
					openssl_private_decrypt(base64_decode($val), $decval, $privKey);
				else
					$decval = base64_decode($val);
				$value[$key] = $decval;
			}
			$res[$name] = $value;
		}
		else
		{
			if(ctype_print(base64_decode($value))===false  && $name!="desc")
				openssl_private_decrypt(base64_decode($value), $decval, $privKey);
			else
				$decval = base64_decode($value);
			$res[$name] = $decval;
		}
	}
	return $res;
}

function hashPass($salt, $pass)
{
	$iterations = 100;
	$length = 2048/8; //in bytes
	$hash = hash_pbkdf2("sha256", $pass, $salt, $iterations, $length*2);
	
	return $hash;
}

function generateSalt($length=64)
{
	$salt = mcrypt_create_iv($length, MCRYPT_DEV_URANDOM);
	
	return $salt;
}

function sendMail($to, $subject, $text)
{
	$boundary = "b1_".md5(uniqid(time()));
	$headers  = 'From: HackMETU <ctf@0xdeffbeef.com>' . "\r\n";
	//$headers .= "Message-ID: <$boundary@0xdeffbeef.com>\r\n";
	$headers .= 'Reply-To: ctf@0xdeffbeef.com' . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	//$headers .= "Content-Type: multipart/alternative;\r\n\tboundary=$boundary\r\n";
 	//$headers .= "Content-Transfer-Encoding: quoted-printable\r\n";
	//$headers .= "Precedence: bulk\r\n";
	//$headers .= "Date: ".date('D, j M Y H:i:s O')."\r\n";
	
	//$plaintext = preg_replace('/<(.*?)>/', '', $text);
	
	//$preText  = "--".$boundary."\r\n";
	//$preText .= "Content-Type: text/plain; charset='iso-8859-9'\r\n";
	//$preText .= "Content-Transfer-Encoding: quoted-printable\r\n\r\n";
	//$preText .= $plaintext;
	
	//$preText .= "\r\n--".$boundary."\r\n";
	$headers .= "Content-Type: text/html; charset='iso-8859-9'\r\n";
	//$preText .= "Content-Transfer-Encoding: quoted-printable\r\n\r\n";
	//$preText .= $text;
	
	//$preText .= "\r\n\r\n--$boundary--";
	
	mail($to, $subject, $text, $headers);
}

function logreq($post)
{
	$log = fopen("ctf.log", "a+");
	fwrite($log, print_r($_SERVER)."\n");
	fwrite($log, print_r($post)."\n");
	fwrite($log, "-------------------------------------\n");
	fclose($log);
}

?>
