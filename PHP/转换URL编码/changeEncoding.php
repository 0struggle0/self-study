<?php

$data = 'H4sIAAAAAAAAC+1Ty07CQBT9laYmRhPKtEUT+qALWCpx4RcUU6Cx05m0QwqujI+4MzHRaES3xpUYMQQh8jPaAn9hHxbRjTQmuNDNdHrnnMk995yRMWWThqHlaKhaFd1kCMIii4lEvf+XECEIRqUyMglj6zuayPGY0IpsY9WM+eFhWYW60RDdwd3ouTVuHo77J7TiXt3yQpZa8847KTbNsrwMAuKs9BgNVVKl6tAw7RxdJQSLADiOk3YyaWRVACcIWVD0IeFSXPd5kGh1okBkyCDayhApiwt1ni+sSn4N+QW7hmPgduUDZyFngma5TIwOT7kJDEQ4EN0CggZnFTW8PJjXFOxaKW69oBamhhF++Ck1ITKRDK/X8ToPvhj3qe1eH3mPfbd3M2z3vbP7+crTA6sy+dAp/bOBeS62Dympb41MOoHX7vF/pn8305sbXzK98iczbYZv2fxRmofNrtc6HQ32vYvWUhK1EsWoDqNDjCwi+oQtzaaDRlVWml6pZBNcftndixkAK28Vaj95rQYAAA==';
$url = '127.0.0.1/test.php?param=' . $data;

// 转换编码防止参数中的+、-等特殊字符丢失
// urlencode和rawurlencode的区别：urlencode将空格编码为加号“+”，rawurlencode将空格编码为“%20”。

echo urlencode($url) . '<br>';
echo "<br>";
echo urldecode(urlencode($url));
echo "<br>";

echo rawurlencode($url) . '<br>';
echo "<br>";
echo rawurldecode(rawurlencode($url));
