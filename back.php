<?php

    function getAllTypes($conn)
    {
        $res = mysqli_query($conn, 'SELECT * FROM content');
        $result = array();

        while($record = mysqli_fetch_array($res)) {
            $result[] = $record;
        }

        return $result;
    }

    function getTypes($conn) {
        $res = mysqli_query($conn, 'SELECT * FROM DocumentTypes WHERE ifActive=1');
        $result = array();

        while($record = mysqli_fetch_array($res)) {
            $result[] = $record;
        }

        return $result;
    }
?>