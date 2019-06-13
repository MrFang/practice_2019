<?php

header('Content-Type: text/html; charset=utf-8');
$conn = mysqli_connect('localhost', 'crm', '6QjgPjxQ', 'crm');
mysqli_set_charset($conn, 'utf8');

require_once('./back.php');

/** Processing */
if (isset($_POST['action'])) {
    switch($_POST['action']) {
        case 'create':
            addType($conn, $_POST['name'], $_POST['description'], $_POST['active']);
            break;
        case 'update':
            updateType($conn, $_POST['id'], $_POST['name'], $_POST['description'], $_POST['active']);
            break;
        case 'delete':
            deleteType($conn, $_POST['id']);
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
    $result.='<tr><td>id</td><td>name</td><td>description</td><td>active</td><td>actions</td></tr>';

    for ($i = 0; $i < count($records); $i++) {
        $result.=
        '<tr>'.
        '<td>'.$records[$i]['id'].'</td>'.
        '<td>'.$records[$i]['name'].'</td>'.
        '<td>'.$records[$i]['description'].'</td>'.
        '<td>'.$records[$i]['ifActive'].'</td>'.
        '<td>'.
            '<a href="./front.php?action=update&id='.$records[$i]['id'].'">edit</a><br/>'.
            '<a href="./front.php?action=delete&id='.$records[$i]['id'].'">delete</a>'.
        '</td>'.
        '</tr>';
    }

    $result.='</table>';

    return $result;
}

function renderAddForm() {
    $result = '<form method="POST" action="./front.php?action=read">';
    $result.= '<input type="hidden" name="action" value="create">';
    $result.= 'NAME: <input type="text" name="name" required><br/>';
    $result.= 'DESCRIPRION: <textarea name="description"></textarea><br/>';
    $result.= 'ACTIVE: <select name="active" required><option>true</option><option>false</option></select><br/>';
    $result.= '<input type="submit" value="Add">';
    $result.='</form>';

    return $result;
}

function renderEditForm($conn, $id) {
    $item = getTypeInfo($conn, $id);

    $result = '<form method="POST" action="./front.php?action=read">';
    $result.= '<input type="hidden" name="action" value="update">';
    $result.= '<input type="hidden" name="id" value="'.$id.'">';
    $result.= 'NAME: <input type="text" name="name" required value="'.$item['name'].'"></br>';
    $result.= 'DESCRIPTION: <textarea name="description">'.$item['description'].'</textarea></br>';
    $result.= 'ACTIVE: <select name="active" required>'.
        '<option>'.($item['ifActive'] == 1 ? 'true' : 'false').'</option>'.
        '<option>'.($item['ifActive'] == 1 ? 'false' : 'true').'</option>'.
    '</select><br/>';
    $result.= '<input type="submit" value="Edit">';
    $result.= '</form>';

    return $result;
}

function renderDeleteSubmitionForm($id) {
    $result = '<form method="POST" action="./front.php?action=read">';
    $result.= '<input type="hidden" name="action" value="delete">';
    $result.= '<input type="hidden" name="id" value="'.$id.'">';
    $result.= 'Please, confirm the action <br/>';
    $result.= '<input type="submit" value="Delete">';
    $result.= '</form>';

    return $result;
}

include 'template.html';

?>