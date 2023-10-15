<?php
function Modal($id, $element)
{
    echo "
    <div class='modal d-none' id='modal-$id''>
        <div class='box-shadow' id='element-modal-$id'>
            $element
        </div>
    </div>
    ";

    echo "
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        let Element = document.getElementById('$id');
        let modal = document.getElementById('modal-$id');
        let modalContent = document.getElementById('element-modal-$id');

        Element.addEventListener('click', function (event) {
            event.stopPropagation(); // Ngăn chặn sự kiện click truyền lên header

            // Toggle class d-none trên modal để hiển thị/ẩn nó
            modal.classList.toggle('d-none');
        });

        modalContent.addEventListener('click', function (event) {
            event.stopPropagation(); // Ngăn chặn sự kiện click truyền lên modalContent
        });

        document.addEventListener('click', function (event) {
            if (!modalContent.contains(event.target) && event.target !== Element) {
                modal.classList.add('d-none');
            }
        });
    });
    </script>
    ";
}
?>
