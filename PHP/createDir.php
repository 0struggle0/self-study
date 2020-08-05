<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>创建更新文件目录</title>
</head>
<style>
	.span{display: inline-block;width:100px;text-align: left}
</style>
<body>
	<div style="margin:5% auto;width: 400px;">
		<form enctype="multipart/form-data" method="get" action="./createDir.php">
            <div style="width:1200px;margin:0px 0px 30px -300px;">
                生成多个目录请用分号分割路径, 例如：在admin下生成目录 D:\xampp\htdocs\cenc\data\model;
                D:\xampp\htdocs\cenc\mobile\control
            </div>
			<div>
				<span class="span">admin:</span>
				<span><input type="text" name="admindir" value="" autocomplete="off"></span>
			</div>
			<div>
				<span class="span">cloudPC:</span>
				<span><input type="text" name="cloudPCdir" value="" autocomplete="off"></span>
			</div>
			<div>
				<span class="span">core:</span>
				<span><input type="text" name="coredir" value="" autocomplete="off"></span>
			</div>
			<div>
				<span class="span">crontab:</span>
				<span><input type="text" name="crontabdir" value="" autocomplete="off"></span>
			</div>
			<div>
				<span class="span">data:</span>
				<span><input type="text" name="dataCdir" value="" autocomplete="off"></span>
			</div>
			<div>
				<span class="span">mobile:</span>
				<span><input type="text" name="mobiledir" value="" autocomplete="off"></span>
			</div>
			<div>
				<span class="span">practice:</span>
				<span><input type="text" name="practicedir" value="" autocomplete="off"></span>
            </div>
            <div>
				<span class="span">test:</span>
				<span><input type="text" name="testdir" value="" autocomplete="off"></span>
            </div>
            <div>
				<span class="span">vcfeedback:</span>
				<span><input type="text" name="vcfeedbackdir" value="" autocomplete="off"></span>
			</div>
			<div>
				<span class="span">wap:</span>
				<span><input type="text" name="wapdir" value="" autocomplete="off"></span>
			</div>
			<div>
				<input type="submit" id="createdir" value="生成目录" style="margin: 20px 0px 0px 100px;">
			</div>
		</form>
	</div>
</body>
</html>


<?php

if (!empty($_GET)) {
    createBase();
	creatAllDir($_GET);
}

function createBase()
{
	if (!file_exists('./update')) {
        selfMkdir('update');
        file_put_contents('update/new.txt', '');
	}
}

function creatAllDir($dirs)
{
    $dir = '';
	foreach ($dirs as $dirName => $dir) {
		switch ($dirName) {
            case 'admindir':
                createSpecifiedPath($dir, 'admin');
			    break;
			case 'cloudPCdir':
				createSpecifiedPath($dir, 'cloudPC');
			    break;
			case 'coredir':
				createSpecifiedPath($dir, 'core');
			    break;
			case 'crontabdir':
				createSpecifiedPath($dir, 'crontab');
			    break;
			case 'dataCdir':
				createSpecifiedPath($dir, 'data');
			    break;
			case 'mobiledir':
				createSpecifiedPath($dir, 'mobile');
			    break;
			case 'practicedir':
				createSpecifiedPath($dir, 'practice');
                break;
            case 'testdir':
                createSpecifiedPath($dir, 'test');
                break;
            case 'vcfeedbackdir':
                createSpecifiedPath($dir, 'vcfeedback');
                break;
			case 'wapdir':
				createSpecifiedPath($dir, 'wap');
			    break;
		}
	}
}

function createSpecifiedPath($dir, $dirFlag)
{
	if (empty($dir) || empty($dirFlag)) {
		return false;
    }

    $dir = trim($dir);
    $dir = str_replace('\\', '/', $dir);
    $dir = str_replace('；', ';', $dir);
    $dirs = explode(';', $dir);
    foreach ($dirs as $newDir) {
        if (empty($newDir)) {
            continue;
        }

        $correctDirIndex = strpos($newDir, $dirFlag);
        if ($correctDirIndex !== false) {
            $correctDir = substr($newDir, $correctDirIndex);
            selfMkdir('update/' . $correctDir);
        }
    }
}

function selfMkdir($dir)
{
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }
}
