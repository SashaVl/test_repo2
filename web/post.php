<?php
if(!empty($_POST)){
    include 'db.php';
    $db = new db();
    $link = $db->dbConnect();
    $partner = $_POST['partner'];

    $oper = "=";
    if($partner == 'all')
    {
        $oper = "<>";
        $partner = "Main";
    }

    $q = 'SELECT tariffs_internet.title,
SUM(IF(partners.name = \'Main\', statistics.in_bytes,0))AS VM,
SUM(IF(partners.name = \'Main\', statistics.out_bytes,0))AS VM2,
SUM(IF(partners.name '.$oper.' "'.$partner.'", statistics.in_bytes,0))AS ST,
SUM(IF(partners.name '.$oper.' "'.$partner.'", statistics.out_bytes,0))AS ST2
FROM partners INNER JOIN statistics ON partners.id=statistics.partner_id
INNER JOIN tariffs_internet ON tariffs_internet.id=statistics.tariff_id
WHERE YEAR(statistics.start_date)='.$_POST['select'].'
GROUP BY title';
    $res = mysqli_query($link,$q);
    $ans = "<table id='myTable' >
        <tr style='border-bottom: solid #000000 1px;'>
            <td rowspan='2'>".$_POST['select']."</td>
            <td colspan='2' class='bgColor'>Victory media</td>
            <td colspan='2' class='bgColor'>Smiley TV</td>
        </tr>";
    $ans = $ans."<tr style='border-top: solid #000000 1px;border-bottom: solid #000000 2px;'>
                    <td>Download (GB)</td>
                    <td>Upload (GB)</td>
                    <td>Download (GB)</td>
                    <td>Upload (GB)</td>
                </tr>";
    while($result = mysqli_fetch_assoc($res))
    {
        $ans = $ans."<tr style='border: solid #000000 1px;'>
                        <td class='bgColor'>".$result['title']."</td>
                        <td>".$result['VM']."</td>
                        <td>".$result['VM2']."</td>
                        <td>".$result['ST']."</td>
                        <td>".$result['ST2']."</td>
                    </tr>";
    }
    $ans = $ans."</table>";
    echo $ans;

}