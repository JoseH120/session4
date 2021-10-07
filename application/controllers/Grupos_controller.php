<?php 
    defined('BASEPATH') or exit('No direct script to access allowed');

    class Grupos_controller extends CI_Controller{
        public function __construct(){
            parent::__construct();
            $this->load->helper('url');
            $this->load->library('session');
            $this->load->library('form_validation');
            if(!isset($this->session->userdata['logged_in'])){
                redirect("/");
            }
        }

        //------------------------- FUNCIONES QUE CARGAN LAS VISTAS----------------------
        public function index(){
            $this->load->model('Grupo_model');
            $data = array(
                "records" => $this->Grupo_model->getAll(),
                "title" => "Grupos",
            );
            $this->load->view("shared/header", $data);
            $this->load->view("grupos/index", $data);
            $this->load->view("shared/footer");
        }

        public function insertar(){
            $this->load->model('Profesor_model');
            $this->load->model('Materia_model');
            $data = array(
                "materias" => $this->Materia_model->getAll(),
                "profesores" => $this->Profesor_model->getProfesores(),
                "title" => "Insertar grupos",
            );
            $this->load->view("shared/header", $data);
            $this->load->view("grupos/add_edit", $data);
            $this->load->view("shared/footer");
        }

        public function modificar($id){
            $this->load->model("Materia_model");
            $this->load->model("Profesor_model");
            $this->load->model("Grupo_model");
            $grupos = $this->Grupo_model->getById($id);
            $data = array(
                "materias" => $this->Materia_model->getAll(),
                "profesores"=> $this->Profesor_model->getProfesores(),
                "grupo" => $grupos,
                "title" => "Modificar grupos",
            );
            $this->load->view("shared/header", $data);
            $this->load->view("grupos/add_edit", $data);
            $this->load->view("shared/footer");
        }

        //Funciones operaciones
        public function add(){
            // reglas de validacion del formulario
            $this->form_validation->set_error_delimiters('','');
            
            // $this->form_validation->set_rules("idgrupo", "Id Grupo", "required|is_natural_no_zero|is_unique[grupos.idgrupo]");
            $this->form_validation->set_rules("num_grupo", "Num Grupo", "required|max_length[3]");
            $this->form_validation->set_rules("anio", "Año","required|max_length[4]|min_length[4]|is_natural_no_zero");
            $this->form_validation->set_rules("ciclo", "Ciclo", "required|max_length[2]|min_length[1]|is_natural_no_zero");
            $this->form_validation->set_rules("idmateria", "Id Materia", "required|is_natural_no_zero");
            $this->form_validation->set_rules("idprofesor", "Id Profesor", "required|is_natural_no_zero");

            $this->form_validation->set_message('required', "El campo %s es requerido");
            $this->form_validation->set_message('max_length', "El campo %s debe tener como maximo %s caracteres");
            $this->form_validation->set_message('min_length', "El campo %s debe tener al menos %s caracteres");
            // $this->form_validation->set_message('is_natural_no_zero', "El campo %s debe ser natural distinto de cero");

            header('Content-type: application/json');
            $statusCode = 200;
            $msg = "";

            if($this->form_validation->run()){
                try{
                    $this->load->model("Grupo_model");
                    $data = array(
                        // "idgrupo" => $this->input->post("idgrupo"),
                        "num_grupo" => $this->input->post("num_grupo"),
                        "anio" => $this->input->post("anio"),
                        "ciclo" => $this->input->post("ciclo"),
                        "idmateria" => $this->input->post("idmateria"),
                        "idprofesor" => $this->input->post("idprofesor"),
                    );
                    $rows = $this->Grupo_model->insert($data);
                    if($rows > 0){
                        $msg = "Informacion guardada correctamente";
                    }
                    else{
                        $statusCode = 500;
                        $msg = "No se pudo guardar la informacion";
                    }
                }catch(Exception $ex){
                    $statusCode = 500;
                    $msg = "Ocurrio un error".$ex->getMessage();
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
            // reglas de validacion del formulario
            $this->form_validation->set_error_delimiters('','');
                        
            // $this->form_validation->set_rules("idgrupo", "Id Grupo", "required|is_natural_no_zero");
            $this->form_validation->set_rules("num_grupo", "Num Grupo", "required|max_length[3]");
            $this->form_validation->set_rules("anio", "Año","required|max_length[4]|min_length[4]|is_natural_no_zero");
            $this->form_validation->set_rules("ciclo", "Ciclo", "required|max_length[2]|min_length[1]|is_natural_no_zero");
            $this->form_validation->set_rules("idmateria", "Id Materia", "required|is_natural_no_zero");
            $this->form_validation->set_rules("idprofesor", "Id Profesor", "required|is_natural_no_zero");

            $this->form_validation->set_message('required', "El campo %s es requerido");
            $this->form_validation->set_message('max_length', "El campo %s debe tener como maximo %s caracteres");
            $this->form_validation->set_message('min_length', "El campo %s debe tener al menos %s caracteres");
            // $this->form_validation->set_message('is_natural_no_zero', "El campo %s debe ser natural distinto de cero");

            header('Content-type: application/json');
            $statusCode = 200;
            $msg = "";

            if($this->form_validation->run()){
                try{
                    $this->load->model('Grupo_model');
                    $data = array(
                        "idgrupo" => $this->input->post("idgrupo"),
                        "num_grupo" => $this->input->post("num_grupo"),
                        "anio" => $this->input->post("anio"),
                        "ciclo" => $this->input->post("ciclo"),
                        "idmateria" => $this->input->post("idmateria"),
                        "idprofesor" => $this->input->post("idprofesor"),
                    );
                    $rows = $this->Grupo_model->update($data, $this->input->post("PK_grupo"));
                    $msg = "Informacion guardada correctamente.";
                }catch(Exception $ex){
                    $statusCode = 500;
                    $msg = "Ocurrio un error ".$ex->getMessage();
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

        public function eliminar($id){
            $this->load->model('Grupo_model');
            $result = $this->Grupo_model->delete($id);
            if($result){
                $this->session->set_flashdata('success', "Registro borrado correctamente.");
            }else{
                $this->session->set_flashdata('error', "No se pudo borrar el registro");
            }
            redirect("Grupos_controller");
        }

    }
?>