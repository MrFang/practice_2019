<?php

header('Content-Type: text/html; charset=utf-8');
/** Init DB */
$conn = mysqli_connect('localhost', 'crm', '6QjgPjxQ', 'crm');
mysqli_set_charset($conn, 'utf8');

require_once('./back.php');

/** Processing POST requests*/
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

    echo '<p>Success!</p>';
}

/** Set environment */
$page = $_GET['action'];
switch($page) {
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

/** Retutns html table that contains info from DB */
function renderDocumentTable($conn) {
    $records = getTypes($conn);
    $result = '<table border="2">';

    for ($i = 0; $i < count($records); $i++) {
        $result.=
        '<tr>'.
        '<td>'.$records[$i]['id'].'</td>'.
        '<td>'.$records[$i]['name'].'</td>'.
        '<td>'.$records[$i]['description'].'</td>'.
        '<td>'.$records[$i]['ifActive'].'</td>'.
        '<td><a href="./front.php?action=update&id='.$records[$i]['id'].'">Edit</a></td>'.
        '<td><a href="./front.php?action=delete&id='.$records[$i]['id'].'">Delete</a></td>'.
        '</tr>';
    }

    $result.='</table>';
    
    return $result;
}

/** Returns form to add new document type into DB */
function renderAddForm() {
    $result = '<p> Добавить новую запись</p>';
    $result.= '<form method="POST" action="./front.php?action=read">';
    $result.= '<input type="hidden" name="action" value="create">';
    $result.= '<table>';
    $result.= '<tr><td>NAME:</td><td><input type="text" name="name" required></td></tr>';
    $result.= '<tr><td>DESCRIPTION:</td><td><textarea name="description"></textarea></td></tr>';
    $result.= '<tr><td>ACTIVE:</td><td><select name="active" required><option>true</option><option>false</option></select></td></tr>';
    $result.= '<tr><td colspan="2"><input type="submit" value="Add"></td></tr>';
    $result.= '</table>';
    $result.='</form>';

    return $result;
}

/** Returns form to edit existing document type */
function renderEditForm($conn, $id) {
    $item = getTypeInfo($conn, $id);

    $result = '<p>Изменить запись</p>';
    $result.= '<form method="POST" action="./front.php?action=read">';
    $result.= '<input type="hidden" name="action" value="update">';
    $result.= '<input type="hidden" name="id" value="'.$id.'">';
    $result.= '<table>';
    $result.= '<tr><td>NAME:</td><td><input type="text" name="name" required value="'.$item['name'].'"></td></tr>';
    $result.= '<tr><td>DESCRIPTION:</td><td><textarea name="description">'.$item['description'].'</textarea></td></tr>';
    $result.= '<tr><td>ACTIVE:</td><td><select name="active" required>'.
        '<option>'.($item['ifActive'] == 1 ? 'true' : 'false').'</option>'.
        '<option>'.($item['ifActive'] == 1 ? 'false' : 'true').'</option>'.
    '</select></td></tr>';
    $result.= '<tr><td colspan="2"><input type="submit" value="Edit"></td></tr>';
    $result.= '</table>';
    $result.= '</form>';

    return $result;
}

/** Returns form that asks user's confirmation to delete existing document type */
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