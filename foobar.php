<?php

for ($x = 1; $x <= 100; $x++) {
    if (fmod($x, 3) == 0) {        
        if(fmod($x, 5) == 0){
            $data = "foobar";
        }else{
            $data = "foo";
        }
    } else if (fmod($x, 5) == 0) {
        if(fmod($x, 3) == 0){
            $data = "foobar";
        }else{
            $data = "bar";
        }
    } else{
        $data = $x;
    }
   
    echo $data . ", ";
}
