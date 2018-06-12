<?php
//是否首页
// echo "ddd";
// echo file_get_contents("./home.html");
if((is_array($_GET)&&count($_GET)==0)&&(is_array($_POST)&&count($_POST)==0)){
  echo file_get_contents("./home.html");
  die();
}


//数据库信息
  $host = "localhost";
  $user = "root";
  $password = "9306251239zxt";

  //连接数据库
  $db = mysqli_connect($host,$user,$password);
  if(!$db){
    deal_error("无法连接数据库");
  }
  mysqli_query($db,"set names 'utf8'");
  mysqli_select_db($db,"mydatabase");

//是否首页
  if(isset($_GET["first_loaded"])){
    if('true'!=$_GET["first_loaded"]){
      deal_error("参数错误");
    }else{
      first_loaded();
    }
  }else if(isset($_GET["id"])){ //是否获取某篇诗
    if(is_numeric($_GET["id"])){
      get_poem($_GET["id"]);
    }else{
      deal_error("id错误");
    }
  }else if(isset($_GET["name"])){ //是否获取某位诗人的诗
    get_someone_poems($_GET["name"]);
  }else if(isset($_GET["allName"])){
    $authors = array_unique(get_author());
    $authors_str = json_encode($authors);
    $html_str = file_get_contents("./authors.html");
    $html_str = str_replace("<title>Page Title</title>","<title>作者</title>",$html_str);
    $html_str = str_replace("<vuebody></vuebody>","<vuebody style=\"display:none;\" :authors=\"authors\">".$authors_str."</vuebody>",$html_str);
    print_r($html_str);
  }
  
  mysqli_close($db);

//首页加载
function first_loaded(){
  $poems = random_poem();
  foreach($poems as $key => $val){
    //print_r($val['d_intro']);
    unset($val['d_intro']);
    $poems -> $key = $val;
  }
  $author = array_unique(get_author());
  $author_keys = array_rand($author,20);
  $author_obj = new StdClass();
  foreach($author_keys as $key => $val){
    $author_obj -> $key = $author[$val];
  }
  $result = new StdClass();
  $result -> poems = $poems;
  $result -> authors = $author_obj;
  print_r(json_encode($result));
}

//随机十篇诗
function random_poem(){
  $result_array = common_query("SELECT * from poetry ORDER BY RAND() LIMIT 0,10","后台程序错误");
  $result_obj = array2object($result_array);
  return $result_obj;
}

//获取所有作者
function get_author(){
  $result_array = common_query("SELECT d_author from poetry","后台程序错误");
  foreach($result_array as $key=>$val){
    $result_array[$key] = $result_array[$key]["d_author"];
  }
  return $result_array;
}

//获取诗歌
function get_poem($id){
  $result_array = common_query("SELECT * FROM poetry WHERE ID = ".$id,"没有此诗");
  $result_obj = array2object($result_array);
  $result_str = json_encode($result_obj);
  $html_str = file_get_contents("./article.html");
  $title = $result_obj -> {0}['d_title'];
  $html_str = str_replace("<title>Page Title</title>","<title>".$title."</title>",$html_str);
  $html_str = str_replace("<vuebody></vuebody>","<vuebody style=\"display:none;\" >".$result_str."</vuebody>",$html_str);
  print_r($html_str);
  // print_r($result_str);
}

//获取某位作者的诗
function get_someone_poems($name){
  $result_array = common_query("SELECT * FROM poetry WHERE d_author = '".$name."'","没有此作者的诗");
  $result_obj = array2object($result_array);
  print_r(json_encode($result_obj));
}

//查询数据库
function common_query($query_statement,$error_msg){
  global $db;
  $result = mysqli_query($db,$query_statement);
  if(!$result || !mysqli_num_rows($result)){
    deal_error($error_msg);
  }
  
  $result_array = mysqli_fetch_all($result,MYSQL_ASSOC);
  mysqli_free_result($result);
  return $result_array;
}

//查询错误处理
function deal_error($error_msg){
  global $db;
  if($db){
    mysqli_close($db);
  }
  $obj = new StdClass();
  $obj -> errorMsg = $error_msg;
  print_r(json_encode($obj));
  die();
}

//数组和对象的转换
//数组转对象
function array2object($array) {
  if (is_array($array)) {
    $obj = new StdClass();
    foreach ($array as $key => $val){
      $obj->$key = $val;
    }
  }
  else { $obj = $array; }
  return $obj;
}
//对象转数组
function object2array($object) {
  if (is_object($object)) {
    foreach ($object as $key => $value) {
      $array[$key] = $value;
    }
  }
  else {
    $array = $object;
  }
  return $array;
}