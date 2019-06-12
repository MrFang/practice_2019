<?php
header('Content-Type: text/html; charset=utf-8');
$conn = mysqli_connect('localhost', 'zolotukhin', 'fn9k5dkF', 'zolotukhin');
mysqli_set_charset($conn, 'utf-8');

require_once('./back.php');

/** Processing */
if (isset($_POST['action'])) {
    switch($_POST['action']) {
        case 'create':
            addType($conn, $_POST['name'], $_POST['description'], $_POST['active']);
            break;
        case 'update':
            // TODO: Invoke update func
            break;
        case 'delete':
            // TODO: Invoke delete func
            break; 
    }
}

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

function renderDocumentTable($conn) {
    $records = getTypes($conn);
    $result = '<table class="table">';
    $result.='<tr><td>id</td><td>text</td></tr>';

    for ($i = 0; $i < count($records); $i++) {
        $result.='<tr><td>'.$records[$i]['id'].'</td><td>'.$records[$i]['text'].'</td></tr>';
    }

    $result.='</table>';

    return $result;
}

function renderAddForm() {
    $result = '<form method="POST" action="./front.php">';
    $result.= '<input type="hidden" name="action" value="create">';
    $result.= 'NAME: <input type="text" name="name" required><br/>';
    $result.= 'DESCRIPRION: <textarea name="description"></textarea><br/>';
    $result.= 'ACTIVE: <select name="active" required><option>true</option><option>false</option></select><br/>';
    $result.= '<input type="submit" value="Add">';
    $result.='</form>';

    return $result;
}

include 'template.html';

?>