<?php
require_once('simple_html_dom.php');
require_once('regex.php');

 $html = file_get_html('http://www.zulubet.com/');
//the above includes work with the scrapping;
require __DIR__.'/vendor/autoload.php';

use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/serviceacount.json');
$firebase=(new Factory) ->withServiceAccount($serviceAccount) ->create();
$db=$firebase->getDatabase();

         $db=$db->getReference('games');
           //loop this process for a number oftimes.

// section to scrap data $rows = []; $pick=[]; $pickcounter=0;

$teamsx=[];
$teamcounter=0;
$current_date=date("Y-m-d");
$current_date="2018-09-19";
$TEAMS=[];
$PREDICTIONS=[];

//  find the rows

$i = 0; foreach ($html->find('table.content_table tr ') as $video) { 
  global $rows; 
  global $i;
   if ($i > 200) { break; }

        $td=[];

        $tdcnt=0; $innercnt=0; // we should skip the first row if($i!=0){
        if($i!=1){ foreach($video->find('td')as $tr)
          {
            global $tdcnt;
            global $td;
            global $innercnt;

                        if ($tdcnt==0){ //echo remove_tag($tr)."<br>";

                        }

                        if ($tdcnt==1)
                        {
                                 global $teams;
                                 global $teamcounter;
                                 global $result;
                                 foreach($tr->find('a')as $r){
                                   global $result;
                                         $result=remove_tag($r);
                                         $result=strip_tags($result);
                                 }

                                 $teamsx[$teamcounter]=$result."Teams";
                                 
                                 $teamcounter++;


                         }

                         if ($tdcnt==9)
                         {
                               global $pick;
                               global $pickcounter;

                                foreach($tr->find('b')as $r)
                                {
                                        $result=$r;
                                        $result=strip_tags($result);
                                        if($result===""){
                                          //echo".........result empty";
                                          $result="...";
                                        }

                                }
                                $pick[$pickcounter]=$result."</br>";
                                //$master_variable([$teamcounter],[1]=$result);

                                $pickcounter++;

                         }

                         $tdcnt++;

                     } } ;

        }

       $i++;


  //done with scrapping

//working with the loop

$teamscount=sizeof($teamsx);
$i=1;
$interval=3;
if( $teamscount>150){
  $i=40;
  $interval=3;

}

if( $teamscount>=60){
  $i=40;
  $interval=2;

}

if( $teamscount<=40){
  $i=20;
  $interval=2;

}

// for($i=0;$i<sizeof($teamsx);$i++){
//   echo $teamsx[$i]." ".$pick[$i-2];
// }


  //echo $teamscount."</br>";
  //echo $teamcounter." ".$pickcounter;
  $entry;//this is to keep todays count;
for(;$i<=$teamscount-1;){

       $prediction=$pick[$i-2];
       $teams=$teamsx[$i];
       $time="0";

       //echo $prediction.$teams.$time."</br>";
       global $current_date;
       $date=$current_date;

       $db->push([
        'teams'=>$teams,
        'a'=>'a',
        'pick'=>$prediction,
        'date'=>$date ]);

       if($pick[$i]!='')
       {      try{
               if($teamsx[$i]!=''){
                 $db->push([
                     'teams'=>$teams,
                     'a'=>'a',
                     'pick'=>$prediction,
                     'date'=>$date ]);
                     global $entry;
                     $entry++;
                   }
                  }catch(Exception $e){
                    echo "failed" .$e.getMessage();
                  }
        }

        $i+=$interval;
}

      //write the enrty to the getDatabase



          echo "data has been inserted"; ?>
