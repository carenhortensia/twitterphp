<?php
//twitteroauth.phpをインクルードします。ファイルへのパスはご自分で決めて下さい。
require_once("./twitteroauth.php");

//TwitterAPI開発者ページでご確認下さい。
//Consumer keyの値を格納
$sConsumerKey = "***********";
//Consumer secretの値を格納
$sConsumerSecret = "**********";
//Access Tokenの値を格納
$sAccessToken = "****************";
//Access Token Secretの値を格納
$sAccessTokenSecret = "**********************";

//OAuthオブジェクトを生成する
$twObj = new TwitterOAuth($sConsumerKey,$sConsumerSecret,$sAccessToken,$sAccessTokenSecret);
//idをスクリーンネームに変換
function Idname($ID,$twObj){
    $userData = $twObj->OauthRequest("https://api.twitter.com/1.1/users/show.json","GET",array('user_id' => $ID));
    $Obj = json_decode($userData);
        if(isset($fObj->{'errors'})&& $fObj->{'errors'} !=''){
    
        ReturnError();
        return 0;
    }else{
        return $Obj->screen_name;
    }
   
}
//フォロワーrequest関数
function Request($ID,$twObj){

    $vFollowers = $twObj->OauthRequest("https://api.twitter.com/1.1/followers/ids.json","GET",array('screen_name' => $ID));
    $Obj = json_decode($vFollowers);
    if(isset($fObj->{'errors'})&& $fObj->{'errors'} !=''){

        ReturnError();
        return 0;
    }else{
        return $Obj;
    }
};
function ReturnError(){
    $ER = array('Error' => '1');
    echo json_encode($ER);
    exit;
}
//POSTデータがあるか
if (isset($_POST['me'])&&isset($_POST['you']))
{
}
else
{
    ReturnError();
}


//フォロワーを取得したいユーザのスクリーンネーム
$me = $_POST['me'];
$you = $_POST['you'];


//リクエスト関数でフォロワーを取得 オブジェクトに格納
$meObj = Request($me,$twObj);
$youObj = Request($you,$twObj);


//配列と数字をとりあえず定義
//抽出データ格納配列
$much=array();
//マッチしたデータ数をいれてく
$d=0;
//抽出データをスクリーンネームに変更後いれる配列
$common=array();


//片方ループで回して1個ずつもう片方とマッチするかみてマッチしたら配列にいれる
for($i=0;$i<sizeof($meObj->ids);$i++){
    if(array_search($meObj->ids[$i], $youObj->ids)!=FALSE){
       $much[$d]= $meObj->ids[$i];
       $d++;
    }
}


//抽出データのidをscreen nameに変換
for($i=0;$i<sizeof($much);$i++){
    $common[$i]=Idname($much[$i],$twObj);
}

echo json_encode($common);


?>