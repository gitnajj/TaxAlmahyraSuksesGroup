<?php
require_once 'config/database.php';

function getActiveServices() {
    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("SELECT * FROM layanan_pajak WHERE status = 'aktif' ORDER BY nama_layanan");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error fetching services: " . $e->getMessage());
        return [];
    }
}

function getAllServices() {
    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("SELECT * FROM layanan_pajak ORDER BY nama_layanan");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error fetching all services: " . $e->getMessage());
        return [];
    }
}
?>