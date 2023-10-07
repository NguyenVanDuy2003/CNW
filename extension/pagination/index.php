<?php
$countCourses = 35;
$pagination = 2;
$countPagination = ceil(35 / 9);
?>
<form class="panigation d-flex gap-10">
    <button class="pointer reverse <?php echo ($pagination == 1) ? 'd-none' : ''; ?>">
        <img class="w-full" src="https://cdn-icons-png.flaticon.com/128/11220/11220336.png" />
    </button>
    <?php
    for ($i = 1; $i <= $countPagination; $i++) {
        echo '
        <button class="pointer ' . ($pagination == $i ? "pagination-choose" : "") . '">' . $i . '</button>
        ';
    }
    ?>
    <button class="pointer <?php echo ($pagination == $countPagination) ? 'd-none' : ''; ?>">
        <img class="w-full" src="https://cdn-icons-png.flaticon.com/128/11220/11220336.png" />
    </button>
</form>