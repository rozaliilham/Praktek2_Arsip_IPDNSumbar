<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        is_user();
        $this->load->helper('ata');
        $this->load->helper('tglindo');
        $this->load->helper('rupiah');
        $this->load->model('User_model', 'user');
    }

    public function index()
    {
        $data['title'] = 'Beranda';
        $data['user'] = $this->db->get_where('mst_user', ['id_user' => $this->session->userdata('id_user')])->row_array();
        $data['activity'] = $this->user->getActivity($this->session->userdata('id_user'));

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_user', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }

    public function edit_profile()
    {
        $upload_image = $_FILES['image']['name'];
        if ($upload_image) {
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size']     = '2048';
            $config['upload_path'] = './assets/dist/img/profile/';
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('image')) {
                $data['user'] = $this->db->get_where('mst_user', ['id_user' => $this->session->userdata('id_user')])->row_array();
                $old_image = $data['user']['image'];
                if ($old_image != 'default.png') {
                    unlink(FCPATH . 'assets/dist/img/profile/' . $old_image);
                }
                $new_image = $this->upload->data('file_name');
                $this->db->set('image', $new_image);
            } else {
                echo $this->upload->display_errors();
            }
        }
        $nama = $this->input->post('nama');
        $this->db->set('nama', $nama);
        $this->db->where('id_user', $this->session->userdata('id_user'));
        $this->db->update('mst_user');
        $data2 = [
            'sess_id' => $this->session->userdata('id_user'),
            'activity' => 'Mengubah profil Akun',
            'date_activity' => date('Y-m-d'),
            'time_activity' => date('H:i:s')
        ];
        $this->db->insert('tb_activity', $data2);
        $this->session->set_flashdata('message', 'Simpan Perubahan');
        redirect('user/index');
    }

    public function ubah_password()
    {
        $current_password = $this->input->post('current_password');
        $new_password = $this->input->post('new_password1');
        if ($current_password == $new_password) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger font-weight-bolder text-center" role="alert">Ubah Password Gagal !! <br> Password baru tidak boleh sama dengan password lama</div>');
            redirect('user/index');
        } else {
            $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $this->db->set('password', $password_hash);
            $this->db->where('id_user', $this->session->userdata('id_user'));
            $this->db->update('mst_user');
            $data2 = [
                'sess_id' => $this->session->userdata('id_user'),
                'activity' => 'Mengubah Password Akun',
                'date_activity' => date('Y-m-d'),
                'time_activity' => date('H:i:s')
            ];
            $this->db->insert('tb_activity', $data2);
            $this->session->set_flashdata('message', 'Ubah Password');
            redirect('user/index');
        }
    }

    public function kas_masuk()
    {
        $this->form_validation->set_rules('no_kas_masuk', 'No Jurnal', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Data Kas Masuk';
            $data['user'] = $this->db->get_where('mst_user', ['id_user' => $this->session->userdata('id_user')])->row_array();
            $data['kas_masuk'] = $this->user->getKasMasuk($this->session->userdata('id_user'));

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_user', $data);
            $this->load->view('user/kas_masuk', $data);
            $this->load->view('templates/footer');
        } else {
            $data = array(
                'no_kas_masuk' => $this->input->post('no_kas_masuk', true),
                'outlet_kas_masuk' => $this->input->post('outlet_kas_masuk', true),
                'tgl_kas_masuk' => $this->input->post('tgl_kas_masuk', true),
                'jml_kas_masuk' => $this->input->post('jml_kas_masuk', true),
                'operator_kas_masuk' => $this->session->userdata('id_user'),
                'ket_kas_masuk' => $this->input->post('ket_kas_masuk', true),

            );
            $this->db->insert('kas_masuk', $data);
            $data2 = [
                'sess_id' => $this->session->userdata('id_user'),
                'activity' => 'Menginput data kas masuk dengan no : ' . $this->input->post('no_kas_masuk', true),
                'date_activity' => date('Y-m-d'),
                'time_activity' => date('H:i:s')
            ];
            $this->db->insert('tb_activity', $data2);
            $this->session->set_flashdata('message', 'Tambah Data');
            redirect('user/kas_masuk');
        }
    }

    public function get_kas_masuk()
    {
        $id_kas_masuk = $this->input->post('id_kas_masuk');
        echo json_encode($this->db->get_where('kas_masuk', ['id_kas_masuk' => $id_kas_masuk])->row_array());
    }

    public function edit_kas_masuk()
    {
        $id_kas_masuk = $this->input->post('id_kas_masuk');
        $no_kas_masuk = $this->input->post('no_kas_masuk');
        $outlet_kas_masuk = $this->input->post('outlet_kas_masuk');
        $tgl_kas_masuk = $this->input->post('tgl_kas_masuk');
        $jml_kas_masuk = $this->input->post('jml_kas_masuk');
        $ket_kas_masuk = $this->input->post('ket_kas_masuk');
        $operator_edit_kas_masuk = $this->session->userdata('nama');

        $this->db->set('no_kas_masuk', $no_kas_masuk);
        $this->db->set('outlet_kas_masuk', $outlet_kas_masuk);
        $this->db->set('tgl_kas_masuk', $tgl_kas_masuk);
        $this->db->set('jml_kas_masuk', $jml_kas_masuk);
        $this->db->set('ket_kas_masuk', $ket_kas_masuk);
        $this->db->set('operator_edit_kas_masuk', $operator_edit_kas_masuk);
        $this->db->where('id_kas_masuk', $id_kas_masuk);
        $this->db->update('kas_masuk');
        $data2 = [
            'sess_id' => $this->session->userdata('id_user'),
            'activity' => 'Mengubah data kas masuk dengan no : ' . $no_kas_masuk,
            'date_activity' => date('Y-m-d'),
            'time_activity' => date('H:i:s')
        ];
        $this->db->insert('tb_activity', $data2);
        $this->session->set_flashdata('message', 'Ubah Data');
        redirect('user/kas_masuk');
    }

    public function hapus_kas_masuk($id_kas_masuk)
    {
        $this->db->where('id_kas_masuk', $id_kas_masuk);
        $this->db->delete('kas_masuk');
        $data2 = [
            'sess_id' => $this->session->userdata('id_user'),
            'activity' => 'Menghapus data kas masuk',
            'date_activity' => date('Y-m-d'),
            'time_activity' => date('H:i:s')
        ];
        $this->db->insert('tb_activity', $data2);
        $this->session->set_flashdata('message', 'Hapus Data');
        redirect('user/kas_masuk');
    }

    public function kas_keluar()
    {
        $this->form_validation->set_rules('no_kas_keluar', 'No Jurnal', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Data Kas Keluar';
            $data['user'] = $this->db->get_where('mst_user', ['id_user' => $this->session->userdata('id_user')])->row_array();
            $data['kas_keluar'] = $this->user->getKasKeluar($this->session->userdata('id_user'));

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_user', $data);
            $this->load->view('user/kas_keluar', $data);
            $this->load->view('templates/footer');
        } else {
            $data = array(
                'no_kas_keluar' => $this->input->post('no_kas_keluar', true),
                'outlet_kas_keluar' => $this->input->post('outlet_kas_keluar', true),
                'tgl_kas_keluar' => $this->input->post('tgl_kas_keluar', true),
                'jml_kas_keluar' => $this->input->post('jml_kas_keluar', true),
                'operator_kas_keluar' => $this->session->userdata('id_user'),
                'ket_kas_keluar' => $this->input->post('ket_kas_keluar', true),
            );

            $this->db->insert('kas_keluar', $data);
            $data2 = [
                'sess_id' => $this->session->userdata('id_user'),
                'activity' => 'Menginput data kas keluar dengan no : ' . $this->input->post('no_kas_keluar', true),
                'date_activity' => date('Y-m-d'),
                'time_activity' => date('H:i:s')
            ];
            $this->db->insert('tb_activity', $data2);
            $this->session->set_flashdata('message', 'Tambah Data');
            redirect('user/kas_keluar');
        }
    }

    public function get_kas_keluar()
    {
        $id_kas_keluar = $this->input->post('id_kas_keluar');
        echo json_encode($this->db->get_where('kas_keluar', ['id_kas_keluar' => $id_kas_keluar])->row_array());
    }

    public function edit_kas_keluar()
    {
        $id_kas_keluar = $this->input->post('id_kas_keluar');
        $no_kas_keluar = $this->input->post('no_kas_keluar');
        $outlet_kas_keluar = $this->input->post('outlet_kas_keluar');
        $tgl_kas_keluar = $this->input->post('tgl_kas_keluar');
        $jml_kas_keluar = $this->input->post('jml_kas_keluar');
        $ket_kas_keluar = $this->input->post('ket_kas_keluar');
        $operator_edit_kas_keluar = $this->session->userdata('nama');

        $this->db->set('no_kas_keluar', $no_kas_keluar);
        $this->db->set('outlet_kas_keluar', $outlet_kas_keluar);
        $this->db->set('tgl_kas_keluar', $tgl_kas_keluar);
        $this->db->set('jml_kas_keluar', $jml_kas_keluar);
        $this->db->set('ket_kas_keluar', $ket_kas_keluar);
        $this->db->set('operator_edit_kas_keluar', $operator_edit_kas_keluar);
        $this->db->where('id_kas_keluar', $id_kas_keluar);
        $this->db->update('kas_keluar');
        $data2 = [
            'sess_id' => $this->session->userdata('id_user'),
            'activity' => 'Mengubah data kas keluar dengan no : ' . $no_kas_keluar,
            'date_activity' => date('Y-m-d'),
            'time_activity' => date('H:i:s')
        ];
        $this->db->insert('tb_activity', $data2);
        $this->session->set_flashdata('message', 'Ubah Data');
        redirect('user/kas_keluar');
    }

    public function hapus_kas_keluar($id_kas_keluar)
    {
        $this->db->where('id_kas_keluar', $id_kas_keluar);
        $this->db->delete('kas_keluar');
        $data2 = [
            'sess_id' => $this->session->userdata('id_user'),
            'activity' => 'Menghapus data kas keluar',
            'date_activity' => date('Y-m-d'),
            'time_activity' => date('H:i:s')
        ];
        $this->db->insert('tb_activity', $data2);
        $this->session->set_flashdata('message', 'Hapus Data');
        redirect('user/kas_keluar');
    }

    public function lap_kas_masuk()
    {
        $data['title'] = 'Laporan Kas Masuk';
        $data['user'] = $this->db->get_where('mst_user', ['id_user' => $this->session->userdata('id_user')])->row_array();
        $tanggal = date('Y/m/d');
        $data['kas_masuk'] = $this->user->getLapKasMasuk($tanggal, $this->session->userdata('id_user'));

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_user', $data);
        $this->load->view('user/lap_kas_masuk', $data);
        $this->load->view('templates/footer');
    }

    public function filter_kas_masuk()
    {
        $data['user'] = $this->db->get_where('mst_user', ['id_user' => $this->session->userdata('id_user')])->row_array();
        $tanggal = $this->input->post('tanggal');
        $data['kas_masuk'] = $this->user->getLapKasMasuk($tanggal, $this->session->userdata('id_user'));
        $data['title'] = 'Laporan kas masuk tanggal : ' . format_indo($tanggal);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_user', $data);
        $this->load->view('user/filter_kas_masuk', $data);
        $this->load->view('templates/footer');
    }

    public function lap_kas_keluar()
    {
        $data['title'] = 'Laporan Kas Keluar';
        $data['user'] = $this->db->get_where('mst_user', ['id_user' => $this->session->userdata('id_user')])->row_array();
        $tanggal = date('Y/m/d');
        $data['kas_keluar'] = $this->user->getLapKasKeluar($tanggal, $this->session->userdata('id_user'));

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_user', $data);
        $this->load->view('user/lap_kas_keluar', $data);
        $this->load->view('templates/footer');
    }

    public function filter_kas_keluar()
    {
        $data['user'] = $this->db->get_where('mst_user', ['id_user' => $this->session->userdata('id_user')])->row_array();
        $tanggal = $this->input->post('tanggal');
        $data['kas_keluar'] = $this->user->getLapKasKeluar($tanggal, $this->session->userdata('id_user'));
        $data['title'] = 'Laporan kas keluar tanggal : ' . format_indo($tanggal, $this->session->userdata('id_user'));

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_user', $data);
        $this->load->view('user/filter_kas_keluar', $data);
        $this->load->view('templates/footer');
    }
}
