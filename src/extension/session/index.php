<?php
session_start();
if (!isset($_SESSION['load'])) {
    $_SESSION['load'] = false;
}
if (!isset($_SESSION['score'])) {
    $_SESSION['score'] = 0;
}
