<?php
    defined('BASEPATH') or exit('No direct script access allowed');

    class Profesores_controller extends CI_Controller{
        public function __construct()
        {
            parent::__construct();
            $this->load->helper('url');
            $this->load->library('session');
            $this->load->library('form_validation');
        }

        //--------------- FUNCIONES QUE CARGAN LAS VISTAS -----------------
        public function index(){
            $this->load->model('Profesor_model');
            $data = array(
                "records" => $this->Profesor_model->getAll(),
                "title" => "Profesores",
            );
            $this->load->view("shared/header", $data);
            $this->load->view("profesores/index", $data);
            $this->load->view("shared/footer");
        }

        public function insertar(){
            $data = array(
                "title" => "Insertar profesores", 
            );
            $this->load->view("shared/header", $data);
            $this->load->view("profesores/add_edit",$data);
            $this->load->view("shared/footer");
        }

        public function modificar($id){
            $this->load->model('Profesor_model');
            $model = $this->Profesor_model->getById($id);
            $data = array(
                "title" => "Modificar profesores",
                "profesor" => $model,
            );
            $this->load->view("shared/header", $data);
            $this->load->view("profesores/add_edit", $data);
            $this->load->view("shared/footer");
        }

        //--------------FIN DE FUNCIONES DE VISTAS ----------------

        //-------------- INICIO DE FUNCIONES DE OPERACIONES ---------------------------

        public function add(){
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules("idprofesor", "Id Profesor", "required|is_natural_no_zero");
            $this->form_validation->set_rules("nombre", "Nombre", "required|max_length[100]");
            $this->form_validation->set_rules("apellido", "Apellido", "required|max_length[100]");
            $this->form_validation->set_rules("fecha_nacimiento", "Fecha Nacimiento", "required");
            $this->form_validation->set_rules("profesion", "Profesion", "required|max_length[100]");
            $this->form_validation->set_rules("sexo","Sexo", "required");
            $this->form_validation->set_rules("email", "Email", "required|valid_email");
            // $this->form_validation->set_message('is_natural_no_zero', "El campo %s debe ser natural distinto de cero");
            $this->form_validation->set_message('required', "El campo %s es requerido");
            $this->form_validation->set_message('max_length', "El campo %s debe contener como maximo %s caracteres");
            $this->form_validation->set_message('valid_email', "El campo %s debe ser un correo valido");

            header('Content-type: application/json');
            $statusCode = 200;
            $msg = "";

            if($this->form_validation->run()){
                try{
                    $this->load->model("Profesor_model");
                    $data = array(
                        "idprofesor" => $this->input->post('idprofesor'),
                        "nombre" => $this->input->post("nombre"),
                        "apellido" => $this->input->post("apellido"),
                        "fecha_nacimiento" => $this->input->post("fecha_nacimiento"),
                        "profesion" => $this->input->post("profesion"),
                        "genero" => $this->input->post("sexo"),
                        "email" => $this->input->post("email"),
                    );
                    $rows = $this->Profesor_model->insert($data);
                    if($rows > 0){
                        $msg = "Informacion guardada correctamente";
                    }
                    else{
                        $statusCode = 500;
                        $msg = "No se pudo guardar la informacion";
                    }
                }catch(Exception $ex){
                    $msg = "Ocurrieron errores de validacion". $ex->getMessage();
                    $statusCode = 500;
                }
            }else{
                $statusCode = 400;
                $msg = "Ocurrieron errores de validacion";
                $errors = array();
                foreach($this->input->post() as $key => $value){
                    $errors[$key] = form_error($key);
                }
                $this->data['errors'] = $errors;
            }
            $this->data['msg'] = $msg;
            $this->output->set_status_header($statusCode);
            echo json_encode($this->data);
        }

        public function update(){
            $this->form_validation->set_error_delimiters('', '');
            
            $this->form_validation->set_rules("idprofesor", "Id Profesor", "required|is_natural_no_zero");
            $this->form_validation->set_rules("nombre", "Nombre", "required|max_length[100]");
            $this->form_validation->set_rules("apellido", "Apellido", "required|max_length[100]");
            $this->form_validation->set_rules("fecha_nacimiento", "Fecha Nacimiento", "required");
            $this->form_validation->set_rules("profesion", "Profesion", "required|max_length[100]");
            $this->form_validation->set_rules("sexo","Sexo", "required");
            $this->form_validation->set_rules("email", "Email", "required|valid_email");
            
            // $this->form_validation->set_message('is_natural_no_zero', "El campo %s debe ser natural distinto de cero");
            $this->form_validation->set_message('required', "El campo %s es requerido");
            $this->form_validation->set_message('max_length', "El campo %s debe contener como maximo %s caracteres");
            $this->form_validation->set_message('valid_email', "El campo %s debe ser un correo valido");

            header('Content-type: application/json');
            $statusCode = 200;
            $msg = "";

            if($this->form_validation->run()){
                try{
                    $this->load->model("Profesor_model");
                    $data = array(
                        "idprofesor" => $this->input->post("idprofesor"),
                        "nombre" => $this->input->post("nombre"),
                        "apellido" => $this->input->post("apellido"),
                        "fecha_nacimiento" => $this->input->post("fecha_nacimiento"),
                        "profesion" => $this->input->post("profesion"),
                        "genero" => $this->input->post("sexo"),
                        "email" => $this->input->post("email"),
                    );
                    $rows = $this->Profesor_model->update($data, $this->input->post("PK_profesor"));
                    $msg = "Informacion guardada correctamente";
                }catch(Exception $ex){
                    $statusCode = 500;
                    $msg = "Ocurrio un error". $ex->getMessage();
                }
            }else{
                $statusCode = 400;
                $msg = "Ocurrieron errores de validacion";
                $errors = array();
                foreach($this->input->post() as $key=>$value){
                    $errors[$key] = form_error($key);
                }
                $this->data['errors'] = $errors;
            }
            $this->data['msg'] = $msg;
            $this->output->set_status_hader($statusCode);
            
            echo json_encode($this->data);
        }

        public function eliminar($id){
            $this->load->model("Profesor_model");
            if($this->Profesor_model->delete($id)){
                $this->session->set_flashdata("success", "Registro borrado correctamente");
            }else{
                $this->session->set_flashdata("error", "No se pudo borrar el registro");
            }
            redirect("Profesores_controller");
        }
    }
?>