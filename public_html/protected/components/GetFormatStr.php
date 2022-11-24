<?php

    class GetFormatStr{
        public function get_correct_str($num, $str1, $str2, $str3) {
          $val = $num % 100;
      
          if ($val > 10 && $val < 20) 
              return $str3;
      
          else {
              $val = $num % 10;
              if ($val == 1) return $str1;
              elseif ($val > 1 && $val < 5) return $str2;
              else return $str3;
          }
      }
    }
		