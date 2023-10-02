<?php
function showSnack($content, $mode) {
    if (isset($_POST['delete'])) {
        return ""; 
    } else {
        $snack = '<div class="btn box-shadow pst-fixed w-20 alert pd-10 d-flex ai-center jc-spacebetween">
            <div class="d-flex ai-center gap-10">
                <img class="icon-snack" src="' . (!$mode ? 'https://cdn-icons-png.flaticon.com/128/6711/6711656.png' : 'https://cdn-icons-png.flaticon.com/128/190/190411.png') . '"/>
                <p>' . $content . '</p>
            </div>
            <form method="post">
                <input type="hidden" name="delete" value="1">
                <button type="submit" class="button-delete" name="delete">
                    <img class="w-icon" src="https://cdn-icons-png.flaticon.com/128/657/657059.png" />
                </button>
            </form>
        </div>';
        return $snack;
    }
}
?>