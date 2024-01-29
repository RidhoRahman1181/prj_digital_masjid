<?php


namespace App\Models;

use CodeIgniter\Model;

class ModelPengurus extends Model
{
        public function getPengurus()
        {
                $builder = $this->db->table('tbl_pengurus');
                return $builder->get();
        }
        public function savePengurus($data)
        {
                $query = $this->db->table('tbl_pengurus')->insert($data);
                return $query;
        }

        public function deletepengurus($id)
        {
                $query = $this->db->table('tbl_pengurus')->delete(array('id_pengurus' => $id));
                return $query;
        }
        public function updatepengurus($data, $id)
        {
                $query = $this->db->table('tbl_pengurus')->update($data, array('id_pengurus' => $id));
                return $query;
        }
}
