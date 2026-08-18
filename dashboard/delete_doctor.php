<?php
include("../config/config.php");

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM doctors WHERE id = ?");
$stmt->execute([$id]);

header("Location: manage_doctors.php");