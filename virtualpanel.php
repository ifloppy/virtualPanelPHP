<html>
<title>Virtual Panel by iruanp.com</title>
<?
//functions start
   function fileShow($dir){                           //遍历目录下的所有文件和文件夹 https://www.jianshu.com/p/ec18d58ac113
       $handle = opendir($dir);
       while($file = readdir($handle)){
            if($file !== '..' && $file !== '.'){
                $f = $dir.'/'.$file;
            if(is_file($f)){
                        echo '|--'.$file.'<br>';          //代表文件
                    }else{
                    echo  '--'.$file.'<br>';          //代表文件夹
                    fileShow($f);
                }
                    }
        }
   }
function zipUnzip($from, $to = "./"){//https://blog.csdn.net/zhyoulun/article/details/55190288
$zip = new ZipArchive();
$flag = $zip->open($from);
if($flag!==true){
    echo "open error code: {$flag}\n";
    exit();
}
$zip->extractTo($to);
$flag = $zip->close();
echo $flag?'success':'fail';
}
function zipAdd($from, $to, $toZip){
    $zip = new ZipArchive();
$flag = $zip->open($to, ZipArchive::CREATE);
if($flag!==true){
    echo "open error code: {$flag}\n";
    exit();
}
$zip->addFile($from, $toZip);
$flag = $zip->close();
echo $flag?'success':'fail';
}
function printW($s){
    echo $s;
    echo "<br>";
}

//functions end

//real
echo "Logs:<br>";
if($_GET['function'] == null){//如果没有输入function选项，则显示命令列表
    echo "Functions:<br>
    file_list([target]):list the files<br>
    file_realPathGet():Get the real path of your script<br>
    fileZip_unzip(from, [to]):unzip a file<br>
    fileZip_zip(from:your file, to:your zip file, toZip:the file in your zip file):zip a file<br>
    file_wget(url, file):download a file from an url<br>
    file_unlink(target):Process a file with unlink function<br>
    file_copy(old, new):Copy a file<br>
    file_move(old, new):Move/Rename a file(with function 'rename')<br>
    system_phpinfo():show php information with php function<br>
    <br>";
}

switch ($_GET['function']){//识别选择的功能
    case "file_list":
        printW("File-tree:");
        if($_GET['target']==null){
            fileShow("./");
        }else{
            fileShow($_GET["target"]);
        }
        break;


    case "file_realPathGet":
        printW("Real path:".getcwd());
        break;


    case "fileZip_unzip":
        if($_GET['from'] == null){
            printW("Need parameter: from");
            die("缺失参数");
        }
        zipUnzip($_GET['from'], $_GET['to']);
        break;


    case "fileZip_zipAdd":
        if($_GET['from'] == null or $_GET['to'] == null or $_GET['toZip'] == null){
            printW("Lost parameter");
            printW($_GET['from'].";".$_GET['to'].";".$_GET['toZip']);
            die("缺失参数");
        }
        zipAdd($_GET['from'], $_GET['to'], $_GET['toZip']);
        break;


    case "file_wget":
        if($_GET['url'] == null || $_GET['file'] == null){
            printW("Lost parameter");
            die("缺失参数");
        }
        file_put_contents($_GET['file'],file_get_contents($_GET['url']));
        break;

    case "file_unlink":
        if($_GET['target'] == null){
            die("缺失参数");
        }
        var_dump(unlink($_GET['target']));
        break;

    case "file_copy":
        if($_GET['old'] == null || $_GET['new'] == null){
            die("缺失参数");
        }
        var_dump(copy($_GET["old"], $_GET['new']));
        break;


    case "file_move":
        if($_GET['old'] == null || $_GET['new'] == null){
            die("缺失参数");
        }
        var_dump(rename($_GET['old']), $_GET['new']);
        break;


    case "system_phpinfo":
        phpinfo();
        break;
    default:
        echo "Did nothing";
        break;
}

?>
</html>
