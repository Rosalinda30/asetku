<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aset extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('aset_m');
    }
    public function index()
    {
        $data['aset'] = $this->aset_m->get_all();
        $this->template->load('shared/index', 'aset/index', $data);
    }
    public function create()
    {
        $aset  = $this->aset_m;
        $validation = $this->form_validation;
        $validation->set_rules($aset->rules());
        if ($validation->run() == FALSE) {
            $this->template->load('shared/index', 'aset/create');
        } else {
            $post = $this->input->post(null, TRUE);
            $aset->Add($post);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Data aset berhasil disimpan!');
                redirect('aset', 'refresh');
            }
        }
    }
    public function edit($id = null)
    {
        if (!isset($id)) redirect('alat');
        $aset  = $this->aset_m;
        $validation = $this->form_validation;
        $validation->set_rules($aset->rules());

        if ($validation->run() == FALSE) {
            $data['aset'] = $this->aset_m->get_by_id($id);
            if (!$data['aset']) {
                $this->session->set_flashdata('error', 'Data aset tidak ditemukan!');
                redirect('aset', 'refresh');
            }
            $this->template->load('shared/index', 'aset/edit', $data);
        } else {
            $post = $this->input->post(null, TRUE);
            $aset->update($post);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Data aset berhasil diupdate!');
                redirect('aset', 'refresh');
            } else {
                $this->session->set_flashdata('warning', 'Data aset tidak ada yang diupdate!');
                redirect('aset', 'refresh');
            }
        }
    }
    public function delete($id)
    {
        $this->aset_m->Delete($id);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data aset berhasil dihapus!');
            redirect('aset', 'refresh');
        }
    }
}

/* End of file Aset.php */
