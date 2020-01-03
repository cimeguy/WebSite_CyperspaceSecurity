<?php
function check_sign_up($link){
    if(!$student_id = is_login($link)){
        return false;
    }
    else{
        return $student_id;
    }
}
?>
<!-- prompt("请填写作业号"); -->