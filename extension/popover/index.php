<?php
function Popover($id, $element)
{
    echo "
    <div class='popover d-none'>
        $element
    </div>
    ";

    echo '
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        var contactMenu = document.getElementById("' . $id . '");
        var popover = document.querySelector(".popover");

        // Xử lý sự kiện click vào #contact-menu
        contactMenu.addEventListener("click", function (event) {
            event.stopPropagation(); // Ngăn chặn sự kiện click truyền lên header

            // Toggle class d-none trên popover để hiển thị/ẩn nó
            popover.classList.toggle("d-none");
        });

        // Xử lý sự kiện click bên ngoài popover để ẩn nó
        document.addEventListener("click", function (event) {
            if (!popover.contains(event.target) && event.target !== contactMenu) {
                popover.classList.add("d-none");
            }
        });
    });
    </script>
    ';
}
?>
