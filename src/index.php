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
    if('q_' === substr($_GET["name"],0,2)){
      search($_GET["name"]);
    }else{
      get_someone_poems($_GET["name"]);
    }
  }else if(isset($_GET["allName"])){  //是否获取作者列表
    $authors = array_unique(get_author());
    $authors_str = json_encode($authors);
    $title = '作者';
    replace_template('./authors.html',$title,"<vuebody style=\"display:none;\" :authors=\"authors\">".$authors_str."</vuebody>");
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
  $result_array = common_query("SELECT ID,d_author,d_title,d_poetry from poetry ORDER BY RAND() LIMIT 0,10","后台程序错误");
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
  $title = $result_obj -> {0}['d_title'];
  replace_template('./article.html',$title,"<vuebody style=\" display: none;\">".$result_str."</vuebody>");
}

//获取某位作者的诗
function get_someone_poems($name){
  $query = "SELECT ID,d_author,d_title,d_poetry FROM poetry WHERE d_author = '".$name."'";
  $step = 20;
  if('all' === $name){
    $query = "SELECT ID,d_author,d_title,d_poetry FROM poetry";
  }
  if(isset($_GET['p'])){
    $start = ($_GET['p'] - 1) * $step;
    $query .= " LIMIT ".$start.",".$step;
  }
  $result_array = common_query($query,"没有此作者的诗");
  $result_obj = array2object($result_array);

  if(!isset($_GET['p'])){
    $result_obj = new StdClass();
    $result_obj -> name = $name;
    $result_obj -> totalPage = ceil(count($result_array)/$step);
    $result_obj -> poems = array2object(array_slice($result_array,0,$step));
  }

  if('all' === $name){
    $title = '所有诗歌';
  }else{
    $title = $name;
  }
  $result_str = json_encode($result_obj);
  if(!isset($_GET['p'])){
    $content = "<vuebody style=\" display: none;\" :info=\"info\">".$result_str."</vuebody>";
    replace_template('./poems.html',$title,$content);
  }else{
    print_r($result_str);
  }
  
}

//关键字查询
function search($keyword){
  $step = 20;
  $start = 0;
  $name = substr($keyword,4);
  if('al' === substr($keyword,2,2)){
    $result_obj_all = new StdClass();
    for($i = 0;$i < 3;$i++){
      if(0 === $i){
        $query = "SELECT ID,d_author,d_title,d_poetry FROM poetry WHERE d_author LIKE '".$name."%'";
        $send_name = "q_au".$name;
      }else if(1 === $i){
        $query = "SELECT ID,d_author,d_title,d_poetry FROM poetry WHERE d_poetry LIKE '%".$name."%'";
        $send_name = "q_po".$name;
      }else{
        $query = "SELECT ID,d_author,d_title,d_poetry FROM poetry WHERE d_title LIKE '%".$name."%'";
        $send_name = "q_ti".$name;
      }
      $result_array = common_query($query,"search");
      if(1 === $i){
        foreach($result_array as $key => $val){
          $result_array[$key]['d_poetry'] = str_replace($name,"<span style = \"color: red;\">".$name."</span>",$result_array[$key]['d_poetry']);
        }
      }else if(2 === $i){
        foreach($result_array as $key => $val){
          $result_array[$key]['d_title'] = str_replace($name,"<span style = \"color: red;\">".$name."</span>",$result_array[$key]['d_title']);
        }
      }
      $result_obj = new StdClass();
      $result_obj -> name = $send_name;
      $result_obj -> totalPage = ceil(count($result_array)/$step);
      $result_obj -> poems = array2object(array_slice($result_array,0,$step));
      if(0 === $i){
        $result_obj_all -> author = $result_obj;
      }else if(1 === $i){
        $result_obj_all -> poetry = $result_obj;
      }else{
        $result_obj_all -> title = $result_obj;
      }
    }
    $result_str = json_encode($result_obj_all,JSON_HEX_TAG);
    $title = "搜索-".$name;
    $content = "<vuebody style=\" display: none;\" :info=\"info\">".$result_str."</vuebody>";
    replace_template('./search.html',$title,$content);
    // print_r(json_encode($result_obj_all));
  }else{
    $start = ($_GET['p'] - 1) * $step;
    $temp = "SELECT ID,d_author,d_title,d_poetry FROM poetry WHERE ";
    if('au' === substr($keyword,2,2)){
      $query = $temp."d_author LIKE '".$name."%' LIMIT ".$start.",".$step;
    }else if('po' === substr($keyword,2,2)){
      $query = $temp."d_poetry LIKE '%".$name."%' LIMIT ".$start.",".$step;
    }else{
      $query = $temp."d_title LIKE '%".$name."%' LIMIT ".$start.",".$step;
    }
    $result_array = common_query($query,"search");
    if('po' === substr($keyword,2,2)){
      foreach($result_array as $key => $val){
        $result_array[$key]['d_poetry'] = str_replace($name,"<span style = \"color: red;\">".$name."</span>",$result_array[$key]['d_poetry']);
      }
    }else if('ti' === substr($keyword,2,2)){
      foreach($result_array as $key => $val){
        $result_array[$key]['d_title'] = str_replace($name,"<span style = \"color: red;\">".$name."</span>",$result_array[$key]['d_title']);
      }
    }
    print_r(json_encode(array2object($result_array),JSON_HEX_TAG));
  }
}

//查询数据库
function common_query($query_statement,$error_msg){
  global $db;
  $result = mysqli_query($db,$query_statement);
  if(!$result || !mysqli_num_rows($result)){
    if($result && !mysqli_num_rows($result) && 'search' === $error_msg){
      $result_array = array("ID"=>"","d_author"=>"无记录","d_title"=>"","d_poetry"=>"");
      return [$result_array];
    }
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

//替换模板
function replace_template($path,$title,$content){
  $html_str = file_get_contents($path);
  $html_str = str_replace("<title>Page Title</title>","<title>".$title."</title>",$html_str);
  $html_str = str_replace("<vuebody></vuebody>",$content,$html_str);
  print_r($html_str);
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