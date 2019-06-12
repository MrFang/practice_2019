<?php
header('Content-Type: text/html; charset=utf-8');
$conn = mysqli_connect('localhost', 'zolotukhin', 'fn9k5dkF', 'zolotukhin');
mysqli_set_charset($conn, 'utf-8');

require_once('./back.php');

$page = $_GET['action'];

switch($page) {
    case 'create':
        $title = 'Add document type';
        break;
    case 'read':
        $title = 'Document types';
        break;
    case 'update':
        $title = 'Edit document type';
        break;
    case 'delete':
        $title = 'Delete document type';
        break;
}

include 'template.html';

?>