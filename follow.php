<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>TRYPHP!　Twitter API V1.1 ホームタイムライン[ GET statuses/home_timeline ] サンプルコード</title>
</head>
<body>



<?php
//twitteroauth.phpをインクルードします。ファイルへのパスはご自分で決めて下さい。
require_once("./twitteroauth.php");

//TwitterAPI開発者ページでご確認下さい。
//Consumer keyの値を格納
$sConsumerKey = "sykI6bpwQIqpPbX6RKnAVKUaE";
//Consumer secretの値を格納
$sConsumerSecret = "WrH275KkUohpenL80Td6fpMJL2xHCnXTbhUQcGshYxF18bdmzK";
//Access Tokenの値を格納
$sAccessToken = "182814952-oP1j2OUew3yGgKcxp0MenqB29EoYAEQ0lvfIZblP";
//Access Token Secretの値を格納
$sAccessTokenSecret = "8RpxgErbEKjZGNewOthqLg7RvOsJT1rW5f92aDturS4IT";

//OAuthオブジェクトを生成する
$twObj = new TwitterOAuth($sConsumerKey,$sConsumerSecret,$sAccessToken,$sAccessTokenSecret);

//home_timelineを取得するAPIを利用。Twitterからjson形式でデータが返ってくる
//timeline
$vRequest = $twObj->OAuthRequest("https://api.twitter.com/1.1/statuses/home_timeline.json","GET",array("count"=>"10"));
//follower
$vFollowers = $twObj->OauthRequest("https://api.twitter.com/1.1/followers/ids.json","GET",array('user_id' => '90587805'));
//Jsonデータをオブジェクトに変更
//timelinedecode
$oObj = json_decode($vRequest);
//followerdecode
$fObj = json_decode($vFollowers);
function Request($ID){
    echo "<h1>Request<h1><br/>";
    $vFollowers = $twObj->OauthRequest("https://api.twitter.com/1.1/followers/ids.json","GET",array('user_id' => $ID));
    $fObj = json_decode($vFollowers);
    if(isset($fObj->{'errors'})&& $fObj->{'errors'} !=''){
    
    echo "取得に失敗しました。<br/>
            エラー内容：<br/>
          <pre>";
    echo var_dump($fObj)."</pre>";
}
};
//followrオブジェクト展開
if(isset($fObj->{'errors'})&& $fObj->{'errors'} !=''){
    
    echo "取得に失敗しました。<br/>
            エラー内容：<br/>
          <pre>";
    echo var_dump($fObj)."</pre>";
}else{
	$iIcount=sizeof($fObj->ids);
	$id=$fObj;
    echo $iIcount."</br><pre>";
    $TTL=0;
    for($iIds=0 ; $iIds<$iIcount ; $iIds++){
		echo $iIds."<br/>";
  		echo $fObj->ids[$iIds]."<ht><br/>";
        $followers[$TTL][$iIds]=$fObj->ids[$iIds];
    }

    echo $TTL;
    echo "sizeof".sizeof($followers[$TTL]);
    
    Request($followers[$TTL][1]);
    
    $iIcount=sizeof($fObj->ids);
    for($iIds=0 ; $iIds<$iIcount ; $iIds++){
        request($followers[$TTL--][1]);
		echo $iIds."<br/>";
  		echo $fObj->ids[$iIds]."<ht><b><br/>";
        $followers[$TTL][$iIds]=$fObj->ids[$iIds];
    } 
}

?>



</body>
</html>