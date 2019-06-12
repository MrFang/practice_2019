<?php

    function getTypes($conn)
    {
        $res = mysqli_query($conn, 'SELECT * FROM content');
        $result = array();

        while($record = mysqli_fetch_array($res)) {
            $result[] = $record;
        }

        return $result;
    }

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
?>