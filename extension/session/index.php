<?php
session_start();
if (!isset($_SESSION['load'])) {
    $_SESSION['load'] = false;
}
