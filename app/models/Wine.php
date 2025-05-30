<?php
/**
 * Modelo para gestionar los vinos
 */
class Wine {
    private $db;
    
    /**
     * Constructor
     */
    public function __construct($pdo) {
        $this->db = $pdo;
    }
    
    /**
     * Obtiene todos los vinos
     */
    public function getAll($limit = 12, $offset = 0) {
        $stmt = $this->db->prepare("
            SELECT v.*, 
                t.nombre as tipo_nombre, 
                r.nombre as region_nombre, 
                vu.nombre as variedad_nombre,
                c.nombre as crianza_nombre
            FROM vinos v
            LEFT JOIN tipos_vinos t ON v.tipo_id = t.id
            LEFT JOIN regiones r ON v.region_id = r.id
            LEFT JOIN variedades_uva vu ON v.variedad_id = vu.id
            LEFT JOIN crianzas c ON v.crianza_id = c.id
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    /**
     * Obtiene un vino por su ID
     */
    public function getById($id) {
        $stmt = $this->db->prepare("
            SELECT v.*, 
                t.nombre as tipo_nombre, 
                r.nombre as region_nombre, 
                vu.nombre as variedad_nombre,
                c.nombre as crianza_nombre
            FROM vinos v
            LEFT JOIN tipos_vinos t ON v.tipo_id = t.id
            LEFT JOIN regiones r ON v.region_id = r.id
            LEFT JOIN variedades_uva vu ON v.variedad_id = vu.id
            LEFT JOIN crianzas c ON v.crianza_id = c.id
            WHERE v.id = :id
        ");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    /**
     * Obtiene vinos por tipo
     */
    public function getByType($tipo_id, $limit = 12, $offset = 0) {
        $stmt = $this->db->prepare("
            SELECT v.*, 
                t.nombre as tipo_nombre, 
                r.nombre as region_nombre, 
                vu.nombre as variedad_nombre,
                c.nombre as crianza_nombre
            FROM vinos v
            LEFT JOIN tipos_vinos t ON v.tipo_id = t.id
            LEFT JOIN regiones r ON v.region_id = r.id
            LEFT JOIN variedades_uva vu ON v.variedad_id = vu.id
            LEFT JOIN crianzas c ON v.crianza_id = c.id
            WHERE v.tipo_id = :tipo_id
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindParam(':tipo_id', $tipo_id, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    /**
     * Obtiene vinos por variedad
     */
    public function getByVariety($variedad_id, $limit = 12, $offset = 0) {
        $stmt = $this->db->prepare("
            SELECT v.*, 
                t.nombre as tipo_nombre, 
                r.nombre as region_nombre, 
                vu.nombre as variedad_nombre,
                c.nombre as crianza_nombre
            FROM vinos v
            LEFT JOIN tipos_vinos t ON v.tipo_id = t.id
            LEFT JOIN regiones r ON v.region_id = r.id
            LEFT JOIN variedades_uva vu ON v.variedad_id = vu.id
            LEFT JOIN crianzas c ON v.crianza_id = c.id
            WHERE v.variedad_id = :variedad_id
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindParam(':variedad_id', $variedad_id, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    /**
     * Obtiene vinos por región
     */
    public function getByRegion($region_id, $limit = 12, $offset = 0) {
        $stmt = $this->db->prepare("
            SELECT v.*, 
                t.nombre as tipo_nombre, 
                r.nombre as region_nombre, 
                vu.nombre as variedad_nombre,
                c.nombre as crianza_nombre
            FROM vinos v
            LEFT JOIN tipos_vinos t ON v.tipo_id = t.id
            LEFT JOIN regiones r ON v.region_id = r.id
            LEFT JOIN variedades_uva vu ON v.variedad_id = vu.id
            LEFT JOIN crianzas c ON v.crianza_id = c.id
            WHERE v.region_id = :region_id
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindParam(':region_id', $region_id, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    /**
     * Obtiene vinos por tipo de crianza
     */
    public function getByCrianza($crianza_id, $limit = 12, $offset = 0) {
        $stmt = $this->db->prepare("
            SELECT v.*, 
                t.nombre as tipo_nombre, 
                r.nombre as region_nombre, 
                vu.nombre as variedad_nombre,
                c.nombre as crianza_nombre
            FROM vinos v
            LEFT JOIN tipos_vinos t ON v.tipo_id = t.id
            LEFT JOIN regiones r ON v.region_id = r.id
            LEFT JOIN variedades_uva vu ON v.variedad_id = vu.id
            LEFT JOIN crianzas c ON v.crianza_id = c.id
            WHERE v.crianza_id = :crianza_id
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindParam(':crianza_id', $crianza_id, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    /**
     * Busca vinos por término
     */
    public function search($term, $limit = 12, $offset = 0) {
        $term = '%' . $term . '%';
        
        $stmt = $this->db->prepare("
            SELECT SQL_CALC_FOUND_ROWS v.*, 
                t.nombre as tipo_nombre, 
                r.nombre as region_nombre, 
                vu.nombre as variedad_nombre,
                c.nombre as crianza_nombre
            FROM vinos v
            LEFT JOIN tipos_vinos t ON v.tipo_id = t.id
            LEFT JOIN regiones r ON v.region_id = r.id
            LEFT JOIN variedades_uva vu ON v.variedad_id = vu.id
            LEFT JOIN crianzas c ON v.crianza_id = c.id
            WHERE 
                v.nombre LIKE :term1 OR
                v.descripcion LIKE :term2 OR
                t.nombre LIKE :term3 OR
                r.nombre LIKE :term4 OR
                vu.nombre LIKE :term5
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindParam(':term1', $term, PDO::PARAM_STR);
        $stmt->bindParam(':term2', $term, PDO::PARAM_STR);
        $stmt->bindParam(':term3', $term, PDO::PARAM_STR);
        $stmt->bindParam(':term4', $term, PDO::PARAM_STR);
        $stmt->bindParam(':term5', $term, PDO::PARAM_STR);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        $wines = $stmt->fetchAll();
        
        // Obtener el total de resultados
        $stmt = $this->db->query("SELECT FOUND_ROWS()");
        $total = $stmt->fetchColumn();
        
        return [
            'vinos' => $wines,
            'total' => $total
        ];
    }
    
    /**
     * Crear un nuevo vino
     */
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO vinos (
                nombre, tipo_id, region_id, variedad_id, crianza_id, 
                descripcion, imagen, precio, precio_id
            ) VALUES (
                :nombre, :tipo_id, :region_id, :variedad_id, :crianza_id,
                :descripcion, :imagen, :precio, :precio_id
            )
        ");
        
        return $stmt->execute([
            ':nombre' => $data['nombre'],
            ':tipo_id' => $data['tipo_id'],
            ':region_id' => $data['region_id'],
            ':variedad_id' => $data['variedad_id'],
            ':crianza_id' => $data['crianza_id'],
            ':descripcion' => $data['descripcion'],
            ':imagen' => $data['imagen'],
            ':precio' => $data['precio'],
            ':precio_id' => $data['precio_id']
        ]);
    }
    
    /**
     * Actualizar un vino existente
     */
    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE vinos SET
                nombre = :nombre,
                tipo_id = :tipo_id,
                region_id = :region_id,
                variedad_id = :variedad_id,
                crianza_id = :crianza_id,
                descripcion = :descripcion,
                imagen = :imagen,
                precio = :precio,
                precio_id = :precio_id
            WHERE id = :id
        ");
        
        return $stmt->execute([
            ':id' => $id,
            ':nombre' => $data['nombre'],
            ':tipo_id' => $data['tipo_id'],
            ':region_id' => $data['region_id'],
            ':variedad_id' => $data['variedad_id'],
            ':crianza_id' => $data['crianza_id'],
            ':descripcion' => $data['descripcion'],
            ':imagen' => $data['imagen'],
            ':precio' => $data['precio'],
            ':precio_id' => $data['precio_id']
        ]);
    }
    
    /**
     * Eliminar un vino
     */
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM vinos WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
    
    /**
     * Contar vinos por tipo
     */
    public function countByType($tipo_id) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM vinos WHERE tipo_id = :tipo_id");
        $stmt->execute([':tipo_id' => $tipo_id]);
        return $stmt->fetchColumn();
    }
    
    /**
     * Contar vinos por variedad
     */
    public function countByVariety($variedad_id) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM vinos WHERE variedad_id = :variedad_id");
        $stmt->execute([':variedad_id' => $variedad_id]);
        return $stmt->fetchColumn();
    }
    
    /**
     * Contar vinos por región
     */
    public function countByRegion($region_id) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM vinos WHERE region_id = :region_id");
        $stmt->execute([':region_id' => $region_id]);
        return $stmt->fetchColumn();
    }
    
    /**
     * Contar vinos por crianza
     */
    public function countByCrianza($crianza_id) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM vinos WHERE crianza_id = :crianza_id");
        $stmt->execute([':crianza_id' => $crianza_id]);
        return $stmt->fetchColumn();
    }
} 