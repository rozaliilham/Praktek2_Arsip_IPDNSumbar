<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_model
{

    public function countUserAktif()
    {

        $query = $this->db->query(
            "SELECT COUNT(id_user) as jml_user
                               FROM mst_user
                               WHERE is_active = 1"
        );
        if ($query->num_rows() > 0) {
            return $query->row()->jml_user;
        } else {
            return 0;
        }
    }

    public function countUserTidakAktif()
    {

        $query = $this->db->query(
            "SELECT COUNT(id_user) as jml_user
                               FROM mst_user
                               WHERE is_active = 0"
        );
        if ($query->num_rows() > 0) {
            return $query->row()->jml_user;
        } else {
            return 0;
        }
    }

    public function countUserBulan()
    {

        $query = $this->db->query(
            "SELECT CONCAT(YEAR(date_created),'/',MONTH(date_created)) AS tahun_bulan, COUNT(*) AS count_bulan
                FROM mst_user
                WHERE CONCAT(YEAR(date_created),'/',MONTH(date_created))=CONCAT(YEAR(NOW()),'/',MONTH(NOW()))
                GROUP BY YEAR(date_created),MONTH(date_created);"
        );
        if ($query->num_rows() > 0) {
            return $query->row()->count_bulan;
        } else {
            return 0;
        }
    }

    public function countAllUser()
    {
        $query = $this->db->query(
            "SELECT COUNT(id_user) as count_all
                               FROM mst_user"
        );
        if ($query->num_rows() > 0) {
            return $query->row()->count_all;
        } else {
            return 0;
        }
    }

    public function getKasMasuk()
    {
        $query = "SELECT *
                  FROM kas_masuk JOIN mst_user 
                  ON kas_masuk.operator_kas_masuk = mst_user.id_user
                  ORDER BY id_kas_masuk DESC";
        return $this->db->query($query)->result_array();
    }

    public function getLapKasMasuk($tanggal)
    {
        $query = "SELECT *
                  FROM kas_masuk JOIN mst_user 
                  ON kas_masuk.operator_kas_masuk = mst_user.id_user
                  WHERE DATE(tgl_kas_masuk) = '$tanggal'";
        return $this->db->query($query)->result_array();
    }

    public function getKasKeluar()
    {
        $query = "SELECT *
                  FROM kas_keluar JOIN mst_user 
                  ON kas_keluar.operator_kas_keluar = mst_user.id_user
                  ORDER BY id_kas_keluar DESC";
        return $this->db->query($query)->result_array();
    }

    public function getLapKasKeluar($tanggal)
    {
        $query = "SELECT *
                  FROM kas_keluar JOIN mst_user 
                  ON kas_keluar.operator_kas_keluar = mst_user.id_user
                  WHERE DATE(tgl_kas_keluar) = '$tanggal'";
        return $this->db->query($query)->result_array();
    }

    public function getFilterPeriodeKasMasuk($tanggal1, $tanggal2)
    {
        $query = "SELECT *
                  FROM kas_masuk JOIN mst_user 
                  ON kas_masuk.operator_kas_masuk = mst_user.id_user
                  WHERE DATE(tgl_kas_masuk) BETWEEN '$tanggal1' AND '$tanggal2'
                  ORDER BY id_kas_masuk DESC";
        return $this->db->query($query)->result_array();
    }

    public function getFilterPeriodeKasKeluar($tanggal1, $tanggal2)
    {
        $query = "SELECT *
                  FROM kas_keluar JOIN mst_user 
                  ON kas_keluar.operator_kas_keluar = mst_user.id_user
                  WHERE DATE(tgl_kas_keluar) BETWEEN '$tanggal1' AND '$tanggal2'
                  ORDER BY id_kas_keluar DESC";
        return $this->db->query($query)->result_array();
    }
}
