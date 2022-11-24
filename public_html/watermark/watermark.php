<?
  
$img_url = $_SERVER['DOCUMENT_ROOT'].$_SERVER['REQUEST_URI'];
$info_w = @getImageSize("watermark.png");
$info_o = @getImageSize($img_url);
$watermark = $info_o[0] > $info_w[0] ? 'watermark.png' : 'watermark-small.png';


waterMark($_SERVER['DOCUMENT_ROOT'].$_SERVER['REQUEST_URI'], $watermark, "middle=0,center=0");

function waterMark($original, $watermark, $placement = 'bottom=5,right=5', $destination = null) {
   $original = urldecode($original);
   $info_o = @getImageSize($original);
   if (!$info_o)
         return false; 
   $info_w = @getImageSize($watermark); 
   if (!$info_w) 
         return false; 

   list ($vertical, $horizontal) = explode(',', $placement,2);
   list($vertical, $sy) = explode('=', trim($vertical),2);
   list($horizontal, $sx) = explode('=', trim($horizontal),2);
	
   switch (trim($vertical)) { 
      case 'bottom': 
         $y = $info_o[1] - $info_w[1] - (int)$sy; 
         break; 
      case 'middle':
      	
         $y = ceil($info_o[1]/2) - ceil($info_w[1]/2) + (int)$sy;
         break; 
      default: 
         $y = (int)$sy; 
         break; 
      } 

   switch (trim($horizontal)) { 
      case 'right': 
         $x = $info_o[0] - $info_w[0] - (int)$sx; 
         break; 
      case 'center': 
         $x = ceil($info_o[0]/2) - ceil($info_w[0]/2) + (int)$sx;
         break; 
      default: 
         $x = (int)$sx; 
         break; 
      } 

   header("Content-Type: ".$info_o['mime']);
	
	
   
   $original = @imageCreateFromString(file_get_contents($original)); 
   $watermark = @imageCreateFromString(file_get_contents($watermark)); 
   $out = imageCreateTrueColor($info_o[0],$info_o[1]); 

   imageCopy($out, $original, 0, 0, 0, 0, $info_o[0], $info_o[1]);
   
   if( ($info_o[0] > 90) && ($info_o[1] > 90) ){
   		imageCopy($out, $watermark, $x, $y, 0, 0, $info_w[0], $info_w[1]);
   }
   

   switch ($info_o[2]) { 
      case 1: 
         imageGIF($out); 
         break; 
      case 2: 
         imageJPEG($out);
         break; 
      case 3: 
         imagePNG($out); 
         break; 
         } 

   imageDestroy($out); 
   imageDestroy($original); 
   imageDestroy($watermark); 

   return true; 
   }