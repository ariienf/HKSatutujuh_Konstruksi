<?php

class Model {
    protected $db;
    protected $table;

    public function __construct() {
        $this->db = getDB();
    }

    // Ambil semua data
    public function getAll($orderBy = 'id ASC') {
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY {$orderBy}");
        return $stmt->fetchAll();
    }

    // Ambil data berdasarkan ID
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Ambil data dengan kondisi WHERE
    public function getWhere($column, $value) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$column} = ?");
        $stmt->execute([$value]);
        return $stmt->fetchAll();
    }

    // Ambil satu baris dengan kondisi WHERE
    public function getOneWhere($column, $value) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$column} = ? LIMIT 1");
        $stmt->execute([$value]);
        return $stmt->fetch();
    }

    // Insert data baru
    public function insert($data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $stmt = $this->db->prepare(
            "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})"
        );
        $stmt->execute(array_values($data));
        return $this->db->lastInsertId();
    }

    // Update data
    public function update($id, $data, $primaryKey = 'id') {
        $setClause = implode(', ', array_map(fn($col) => "{$col} = ?", array_keys($data)));

        $stmt = $this->db->prepare(
            "UPDATE {$this->table} SET {$setClause} WHERE {$primaryKey} = ?"
        );
        $values = array_values($data);
        $values[] = $id;
        $stmt->execute($values);
        return $stmt->rowCount();
    }

    // Hapus data
    public function delete($id, $primaryKey = 'id') {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE {$primaryKey} = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }

    // Hitung total data
    public function count() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM {$this->table}");
        return $stmt->fetch()['total'];
    }

    // Query custom (SELECT)
    public function query($sql, $params = []) {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // Query custom satu baris
    public function queryOne($sql, $params = []) {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    }

    // Query custom tanpa return (INSERT/UPDATE/DELETE)
    public function execute($sql, $params = []) {
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }
}
