<?php require_once("../setting.fya"); ?>

<?php
$json_string = file_get_contents(FindHostAdmin()."/jsonCustomer/jsondata/CustomersData.json");
$parsed_json = json_decode($json_string, true);


echo count($parsed_json)." Customer Data Found";
echo "<br>";

function filterHouseSparrow($obj)
{
    return $obj->CustomerFullName == "Chetali";
}
$houseSparrow = array_filter($parsed_json, 'filterHouseSparrow');

print_r($houseSparrow);
?>