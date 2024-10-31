<?php
/*  Copyright 2008  oneviewGMBH  (email : kontakt@oneview.de)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*
Plugin Name: oneview Widget
Plugin URI: http://apps.oneview.de/wordpress/oneviewWidget.zip
Description: oneview Widget
Author: oneview GmbH
Version: 0.1
Author URI: http://oneview.de/
*/
  
  /**
  *oneview Sidebar object
  */
  
  function oneviewSidebarInit() {
    //test if is posible to add widgets
    if ( !function_exists("register_sidebar_widget") ){
        return;
    }   
    
    /**
    *Returns the makeup to bild the the oneview Widget 
    *@return Javascript makeup
    */    
    function oneviewSidebar() {          
              //get options from database
              $options = get_option('oneviewWidgetOptions');
              
              //workaround checkbox true/false
              if($options["border"] != 'true'){
                    $options["border"] = 'false';
              }
              
              //workaround checkbox true/false
              if($options["search"] != 'true'){
                    $options["search"] = 'false';
              }                            
              //bild script src
              $content = '<script src="http://apps.oneview.de/widgets/tag_cloud.js?name='.$options["username"].'&amp;numTags='.$options["tags"].'&amp;bc='.$options["backgroundColor"].'&amp;b='.$options["border"].'&amp;fc1='.$options["frontColor1"].'&amp;fc2='.$options["frontColor2"].'&amp;w='.$options["width"].$options["widthType"].'&amp;t='.$options["title"].'&amp;s='.$options["search"].'&amp;ff='.$options["font"].'&amp;fs='.$options["fontSize"].'" type="text/javascript"></script><noscript>&amp;lt;a href="http://www.oneview.de/'.$options["username"].'" target="_blank"&amp;gt;http://www.oneview.de/quenit&amp;lt;/a&amp;gt;</noscript>';
              //output
              echo $content;
    }
    
    /**
    *Option manager - default options,saving of options, show option form
    */    
  	function oneviewSidebarOptions() {
  		//get option from datebase
      $options = get_option('oneviewWidgetOptions');
      //if there is no data already saved, the default date will be used
  		if ( !is_array($options) )
  			$options = array(
  			    'username'=>'',
            'tags'=>'75',
            'title'=>'Meine Trendwolke',
            'font'=>'Arial, Verdana, sans-serif',
            'fontSize'=>'16',
            'width'=>'190',
            'widthType'=>'px',
            'backgroundColor'=>'rgb(255,255,255)',
            'frontColor1'=>'rgb(2,88,126)',
            'frontColor2'=>'rgb(250,152,0)',
            'border'=> 'true',
            'search'=> 'true'            
  			);
      
      //if the user have clicked on "Save", the changes will be saved
  		if ( $_POST['oneviewSubmit'] ) {
  			$options['username'] = strip_tags(stripslashes($_POST['oneviewUsername']));
  			$options['tags'] = strip_tags(stripslashes($_POST['oneviewTags']));
  			$options['title'] = strip_tags(stripslashes($_POST['oneviewTitle']));
  			$options['font'] = strip_tags(stripslashes($_POST['oneviewFont']));
  			$options['fontSize'] = strip_tags(stripslashes($_POST['oneviewFontSize']));
  			$options['width'] = strip_tags(stripslashes($_POST['oneviewWidth']));
  			$options['widthType'] = strip_tags(stripslashes($_POST['oneviewWidthType']));
  			$options['backgroundColor'] = strip_tags(stripslashes($_POST['oneviewBackgroundColor']));
  			$options['frontColor1'] = strip_tags(stripslashes($_POST['oneviewFrontColor1']));
  			$options['frontColor2'] = strip_tags(stripslashes($_POST['oneviewFrontColor2']));
  			$options['border'] = strip_tags(stripslashes($_POST['oneviewBorder']));
  			$options['search'] = strip_tags(stripslashes($_POST['oneviewSearch']));

        
  			update_option('oneviewWidgetOptions', $options);
  		}
      
      
      //gets the options, if there is already data
  		$username = htmlspecialchars($options['username'], ENT_QUOTES);
  		$tags = htmlspecialchars($options['tags'], ENT_QUOTES);
  		$title = htmlspecialchars($options['title'], ENT_QUOTES);
  		$font = htmlspecialchars($options['font'], ENT_QUOTES);
  		$fontSize = htmlspecialchars($options['fontSize'], ENT_QUOTES);
  		$width = htmlspecialchars($options['width'], ENT_QUOTES);
  		$widthType = htmlspecialchars($options['widthType'], ENT_QUOTES);
  		$backgroundColor = htmlspecialchars($options['backgroundColor'], ENT_QUOTES);
  		$frontColor1 = htmlspecialchars($options['frontColor1'], ENT_QUOTES);
  		$frontColor2 = htmlspecialchars($options['frontColor2'], ENT_QUOTES);
  		$border = htmlspecialchars($options['border'], ENT_QUOTES);
  		$search = htmlspecialchars($options['search'], ENT_QUOTES);
            
  		//output of the form
  		?>
      <style type="text/css" >
          p.oneviewParagraf{ 
              text-align: right;
              margin: 0;
              padding-bottom: 13px;
          }
          
          p.oneviewParagraf input,
          p.oneviewParagraf select
          { 
              width: 200px;
          }
          
          p.oneviewParagraf input.oneviewRadio {
              width: 30px;
          }
      </style>
      
      <script>
          function checkUsername(){
              if(document.getElementById("oneviewUsername").value == ""){              
                    alert("Bitte gebe deinen oneview Benutzernamen an!");  
              }
          }
      
          if (document.getElementById("oneview-widgetcloser").addEventListener){
              document.getElementById("oneview-widgetcloser").addEventListener('click',checkUsername,false);
          }
          if (document.getElementById("oneview-widgetcloser").attachEvent){
              document.getElementById("oneview-widgetcloser").attachEvent('onclick',checkUsername,false);
          }          
          
      </script>
      <?php
      
      //username
      echo '<p class="oneviewParagraf" ><label for="oneviewUsername">oneview Username: <input id="oneviewUsername" name="oneviewUsername" type="text" value="'.$username.'" /></label></p>';
  		//number of tags
      echo '<p class="oneviewParagraf"><label for="oneviewTags">Anzahl Tags: <input id="oneviewTags" name="oneviewTags" type="text" value="'.$tags.'" /></label></p>';
  		//title
      echo '<p class="oneviewParagraf"><label for="oneviewTitle">Titel: <input id="oneviewTitle" name="oneviewTitle" type="text" value="'.$title.'" /></label></p>';

      //font style
  		echo '<p class="oneviewParagraf"><label for="oneviewFont">Schriftart: <select size="1" id="oneviewFont" name="oneviewFont"><option ';

          if($font == 'Arial, Verdana, sans-serif' ){
              echo 'selected="selected"';
          }       
          echo 'value="Arial, Verdana, sans-serif">Arial</option><option ';
          
          if($font == 'Verdana, Arial, sans-serif' ){
              echo 'selected="selected"';
          }  
          echo 'value="Verdana, Arial, sans-serif">Verdana</option><option ';
          
          if($font == 'Times New Roman, Times, serif' ){
              echo 'selected="selected"';
          }              
          echo 'value="Times New Roman, Times, serif">Times New Roman</option><option ';
          
          if($font == 'Times, Times New Roman, serif' ){
              echo 'selected="selected"';
          }      
          echo 'value="Times, Times New Roman, serif">Times</option><option ';
          
          if($font == 'Courier New, Courier, monospace' ){
              echo 'selected="selected"';
          }      
          echo 'value="Courier New, Courier, monospace">Courier New</option><option';
          
          if($font == 'Courier, Courier New, monospace' ){
              echo 'selected="selected"';
          }            
          echo 'value="Courier, Courier New, monospace">Courier</option></select></label></p>';

  		//font size
      echo '<p class="oneviewParagraf"><label for="oneviewFontSize">Schriftgr&ouml;&szlig;e: <input style="width: 179px" id="oneviewFontSize" name="oneviewFontSize" type="text" value="'.$fontSize.'" /></label> px</p>';
      //width
  		echo '<p class="oneviewParagraf"><label for="oneviewWidth">Breite  : <input id="oneviewWidth"  name="oneviewWidth" type="text" value="'.$width.'" /></label></p>';
      
      //width type      
  		echo '<p class="oneviewParagraf"><label style="margin-right:92px;" for="oneviewWidthType">Breite in: <input class="oneviewRadio" id="oneviewWidthTypePixel" name="oneviewWidthType" type="radio"';
          if($widthType == 'px' ){
              echo 'checked="checked"';
          }
          
          echo 'value="px">Pixel</input>&#160;&#160;&#160;<input id="oneviewWidthTypePercent" class="oneviewRadio" name="oneviewWidthType" type="radio"';

          if($widthType == '%' ){
              echo 'checked="checked"';
          }
          
          echo 'value="%">%</input></label></p>';

      //background color
  		echo '<p class="oneviewParagraf"><label for="oneviewbackgroundColor">Hintergrundfarbe: <input id="oneviewBackgroundColor" name="oneviewBackgroundColor" type="text" value="'.$backgroundColor.'" /></label></p>';

  		//fontcolor1
      echo '<p class="oneviewParagraf"><label for="oneviewFrontColor1">Vordergrundfarbe 1: <input id="oneviewFrontColor1" name="oneviewFrontColor1" type="text" value="'.$frontColor1.'" /></label></p>';

  		//frontcolor2
      echo '<p class="oneviewParagraf"><label for="oneviewFrontColor2">Vordergrundfarbe 2: <input id="oneviewFrontColor2" name="oneviewFrontColor2" type="text" value="'.$frontColor2.'" /></label></p>';

      //borders
  		echo '<p class="oneviewParagraf"><label for="oneviewBorder">Rahmen: <input id="oneviewBorder" name="oneviewBorder" type="checkbox" value="true"';

          if($border == 'true' ){
              echo 'checked="checked"';
          }
          
          echo '/></label></p>';

      //search
  		echo '<p class="oneviewParagraf"><label for="oneviewSearch">Suche einbinden: <input id="oneviewSearch" name="oneviewSearch" type="checkbox" value="true"';
          if($search == 'true' ){
              echo 'checked="checked"';
          }
          
          echo '/></label></p>';

  		echo '<input type="hidden" id="oneviewSubmit" name="oneviewSubmit" value="1" />';
  	}		    
    
    //sidebar register
    register_sidebar_widget("oneview Widget", "oneviewSidebar");
    
    //sidebar oprions register
    register_widget_control("oneview Widget", "oneviewSidebarOptions", 400, 450);
  }



//adding the sitebar object
add_action("plugins_loaded", "oneviewSidebarInit");
  
?>