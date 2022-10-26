<?php
    $CI =& get_instance();
    $CI->load->model('Web_settings');
    $Web_settings = $CI->Web_settings->retrieve_setting_editdata();
?>
<footer class="main-footer">
    <p>Made by <strong>KABUGOK Team </strong><i class="fa fa-heart color-red"></i></p>
</footer>