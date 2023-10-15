<?php
function Popover($id, $element)
{
    echo "
    <div class='popover d-none' id='popover-$id'>
        $element
    </div>
    ";

    echo "
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        let Element = document.getElementById('$id');
        let popover = document.getElementById('popover-$id');

        Element.addEventListener('click', function (event) {
            event.stopPropagation(); // Ngăn chặn sự kiện click truyền lên header

            // Toggle class d-none trên popover để hiển thị/ẩn nó
            popover.classList.toggle('d-none');
        });

        document.addEventListener('click', function (event) {
            if (!popover.contains(event.target) && event.target !== Element) {
                popover.classList.add('d-none');
            }
        });
    });
    </script>
    ";
}
?>
