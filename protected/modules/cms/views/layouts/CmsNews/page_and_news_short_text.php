<?php
/* Layout strony - news and page
 */

/* Dane startowe */
$page = $this->pageDisplayer->page; // wywolanie $page->pole
/* --- */

$this->beginContent('//layouts/main'); // dla mainApp

echo'<div id="appStore">';
                    echo Uzytkownik::model()->getVideo();
                    echo '<a class="store" href="#"></a>';
                echo '</div>';
//       <div id="left">
//                    <p class="header1">
//                        COMING SOON 
//                        <a href="#">Read more news</a>
//                    </p>
//                    <div class="newsShort">
//                        <h2>We are coming soon to Android platform</h2>
//                        <small>Added 20.01.2012, by <a href="#">John</a></small>
//                        <p class="left">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
//                        <img src="images/img1.jpg" class="right" />
//                        <div class="clear"></div>
//                        <a href="#" class="more">Read more</a>
//                    </div>
//                    <div class="newsShort">
//                        <h2>We are coming soon to Android platform</h2>
//                        <small>Added 20.01.2012, by <a href="#">John</a></small>
//                        <p class="left">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
//                        <img src="images/img1.jpg" class="right" />
//                        <div class="clear"></div>
//                        <a href="#" class="more">Read more</a>
//                    </div>
//                </div>
               echo' <div id="right">
                    <h3>'.$page->title.'</h3>
                   echo $page->short_txt;

                </div>
                <div class="clear"></div>';

//
//echo '<div class="colLeft" style="float:left; width:75%; text-align:justify; padding:5px;">';
//    echo '<h3>'.$page->header.'</h3>';
//    echo $page->txt;        
//echo '</div>';
//    
//echo '<p>';
//
//
//echo '<div class="colRight" style="float:left; width:20%;">';    
//    $this->renderPartial('cms.views.layouts.CmsNews._'.$page->cmsLayouts->col_right);
//echo '</div>';

$this->endContent();


?>