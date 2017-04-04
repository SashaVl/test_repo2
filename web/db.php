<?php

class db
{
    const host = 'localhost';
    const user = 'root';
    const pass = '';
    const db = 'splynx';

    public function dbConnect(){
        return mysqli_connect($this::host,$this::user,$this::pass,$this::db);
    }
    public function yearList($link)
    {
        $n=0;
        $q = "SELECT YEAR(start_date) AS year FROM statistics GROUP BY year";
        $res = mysqli_query($link,$q);

        while($result[$n] = mysqli_fetch_assoc($res))
        {
            $n++;
        }
        unset($result[$n]);
        return $result;
    }
    public function partnerList($link)
    {
        $n=0;
        $q = "SELECT name FROM partners WHERE name <> 'Main'";
        $res = mysqli_query($link,$q);

        while($result[$n] = mysqli_fetch_assoc($res))
        {
            $n++;
        }
        unset($result[$n]);
        return $result;
    }
}