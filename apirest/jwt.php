<?php
include('vendor/autoload.php');  
 require 'utils/auth.php';
    echo Auth::SignIn([
        'id' => 1,
        'name' => 'Eduardo'
    ]);

    echo   (
        Auth::Check(
           'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE1ODQzNTU1OTQsImF1ZCI6Ijc2ZTE5YTVkMGFhYzM2YzI4ZDZiMzJiNzIzZTY3ZjAxZjA5YTY3MmMiLCJkYXRhIjp7ImlkIjoxLCJuYW1lIjoiRWR1YXJkbyJ9fQ.4tcCiVPt-TY52G0SV9NQePKPPd8undzNZ6YjTZMQupQ'
        )
    );

        

 
?>