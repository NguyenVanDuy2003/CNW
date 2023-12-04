<?php
$contacts = [
    [
        'name' => 'Facebook',
        'avt' => 'https://cdn-icons-png.flaticon.com/128/725/725350.png',
        'link' => 'https://www.facebook.com/chungg.203',
    ],
    [
        'name' => 'Instagram',
        'avt' => 'https://cdn-icons-png.flaticon.com/128/4406/4406253.png',
        'link' => 'https://www.instagram.com/Chungg.203',
    ],
    [
        'name' => 'Email',
        'avt' => 'https://cdn-icons-png.flaticon.com/128/1161/1161776.png',
        'link' => 'mailto:liorion.nguyen@gmail.com',
    ],
]
?>
<footer class="w-full column gap-20">
    <div class="w-full d-flex jc-center gap-20">
        <?php
        foreach($contacts as $contact) {
            echo '
            <a href="'. $contact["link"] .'">
                <img class="icon-contact" src="'. $contact['avt'].'"/>
            </a>
        ';
        }
        ?>
    </div>
    <p class="txt-center">INFERNO Copyright © 2021 AcademyLiorion - All rights reserved || Designed By: Liorion&Duy</p>
</footer>