<?php
    defined('BASEPATH') or exit('No direct script access allowed');

    class Carreras_controller extends CI_Controller{

        public function __construct()
        {
            parent::__construct();
            $this->load->helper('url');
            $this->load->library('session');
        }
        
        // funcion que cargan las vistas
        public function index(){
            $this->load->model('Carrera_model');
            $data = array(
                "records" => $this->Carrera_model->getAll(),
                "title" => "Carreras",
            );
            $this->load->view("shared/header", $data);
            $this->load->view("carreras/index", $data);
            $this->load->view("shared/footer");
        }

        public function insertar(){
            // $this->load->model('Carrera_model');
            $data = array(
                "title" => "Insertar carrera",
            );
            $this->load->view("shared/header", $data);
            $this->load->view("carreras/add_edit", $data);
            $this->load->view("shared/footer");
        } 

        public function modificar($id){
            $this->load->model('Carrera_model');
            $carrera = $this->Carrera_model->getById($id);
            $data = array(
                "carrera" => $carrera,
                "title" => "Modificar carrera",
            );

            $this->load->view("shared/header", $data);
            $this->load->view("carreras/add_edit", $data);
            $this->load->view("shared/footer");
        }

        //Funciones de operaciones
        public function add(){
            $this->load->model('Carrera_model');
            $data = array(
                "idcarrera" => $this->input->post("idcarrera"),
                "carrera" => $this->input->post("carrera"),
            );
            $rows = $this->Carrera_model->insert($data);

            if($rows > 0){
                $this->session->set_flashdata('success', 'Informacion guardada correctamente');
            }else{
                $this->session->set_flashdata('error', 'No se guardo la informacion');
            }
            redirect("Carreras_controller");

        }

        public function update(){
            $this->load->model('Carrera_model');
            $data = array(
                "idcarrera" => $this->input->post("idcarrera"),
                "carrera" => $this->input->post("carrera"),
            );
            try{
                $rows = $this->Carrera_model->update($data, $this->input->post("PK_carrera"));
                $this->session->set_flashdata('success', "Informacion modificada correctamente");
                redirect("Carreras_controller/modificar/".$data["idcarrera"]);
            }catch(Exception $e){
                $this->session->set_flashdata('error', "No se modifico la informacion.");
                redirect("Carreras_controller/modificar/".$data["idcarrera"]);
            }
        }

        public function eliminar($id){
            $this->load->model('Carrera_model');
            $result = $this->Carrera_model->delete($id);
            if($result){
                $this->session->set_flashdata('success', "Registro borrado correctamente");
            }else{
                $this->session->set_flashdata('success', "No se pudo borrar el registro.");
            }
            redirect("Carreras_controller");
        }

    }
?>