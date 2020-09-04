# 「PHP算法」文件夹遍历

```php

<?php
/**
 * Desc: 文件夹遍历.
 */
function allFile($path = __DIR__, $level = 1)
{
    if (is_dir($path) && is_readable($path)) {
        if($pd = opendir($path)) {
            while (($file = readdir($pd)) !== false) {
                if($file != '.' && $file != '..') {
                    if (($subPath = $path . DIRECTORY_SEPARATOR . $file) && is_dir($subPath)) {
                        echo "<pre />";
                        echo '<span style="color: red;font-weight:bold;">' . str_repeat("--", $level) . $subPath . '</span>';
                        self::allFile($subPath, $level++);
                    } else {
                        echo "<pre />";
                        echo str_repeat("--", $level) . $subPath;
                    }
                }
            }
        }
    } else {
        echo "{$path} is not a available dir";
    }
```

