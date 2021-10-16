<?php
    defined('BASEPATH') or exit('No direct script access allowed');

    class Profesores_controller extends CI_Controller{
        public function __construct()
        {
            parent::__construct();
            $this->load->helper('url');
            $this->load->library('session');
            $this->load->library('form_validation');
            if(!isset($this->session->userdata['logged_in'])){
                redirect("/");
            }
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
                "title" => "Insertar profesor", 
            );
            $this->load->view("shared/header", $data);
            $this->load->view("profesores/add_edit",$data);
            $this->load->view("shared/footer");
        }

        public function modificar($id){
            $this->load->model('Profesor_model');
            $model = $this->Profesor_model->getById($id);
            $data = array(
                "title" => "Modificar profesor",
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
            // $this->form_validation->set_rules("idprofesor", "Id Profesor", "required|is_natural_no_zero");
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
                        // "idprofesor" => $this->input->post('idprofesor'),
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
            
            // $this->form_validation->set_rules("idprofesor", "Id Profesor", "required|is_natural_no_zero");
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

        //======================================================
        //FUNCION QUE GENERA REPORTE
        public function report_todos_los_profesores(){
            //Se carga la libreria para generar tablas
            $this->load->library('table');
            //Se carga la libreria para generar reporte
            $this->load->library('Report');
            
            $pdf = new Report(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->titulo = "Listado de profesores";
            
            //Informacion del documento
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Jose Hernandez');
            $pdf->SetTitle('Listado de profesores');
            $pdf->SetSubject('Report generado usando Codeigniter y TCPDF');
            $pdf->SetKeywords('TCPDF, PDF, MySQL, Codeigniter');

            //Informacion por defecto del encabezado

            //Fuente de encabezado y pie de pagina
            $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN,'', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            //Fuente por defecto Monospaced
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            //Margenes
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->setHeaderMargin(15);
            $pdf->setFooterMargin(PDF_MARGIN_FOOTER);

            //Quiebre de la pagina automatico
            $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

            //Factor de escala de imagen
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

            //Fuente del contenido
            $pdf->SetFont('Helvetica', '', 10);

            //---------------------------------------------
            // Generar la tabla y su informacion
            $template = array(
                'table_open' => '<table border="1" cellpadding="2" cellspacing="1">',
                'heading_cell_start' => '<th style="font-weight:bold; color:white; background-color: grey">',
            );
            $this->table->set_template($template);

            $this->table->set_heading('Id Profesor', 'Nombre', 'Profesion', 'Email');

            $this->load->model('Profesor_model');
            $profesores = $this->Profesor_model->reporteProfesores();

            foreach($profesores as $profesor):
                $this->table->add_row($profesor->idprofesor, $profesor->nombre, $profesor->profesion, $profesor->email);
            endforeach;
            
            $html = $this->table->generate();
            //Generar informacion de la tabla

            //Añadir pagina
            $pdf->AddPage();

            //Contenido de salida en HTML
            $pdf->writeHTML($html, true, false, true, false, '');

            //Reiniciar puntero a la ultima pagina
            $pdf->lastPage();

            //Cerrar y mostrar el reporte
            $pdf->Output(md5(time()).'.pdf', 'I');
        }
    }
?>