<?php
  $f_loaded = $_GET["first_loaded"];
  $db = mysqli_connect("localhost","root","9306251239zxt");
  if(!$db){
    die("error");
  }
  mysqli_query($db,"set names 'utf8'");
  mysqli_select_db($db,"mydatabase");
  if('true'!=$f_loaded){
    die("error");
  }else{
    first_loaded();
  }
  mysqli_close($db);


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

function random_poem(){
  global $db;
  $query="SELECT * from poetry ORDER BY RAND() LIMIT 0,10";
  $result = mysqli_query($db,$query);
  $result_array = mysqli_fetch_all($result,MYSQLI_ASSOC);
  if($result_array){
    $result_obj = array2object($result_array);
    mysqli_free_result($result);
    return $result_obj;
  }else{
    die("error");
  }
}

function get_author(){
  global $db;
  $query = "SELECT d_author from poetry";
  $result = mysqli_query($db,$query);
  $result_array = mysqli_fetch_all($result,MYSQLI_ASSOC);
  if($result_array){
    mysqli_free_result($result);
    foreach($result_array as $key=>$val){
      $result_array[$key] = $result_array[$key]["d_author"];
    }
    return $result_array;
  }else{
    die("error");
  }
}

//数组和对象的转换
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