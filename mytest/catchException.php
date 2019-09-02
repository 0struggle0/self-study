<?php

function sysException($exception)
{
    echo "系统出现异常:" , $exception->getMessage();
    echo "<br>请及时联系系统管理员。";
}

// 设置默认的异常处理方法，用于项目中没有用 try/catch 块来捕获的异常
set_exception_handler('sysException');