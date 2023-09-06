<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        is_admin();
        $this->load->helper('ata');
        $this->load->helper('tglindo');
        $this->load->helper('rupiah');
        $this->load->model('Admin_model', 'admin');
    }

    public function index()
    {
        $data['title'] = 'Beranda';
        $data['user'] = $this->db->get_where('mst_user', ['id_user' => $this->session->userdata('id_user')])->row_array();
        $data['list_user'] = $this->db->get('mst_user')->result_array();

        $data['user_aktif'] = $this->admin->countUserAktif();
        $data['user_tak_aktif'] = $this->admin->countUserTidakAktif();
        $data['user_bulan'] = $this->admin->countUserBulan();
        $data['total_user'] = $this->admin->countAllUser();


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_admin', $data);
        $this->load->view('admin/index', $data);
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
        $this->session->set_flashdata('message', 'Simpan Perubahan');
        redirect('admin/index');
    }

    public function ubah_password()
    {
        $current_password = $this->input->post('current_password');
        $new_password = $this->input->post('new_password1');
        if ($current_password == $new_password) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger font-weight-bolder text-center" role="alert">Ubah Password Gagal !! <br> Password baru tidak boleh sama dengan password lama</div>');
            redirect('admin/index');
        } else {
            $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $this->db->set('password', $password_hash);
            $this->db->where('id_user', $this->session->userdata('id_user'));
            $this->db->update('mst_user');
            $this->session->set_flashdata('message', 'Ubah Password');
            redirect('admin/index');
        }
    }

    public function man_user()
    {
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('email', 'Alamat Email', 'required|trim|is_unique[mst_user.email]', array(
            'is_unique' => 'Alamat Email sudah ada'
        ));
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', array(
            'matches' => 'Password tidak sama',
            'min_length' => 'password min 3 karakter'
        ));
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Management User';
            $data['user'] = $this->db->get_where('mst_user', ['id_user' => $this->session->userdata('id_user')])->row_array();
            $data['list_user'] = $this->db->get('mst_user')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_admin', $data);
            $this->load->view('admin/master/man_user', $data);
            $this->load->view('templates/footer');
        } else {
            $data = array(
                'nama' => $this->input->post('nama', true),
                'email' => $this->input->post('email', true),
                'level' => $this->input->post('level', true),
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'date_created' => date('Y/m/d'),
                'image' => 'default.jpg',
                'is_active' => 1
            );
            $this->db->insert('mst_user', $data);
            $this->session->set_flashdata('message', 'Tambah Data');
            redirect('admin/man_user');
        }
    }

    public function get_user()
    {
        $id_user = $this->input->post('id_user');
        echo json_encode($this->db->get_where('mst_user', ['id_user' => $id_user])->row_array());
    }

    public function edit_user()
    {
        $id_user = $this->input->post('id_user');
        $nama = $this->input->post('nama');
        $level = $this->input->post('level');
        $is_active = $this->input->post('is_active');

        $this->db->set('nama', $nama);
        $this->db->set('level', $level);
        $this->db->set('is_active', $is_active);
        $this->db->where('id_user', $id_user);
        $this->db->update('mst_user');
        $this->session->set_flashdata('message', 'Ubah Data');
        redirect('admin/man_user');
    }

    public function kas_masuk()
    {
        $this->form_validation->set_rules('no_kas_masuk', 'No Jurnal', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Data Kas Masuk';
            $data['user'] = $this->db->get_where('mst_user', ['id_user' => $this->session->userdata('id_user')])->row_array();
            $data['kas_masuk'] = $this->admin->getKasMasuk();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_admin', $data);
            $this->load->view('admin/kas_masuk', $data);
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
            $this->session->set_flashdata('message', 'Tambah Data');
            redirect('admin/kas_masuk');
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
        $this->session->set_flashdata('message', 'Ubah Data');
        redirect('admin/kas_masuk');
    }

    public function hapus_kas_masuk($id_kas_masuk)
    {
        $this->db->where('id_kas_masuk', $id_kas_masuk);
        $this->db->delete('kas_masuk');
        $this->session->set_flashdata('message', 'Hapus Data');
        redirect('admin/kas_masuk');
    }

    public function kas_keluar()
    {
        $this->form_validation->set_rules('no_kas_keluar', 'No Jurnal', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Data Kas Keluar';
            $data['user'] = $this->db->get_where('mst_user', ['id_user' => $this->session->userdata('id_user')])->row_array();
            $data['kas_keluar'] = $this->admin->getKasKeluar();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_admin', $data);
            $this->load->view('admin/kas_keluar', $data);
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
            $this->session->set_flashdata('message', 'Tambah Data');
            redirect('admin/kas_keluar');
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
        $this->session->set_flashdata('message', 'Ubah Data');
        redirect('admin/kas_keluar');
    }

    public function hapus_kas_keluar($id_kas_keluar)
    {
        $this->db->where('id_kas_keluar', $id_kas_keluar);
        $this->db->delete('kas_keluar');
        $this->session->set_flashdata('message', 'Hapus Data');
        redirect('admin/kas_keluar');
    }

    public function lap_kas_masuk()
    {
        $data['title'] = 'Laporan Kas Masuk';
        $data['user'] = $this->db->get_where('mst_user', ['id_user' => $this->session->userdata('id_user')])->row_array();
        $tanggal = date('Y/m/d');
        $data['kas_masuk'] = $this->admin->getLapKasMasuk($tanggal);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_admin', $data);
        $this->load->view('admin/lap_kas_masuk', $data);
        $this->load->view('templates/footer');
    }

    public function filter_kas_masuk()
    {
        $data['user'] = $this->db->get_where('mst_user', ['id_user' => $this->session->userdata('id_user')])->row_array();
        $tanggal = $this->input->post('tanggal');
        $data['kas_masuk'] = $this->admin->getLapKasMasuk($tanggal);
        $data['title'] = 'Laporan kas masuk tanggal : ' . format_indo($tanggal);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_admin', $data);
        $this->load->view('admin/filter_kas_masuk', $data);
        $this->load->view('templates/footer');
    }

    public function lap_kas_keluar()
    {
        $data['title'] = 'Laporan Kas keluar';
        $data['user'] = $this->db->get_where('mst_user', ['id_user' => $this->session->userdata('id_user')])->row_array();
        $tanggal = date('Y/m/d');
        $data['kas_keluar'] = $this->admin->getLapKasKeluar($tanggal);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_admin', $data);
        $this->load->view('admin/lap_kas_keluar', $data);
        $this->load->view('templates/footer');
    }

    public function filter_kas_keluar()
    {
        $data['user'] = $this->db->get_where('mst_user', ['id_user' => $this->session->userdata('id_user')])->row_array();
        $tanggal = $this->input->post('tanggal');
        $data['kas_keluar'] = $this->admin->getLapKasKeluar($tanggal);
        $data['title'] = 'Laporan kas keluar tanggal : ' . format_indo($tanggal);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_admin', $data);
        $this->load->view('admin/filter_kas_keluar', $data);
        $this->load->view('templates/footer');
    }

    public function periode_kas_masuk()
    {
        $data['title'] = 'Rekapitulasi Kas Masuk';
        $data['user'] = $this->db->get_where('mst_user', ['id_user' => $this->session->userdata('id_user')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_admin', $data);
        $this->load->view('admin/periode_kas_masuk', $data);
        $this->load->view('templates/footer');
    }

    public function filter_periode_kas_masuk()
    {
        $data['user'] = $this->db->get_where('mst_user', ['id_user' => $this->session->userdata('id_user')])->row_array();

        $tanggal1 = $this->input->post('tanggal_awal');
        $tanggal2 = $this->input->post('tanggal_akhir');
        $data['kas_masuk'] = $this->admin->getFilterPeriodeKasMasuk($tanggal1, $tanggal2);
        $data['title'] = 'Rekapitulasi Kas Masuk Periode : ' . format_indo($tanggal1) . ' s/d ' . format_indo($tanggal2);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_admin', $data);
        $this->load->view('admin/filter_periode_kas_masuk', $data);
        $this->load->view('templates/footer');
    }

    public function periode_kas_keluar()
    {
        $data['title'] = 'Rekapitulasi Kas Keluar';
        $data['user'] = $this->db->get_where('mst_user', ['id_user' => $this->session->userdata('id_user')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_admin', $data);
        $this->load->view('admin/periode_kas_keluar', $data);
        $this->load->view('templates/footer');
    }

    public function filter_periode_kas_keluar()
    {
        $data['user'] = $this->db->get_where('mst_user', ['id_user' => $this->session->userdata('id_user')])->row_array();
        $tanggal1 = $this->input->post('tanggal_awal');
        $tanggal2 = $this->input->post('tanggal_akhir');
        $data['kas_keluar'] = $this->admin->getFilterPeriodeKasKeluar($tanggal1, $tanggal2);
        $data['title'] = 'Rekapitulasi Kas Keluar Periode : ' . format_indo($tanggal1) . ' s/d ' . format_indo($tanggal2);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_admin', $data);
        $this->load->view('admin/filter_periode_kas_keluar', $data);
        $this->load->view('templates/footer');
    }
}
