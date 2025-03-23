<?php
require 'config.php';

if (isset($_GET['id'])) {
    try {
        $stmt = $pdo->prepare("
            SELECT 
                v.*, 
                r.nombre AS region, 
                vu.nombre AS variedad, 
                c.nombre AS crianza 
            FROM vinos v
            JOIN regiones r ON v.region_id = r.id
            JOIN variedades_uva vu ON v.variedad_id = vu.id
            JOIN crianzas c ON v.crianza_id = c.id
            WHERE v.id = :id
        ");
        $stmt->execute([':id' => $_GET['id']]);
        $vino = $stmt->fetch();
        echo json_encode($vino);
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}