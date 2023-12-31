<?php    
   include 'db_test.php';
   session_start();
    $arr=$_FILES['file'];
    $files=array();
    for($i=0;$i<count($arr['name']);$i++){//count()统计数组键值name长度
        $files[$i]['name']=$arr['name'][$i];
        $files[$i]['type']=$arr['type'][$i];
        $files[$i]['tmp_name']=$arr['tmp_name'][$i];
        $files[$i]['error']=$arr['error'][$i];
        $files[$i]['size']=$arr['size'][$i];
    }
    for($i=0;$i<count($files);$i++){
    //取得上传文件信息
    $fileName=$files[$i]['name'];
    $fileType=$files[$i]['type'];
    $fileError=$files[$i]['type'];
    $fileSize=$files[$i]['size'];
    $tempName=$files[$i]['tmp_name'];//临时文件名
    
    //定义上传文件类型
    $typeList = array("image/jpeg","image/jpg","image/png","image/gif"); //定义允许的类型
    if($fileError>0){
            //上传文件错误编号判断
            switch ($fileError) {
                case 1:
                    $message="上传的文件超过了php.ini 中 upload_max_filesize 选项限制的值。"; 
                    break;
                case 2:
                    $message="上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值。"; 
                    break;
                case 3:
                    $message="文件只有部分被上传。"; 
                    break;
                case 4:
                    $message="没有文件被上传。";
                    break;
                case 6:
                    $message="找不到临时文件夹。"; 
                    break;
                case 7:
                    $message="文件写入失败"; 
                    break;
                case 8:
                    $message="由于PHP的扩展程序中断了文件上传";
                    break;
            }
            exit("文件上传失败：".$message);
        }
    if(!is_uploaded_file($tempName)){
        //判断是否是POST上传过来的文件
        exit("不是通过HTTP POST方式上传上来的");
    }else{
        if(!in_array($fileType, $typeList)){
            exit("上传的文件不是指定类型");
        }else{
            if(!getimagesize($tempName)){
                //避免用户上传恶意文件,如把病毒文件扩展名改为图片格式
                exit("上传的文件不是图片");
            }
        }
            if($fileSize>100000000){
                //对特定表单的上传文件限制大小
                exit("上传文件超出限制大小");
            }else{
                //避免上传文件的中文名乱码
                $fileName=str_replace(".", time().".", $fileName);//在图片名称后加入时间戳，避免重名文件覆盖
                if(move_uploaded_file($tempName, "uploads/".$fileName)){
                	$p="uploads/".$fileName;
                       $stmt = $conn->prepare("INSERT INTO files (filename, filepath,user_id) VALUES (:a, :s, :d)");
			    $stmt->bindParam(':a', $fileName);
			    $stmt->bindParam(':s', $p);
			    $stmt->bindParam(':d', $_SESSION['user_id']);
			  
			    $stmt->execute();
                }else{
                    echo "上传文件失败";
                }
            }
        }
    }
      header("Location: personalHome.php");
?>