<?php
//Petit-board (c)さとぴあ @satopian 2020-2021
//1スレッド1ログファイル形式のスレッド式掲示板

require_once(__DIR__.'/config.php');
require_once(__DIR__.'/function.php');

$mode = filter_input(INPUT_POST,'mode');
if($mode==='regist'){
	return post();
}
if($mode==='paint'){
	return paint();
}
if($mode==='del'){
	return del();
}
if($mode==='admin'){
	admin();
}

$page=filter_input(INPUT_GET,'page');
//投稿処理
function post(){	
global $max_log,$max_res,$max_kb;
//POSTされた内容を取得
check_csrf_token();
$sub = t((string)filter_input(INPUT_POST,'sub'));
$name = t((string)filter_input(INPUT_POST,'name'));
$com = t((string)filter_input(INPUT_POST,'com'));
$resno = t((string)filter_input(INPUT_POST,'resno'));
if($resno&&is_file('./log/'.$resno.'.txt')&&(count(file('./log/'.$resno.'.txt'))>$max_res)){//レスの時はスレッド別ログに追記
	error('最大レス数を超過しています。');
}

if(!$sub||preg_match("/\A\s*\z/u",$sub))   $sub="";
if(!$name||preg_match("/\A\s*\z/u",$name)) $name="";
if(!$com||preg_match("/\A\s*\z/u",$com)) $com="";
if(strlen($sub) > 80) error('題名が長すぎます。');
if(strlen($name) > 30) error('名前が長すぎます。');
if(strlen($com) > 1000) error('本文が長すぎます。');


$tempfile = $_FILES['imgfile']['tmp_name'] ?? ''; // 一時ファイル名
$filesize = $_FILES['imgfile']['size'];
if($filesize > $max_kb*1024){
	error("アップロードに失敗しました。ファイル容量が{$max_kb}kbを越えています。");
}
$imgfile='';
$w='';
$h='';
$time = time();
$time = $time.substr(microtime(),2,3);	//投稿時刻

if ($tempfile && $_FILES['imgfile']['error'] === UPLOAD_ERR_OK){
	$img_type = $_FILES['imgfile']['type'] ?? '';

	if (!in_array($img_type, ['image/gif', 'image/jpeg', 'image/png','image/webp'])) {
		error('対応していないフォーマットです。');
	}
	

	$upfile='src/'.$time.'.tmp';
		move_uploaded_file($tempfile,$upfile);

	if($filesize > 512 * 1024){//指定サイズを超えていたら
		if ($im_jpg = png2jpg($upfile)) {

			if(filesize($im_jpg)<$filesize){//JPEGのほうが小さい時だけ
				rename($im_jpg,$upfile);//JPEGで保存
				chmod($upfile,0606);
			} else{//PNGよりファイルサイズが大きくなる時は
				unlink($im_jpg);//作成したJPEG画像を削除
			}
		}
	}
	list($w,$h)=getimagesize($upfile);
	$_img_type=mime_content_type($upfile);
	$ext=getImgType ($_img_type);
	$imgfile=$time.$ext;
	rename($upfile,'./src/'.$imgfile);
	$tool='upload';
}

if(!$sub){
	$sub='無題';
}
if(!$name){
	$name='anonymous';
}
$sub=str_replace(["\r\n","\r","\n",],'',$sub);
$name=str_replace(["\r\n","\r","\n",],'"\n"',$name);
$com=str_replace(["\r\n","\r","\n",],'"\n"',$com);
$com = preg_replace("/(\s*\n){4,}/u","\n",$com); //不要改行カット

setcookie("namec",$name,time()+(60*60*24*30),0,"",false,true);

if(!$imgfile&&!$com){
error('何か書いて下さい。');
}

//全体ログを開く
$alllog_arr=file('./log/alllog.txt');
$alllog=end($alllog_arr);
$line='';
//書き込まれるログの書式
if($resno){//レスの時はスレッド別ログに追記
	$r_line = "$resno\t$sub\t$name\t$com\t$imgfile\t$w\t$h\t$time\t$tool\tres\n";
	file_put_contents('./log/'.$resno.'.txt',$r_line,FILE_APPEND);
	chmod('./log/'.$resno.'.txt',0600);	
	foreach($alllog_arr as $i =>$val){
		list($_no)=explode("\t",$val);
		if($resno==$_no){
			$line = $val;//レスが付いたスレッドを$lineに保存。あとから配列に追加して上げる
			unset($alllog_arr[$i]);//レスが付いたスレッドを全体ログからいったん削除
			break;
		}
	}
	
} else{
	list($no)=explode("\t",$alllog);
	//最後の記事ナンバーに+1
	$no=trim($no)+1;
	$line = "$no\t$sub\t$name\t$com\t$imgfile\t$w\t$h\t$time\t$tool\toya\n";
	file_put_contents('./log/'.$no.'.txt',$line);//新規投稿の時は、記事ナンバーのファイルを作成して書き込む
	chmod('./log/'.$no.'.txt',0600);
}
	$alllog_arr[]=$line;//全体ログの配列に追加

	Delete_old_thread($alllog_arr);

file_put_contents('./log/alllog.txt',$alllog_arr,LOCK_EX);//全体ログに書き込む
chmod('./log/alllog.txt',0600);

header('Location: ./');

}
function paint(){
$app = filter_input(INPUT_POST,'app');
$picw = filter_input(INPUT_POST,'picw',FILTER_VALIDATE_INT);
$pich = filter_input(INPUT_POST,'pich',FILTER_VALIDATE_INT);

switch($app){
		case 'neo':
				$templete='paint_neo.html';
				$tool='neo';
				break;
		
			case 'chi':
				$templete='paint_chi.html';
				$tool='chi';
				break;
			
				default:
					return;
}
			
			include __DIR__.'/template/'.$templete;

}

function del(){
	$id=filter_input(INPUT_POST,'delid');
	$no=filter_input(INPUT_POST,'delno');
	$alllog_arr=file('./log/alllog.txt');
	if(is_file("./log/$no.txt")){
		$line=file("./log/$no.txt");
		foreach($line as $i =>$val){
			list(,,,,$imgfile,,,$time,$oya)=explode("\t",$val);
			if($id==$time){
				if(trim($oya)=='oya'){//スレッド削除

				//スレッドの画像を削除	
					$fp = fopen("./log/$no.txt", "r");//個別スレッドのログを開く
					while ($line = fgetcsv($fp, 0, "\t")) {
					list(,,,,$imgfile,)=$line;
					safe_unlink('src/'.$imgfile);//画像削除
					}
			
					safe_unlink('./log/'.$no.'.txt');
					foreach($alllog_arr as $i =>$val){
						list($_no)=explode("\t",$val);
						if($no==$_no){
							unset($alllog_arr[$i]);
						}
					}
				}else{
					unset($line[$i]);
				}
				safe_unlink('src/'.$imgfile);//画像削除
			}
		file_put_contents('./log/'.$no.'.txt',$line);
		file_put_contents('./log/alllog.txt',$alllog_arr);
		header('Location: ./');

		}
	}
}
$token=get_csrf_token();
if($mode==='logout'){
	unset($_SESSION['admin']);
}
//表示
$adminmode=isset($_SESSION['admin'])&&($_SESSION['admin']==='admin_mode');
$alllog_arr=file('./log/alllog.txt');//全体ログを読み込む
$count_alllog=count($alllog_arr);
krsort($alllog_arr);

//ページ番号から1ページ分のスレッド分とりだす
$alllog_arr=array_slice($alllog_arr,$page,$pagedef,false);
//oyaのループ
foreach($alllog_arr as $oya => $alllog){
	
		list($no)=explode("\t",$alllog);
		if(is_file("./log/$no.txt")){

		$fp = fopen("./log/$no.txt", "r");//個別スレッドのログを開く
		while ($line = fgetcsv($fp, 0, "\t")) {
		list($no,$sub,$name,$com,$imgfile,$w,$h,$time,$tool)=$line;
		$res=[];
		switch($tool){
			case 'neo':
				$tool='PaintBBS NEO';
				break;
			case 'chi':
				$tool='ChickenPaint';
				break;
			case 'upload':
				$tool='アップロード';
				break;
			default:
				'';
		}
		$res=[
			'no' => $no,
			'sub' => $sub,
			'name' => $name,
			'com' => $com,
			'img' => $imgfile,
			'w' => $w,
			'h' => $h,
			'time' => $time,
			'tool' => $tool,
		];

		$res['com']=str_replace('"\n"',"\n",$res['com']);
		$out[$oya][]=$res;
		}	
	fclose($fp);
	}

}

//Cookie
$namec=(string)filter_input(INPUT_COOKIE,'namec');
$templete='main.html';
// HTML出力
include __DIR__.'/template/'.$templete;
