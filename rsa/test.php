<?php

$res = '';
$type = $_POST['type'];
$originalData = $_POST['inputstring'];
$is_publickey_encrypt = $_POST['is_publickey_encrypt'];

if ($is_publickey_encrypt == 'yes') {
	if ($type == "decrypt") {
		$privateKeyString = "-----BEGIN RSA PRIVATE KEY-----
MIICWwIBAAKBgQC+UPrTCh4hCORYyZWtMkzeJFhVow0XOIkJzQfGhKtJFJ5+lq5E
AUwM0lrifC9ZC0BffO1FATK5Srbtih3gbV7zGUjtqSt03eAiwUSOrXLgNkZIh+NP
g9FelKVEJLpzeraQE65scTfXC+/+vvYff9fAAzfephV6Wuupfxb2h0TbPQIDAQAB
AoGAJ/5Ed0zNAAwqUC4scfT8CkKA/Z4CBjsvMQwQ8jq28+iNVfS8MjZDkP4zcxy9
pmyi3m4WPkX+LsnwnwJDPQI+zWHiIEA1f4hv6AVLX1hEbgJ8LCXJSmZJuDVgqIr7
UjEVRLBF2RoJSIWJ4VtMvp4SA8lp/5245esYqCmzxqkKc1ECQQD0118Vz/r55h1F
PaJODCVGmcczH1rmzksu/6F4W6mz1vT5va/ImC6EdztEHbSYRhxFQazjp+gbPsl7
LZwbJMmrAkEAxv1zd6pLwVaVVjE3/0QdB20uY+gpj6BJniPHMA2lfBVnsbk+VXOq
7i8ZfDgTQ3VZxUoe4PpUYvIJrxM1J+wWtwJAb2AZTN7TGCJpZjnnPwGfY0JIrySw
QRXOdY6rcQihZcF+pqx27hTr9C4Ys5+fqzUZXxfFAbo7h0lEddgFjwNpCQJAAVw6
Ldc8LVYqLyym9VfB2wskBgrQPesalboo4ms1dmOvEcfyZSMlR/uKcQ7xEsT6mB6p
l2Aes450An5fHqa+gQJACGOkQXv2tQA9umC3ki402dC/kgbBiulbvKWba/kLJUrC
AO9RZ76D3Hn42w/cqNPY63smdR5vIT2EAWiNMlcZ1g==
-----END RSA PRIVATE KEY-----";
		$privateKey = openssl_pkey_get_private($privateKeyString); 
		//私钥解密
		$content = base64_decode($originalData);
		if (openssl_private_decrypt($content, $res, $privateKey)) {
			echo $res;
		}
	} else {
		//公钥加密
		$publicKeyString = "-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC+UPrTCh4hCORYyZWtMkzeJFhV
ow0XOIkJzQfGhKtJFJ5+lq5EAUwM0lrifC9ZC0BffO1FATK5Srbtih3gbV7zGUjt
qSt03eAiwUSOrXLgNkZIh+NPg9FelKVEJLpzeraQE65scTfXC+/+vvYff9fAAzfe
phV6Wuupfxb2h0TbPQIDAQAB
-----END PUBLIC KEY-----";
		$publicKey = openssl_pkey_get_public($publicKeyString); 

		if (openssl_public_encrypt($originalData, $res, $publicKey)) { 
			echo base64_encode($res);
		}
	}
} else {
	if ($type == "encrypt") {
		$privateKeyString = "-----BEGIN RSA PRIVATE KEY-----
MIICWwIBAAKBgQC+UPrTCh4hCORYyZWtMkzeJFhVow0XOIkJzQfGhKtJFJ5+lq5E
AUwM0lrifC9ZC0BffO1FATK5Srbtih3gbV7zGUjtqSt03eAiwUSOrXLgNkZIh+NP
g9FelKVEJLpzeraQE65scTfXC+/+vvYff9fAAzfephV6Wuupfxb2h0TbPQIDAQAB
AoGAJ/5Ed0zNAAwqUC4scfT8CkKA/Z4CBjsvMQwQ8jq28+iNVfS8MjZDkP4zcxy9
pmyi3m4WPkX+LsnwnwJDPQI+zWHiIEA1f4hv6AVLX1hEbgJ8LCXJSmZJuDVgqIr7
UjEVRLBF2RoJSIWJ4VtMvp4SA8lp/5245esYqCmzxqkKc1ECQQD0118Vz/r55h1F
PaJODCVGmcczH1rmzksu/6F4W6mz1vT5va/ImC6EdztEHbSYRhxFQazjp+gbPsl7
LZwbJMmrAkEAxv1zd6pLwVaVVjE3/0QdB20uY+gpj6BJniPHMA2lfBVnsbk+VXOq
7i8ZfDgTQ3VZxUoe4PpUYvIJrxM1J+wWtwJAb2AZTN7TGCJpZjnnPwGfY0JIrySw
QRXOdY6rcQihZcF+pqx27hTr9C4Ys5+fqzUZXxfFAbo7h0lEddgFjwNpCQJAAVw6
Ldc8LVYqLyym9VfB2wskBgrQPesalboo4ms1dmOvEcfyZSMlR/uKcQ7xEsT6mB6p
l2Aes450An5fHqa+gQJACGOkQXv2tQA9umC3ki402dC/kgbBiulbvKWba/kLJUrC
AO9RZ76D3Hn42w/cqNPY63smdR5vIT2EAWiNMlcZ1g==
-----END RSA PRIVATE KEY-----";
		$privateKey = openssl_pkey_get_private($privateKeyString); 
		//私钥加密
		if (openssl_private_encrypt($originalData, $res, $privateKey)) {
			echo base64_encode($res);
		}
	} else {
		//公钥解密
		$publicKeyString = "-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC+UPrTCh4hCORYyZWtMkzeJFhV
ow0XOIkJzQfGhKtJFJ5+lq5EAUwM0lrifC9ZC0BffO1FATK5Srbtih3gbV7zGUjt
qSt03eAiwUSOrXLgNkZIh+NPg9FelKVEJLpzeraQE65scTfXC+/+vvYff9fAAzfe
phV6Wuupfxb2h0TbPQIDAQAB
-----END PUBLIC KEY-----";
		$publicKey = openssl_pkey_get_public($publicKeyString); 
		
		$content = base64_decode($originalData);
		if (openssl_public_decrypt($content, $res, $publicKey)) { 
			echo $res;
		}
	}
}