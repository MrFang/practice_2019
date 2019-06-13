<?php

/** Returns array of all records in DB */
function getTypes($conn) {
    $res = mysqli_query($conn, 'SELECT * FROM DocumentTypes');
    $result = array();

    while($record = mysqli_fetch_array($res)) {
        $result[] = $record;
    }

    return $result;
}

/** Adds new record into DB */
function addType($conn, $name, $description, $active) {
    $name = '"'.$name.'"';
    $active = $active == 'true' ? 1 : 0;
    $description = $description == '' ? 'NULL' : '"'.$description.'"';

    mysqli_query(
        $conn,
        'INSERT INTO DocumentTypes (name, description, ifActive) VALUES
        ('.$name.', '.$description.', '.$active.')'
    );
}

/** Returns one record from DB with id == $id */
function getTypeInfo($conn, $id) {
    $res = mysqli_query(
        $conn,
        'SELECT * FROM DocumentTypes WHERE id='.$id    
    );
    
    return mysqli_fetch_array($res);
}

/** Updates one record in DB with id == $id */
function updateType($conn, $id, $name, $description, $active) {
    $name = '"'.$name.'"';
    $active = $active == 'true' ? 1 : 0;
    $description = $description == '' ? 'NULL' : '"'.$description.'"';

    mysqli_query(
        $conn,
        'UPDATE DocumentTypes SET name='.$name.', description='.$description.', ifActive='.$active.' WHERE id='.$id
    );
}

/** Deletes one record from DB with id == $id */
function deleteType($conn, $id) {
    mysqli_query(
        $conn,
        'DELETE FROM DocumentTypes WHERE id='.$id
    );
}

?>