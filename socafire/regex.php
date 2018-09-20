<?php
// method to return time
require_once('simple_html_dom.php');
function return_time($str="1"){
        preg_match("/<noscript>(.*)<\/noscript>/",$str,$newVar);
        list($date,$time)=explode(", " ,$newVar ['1']);
        return $time;     
}

function return_date($str){
        preg_match("/<noscript>(.*)<\/noscript>/",$str,$newVar);
        list($date,$time)=explode(", " ,$newVar ['1']);
        $nwdate=$date+"-2018";
        $result=preg_replace("/(\d+)-(\d+)-(\d+)/", "$3-$2-$1", $nwdate);
        return $result;     
}


//method to remove all the tags
function remove_tag($str){
        $result= preg_replace("#(<[a-zA-Z0-9]+)[^\>]+>#","",$str);  
        return $result;    
}


// method to return home team
function home_team($str){
       // echo $str;
        $result=remove_tag($str);
        // echo $result;

        //list($home,$away)=explode("-",$result);
        //return $home;

}


// method to return away team
function home_away($str){
      
        $result=remove_tag($str);
        list($home,$away)=explode("-",$result);
        return $away;

}
//function to return the preiction
 function prediction($str){
         return  $result=remove_tag($str);
 }

 //function return percenatages
 function percentage($str){
        return  $result=remove_tag($str);
}
function test(){
        $html = file_get_html('<span class="m1"><a href="http://www.zulubet.com/match-515253.html">Inter de Limeira SP - Guarani SP</a></span>');

        foreach($html->find('a')as $r){
               echo $r[0];
        }
}

?>


