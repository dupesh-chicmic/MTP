<?php
$menuTop = $this->pageDisplayer->mainMenu; 
  echo '<ul id="nav">';            
   foreach($menuTop as $item){
       echo '<li>';
       if( ($item['id'] == 70 || $item['id'] == 72 || $item['id'] == 73) || ($item['parent_id'] == 70) ){
           if(!Yii::app()->user->isGuest){
               if($item['id'] == 70 && !Yii::app()->user->getIsCheckOnly()) {
                   echo '<a id="usedCarsMain" href="#">'.$item->link_name.'</a>';
               }
           }
       }else{
           echo '<a href="index.php?r=cms/cmsPage/displayPage&url='.$item->url.'">'.$item->link_name.'</a>';
       }

       if (isset($this->pageDisplayer->subMenu[$item->id])){
           $len = sizeof($this->pageDisplayer->subMenu[$item->id]); 

           if ($len>0){
               $si=0;
               echo '<ul>';
               foreach($this->pageDisplayer->subMenu[$item->id] as $subPage){

                   if(($subPage['id'] == 66 || $subPage['id'] == 67) && Yii::app()->user->isGuest)
                       continue;

                   
                   $liCss = '';
                   switch($subPage['id'])
                   {
                        case 72 :
                            $liCss = 'liUsedCars';
                            break;
                        case 73 :
                            $liCss = 'liUsedCommCars';
                            break;
                   }
                   
                   
                   echo '<li id="'.$liCss.'">';
                       if($si==0){
                           echo '  <div class="ie ieTR"></div>
                                   <div class="ie ieTL"></div>
                                   <div class="ie ieBR"></div>';
                       }
                              if($subPage['id'] == 72){
                                  //used car guide
                                  if(Uzytkownik::model()->carOrComGuideVisibility_trialIncluded('used_cars', Yii::app()->user->getId())){
                                      echo '<div class="ie ieWrapper">';
                                      echo '<a id="usedCarsSubmenu" href="#">'.$subPage['link_name'].'</a>';
                                      
                                      echo '<ul id="usedCarsSelect">';
                                      echo '<li><div class="ieWrapper"><a href="'.Yii::app()->createUrl("member/usedCarsIFrame", array()).'">By Make/Model</a></div></li>';
                                      echo '<li><div class="ieWrapper"><a style="border-left: 1px solid #aeafac !important" href="'.Yii::app()->createUrl("registrationService/usedCarsLookupIFrame", array()).'">By Reg Lookup</a></div></li>';
                                      echo '</ul>';
                                      
                                      echo '</div>';
                                  }
                              }else if($subPage['id'] == 73){
                                  //used comm guide
                                  if(Uzytkownik::model()->carOrComGuideVisibility_trialIncluded('used_com_cars', Yii::app()->user->getId())){
                                      echo '<div class="ie ieWrapper">';
                                      echo '<a href="#">'.$subPage['link_name'].'</a>';        
                                      
                                      echo '<ul id="usedCarsCommSelect">';
                                      echo '<li><div class="ieWrapper"><a href="'.Yii::app()->createUrl("member/usedCommercialIFrame", array()).'">By Make/Model</a></div></li>';
                                      echo '<li><div class="ieWrapper"><a href="'.Yii::app()->createUrl("registrationService/usedCommercialLookupIFrame", array()).'">By Reg Lookup</a></div></li>';
                                      echo '</ul>';
                                      
                                      echo '</div>';
                                  }
                              }else if($subPage['id'] == 83){
                                  // archive
                                  //if(Uzytkownik::model()->carOrComGuideVisibility_trialIncluded('used_com_cars', Yii::app()->user->getId())){
                                  //if(Uzytkownik::model()->trialOn()){
                                      echo '<div class="ie ieWrapper">';
                                      echo '<a href="index.php?r=cms/cmsPage/displayPage&url='.$subPage['url'].'">'.$subPage['link_name'].'</a>';        
                                      echo '</div>';
                                  //}     
                              }else if($subPage['id'] == 66 || $subPage['id'] == 67){
                                  // New Prices cars / commercial
                                  if(!Yii::app()->user->isGuest){
                                       echo '<div class="ie ieWrapper">';
                                       echo '<a href="index.php?r=cms/cmsPage/displayPage&url='.$subPage['url'].'">'.$subPage['link_name'].'</a>';
                                       echo '</div>';
                                  }                                               
                              }else{
                                  echo '<div class="ie ieWrapper">';
                                  echo '<a href="index.php?r=cms/cmsPage/displayPage&url='.$subPage['url'].'">'.$subPage['link_name'].'</a>';
                                  echo '</div>';
                              }
                   echo '</li>';
                   $si++;
               } 
                echo '</ul>';
           }
       }
       echo '</li>';


   }

echo '</ul>'; //nav 
?>