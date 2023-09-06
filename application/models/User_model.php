<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_model
{
    public function getActivity($id_user)
    {
        $query = "SELECT *
                  FROM tb_activity
                  WHERE sess_id = $id_user
                  ORDER BY id_activity DESC";
        return $this->db->query($query)->result_array();
    }

    public function getKasMasuk($id_user)
    {
        $query = "SELECT *
                  FROM kas_masuk JOIN mst_user 
                  ON kas_masuk.operator_kas_masuk = mst_user.id_user
                  WHERE kas_masuk.operator_kas_masuk = $id_user
                  ORDER BY id_kas_masuk DESC";
        return $this->db->query($query)->result_array();
    }

    public function getKasKeluar($id_user)
    {
        $query = "SELECT *
                  FROM kas_keluar JOIN mst_user 
                  ON kas_keluar.operator_kas_keluar = mst_user.id_user
                  WHERE kas_keluar.operator_kas_keluar = $id_user
                  ORDER BY id_kas_keluar DESC";
        return $this->db->query($query)->result_array();
    }

    public function getLapKasMasuk($tanggal, $id_user)
    {
        $query = "SELECT *
                  FROM kas_masuk JOIN mst_user 
                  ON kas_masuk.operator_kas_masuk = mst_user.id_user
                  WHERE DATE(tgl_kas_masuk) = '$tanggal' AND kas_masuk.operator_kas_masuk = $id_user";
        return $this->db->query($query)->result_array();
    }


    public function getLapKasKeluar($tanggal, $id_user)
    {
        $query = "SELECT *
                  FROM kas_keluar JOIN mst_user 
                  ON kas_keluar.operator_kas_keluar = mst_user.id_user
                  WHERE DATE(tgl_kas_keluar) = '$tanggal' AND kas_keluar.operator_kas_keluar = $id_user";
        return $this->db->query($query)->result_array();
    }
}
