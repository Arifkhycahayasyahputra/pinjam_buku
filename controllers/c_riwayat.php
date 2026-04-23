<?php
session_start();

require_once "../models/m_riwayat.php";

$riwayat = new m_riwayat();

$data_riwayat = $riwayat->tampil_data();
?>