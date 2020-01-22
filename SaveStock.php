<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>
<?
$DB = Connect();
$result = "UPDATE tblProductStocks set " . $_POST["column"] . " = '".$_POST["editval"]."' WHERE  ProductID=".$_POST["ProductID"]);
?>