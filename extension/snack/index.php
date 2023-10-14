<?php
function showSnack($content, $mode)
{
    $snack = '<div class="' . (!$mode ? 'false' : 'true') . ' snack box-shadow pst-fixed w-20 alert pd-10 d-flex ai-center gap-10 jc-spacebetween">
        <div class="d-flex ai-center gap-10">
            <img class="icon-snack" src="' . (!$mode ? 'https://cdn-icons-png.flaticon.com/128/6711/6711656.png' : 'https://cdn-icons-png.flaticon.com/128/190/190411.png') . '"/>
            <p class="content-snack">' . $content . '</p>
        </div>
        </div>';

    $snack .= '<script>
        setTimeout(function() {
            var snack = document.querySelector(".snack");
            if (snack) {
                snack.style.display = "none";
            }
        }, 2000);
    </script>';

    return $snack;
}
?>