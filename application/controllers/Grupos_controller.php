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

        //=================================================
        //FUNCION QUE GENERA REPORTE
        public function report_todos_los_grupos(){
            //Se carga la libreria para generar tablas
            $this->load->library('table');
            //Se carga la libreria para generar reporte
            $this->load->library('Report');

            //Se crea el objeto reporte
            $pdf = new Report(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8',false);
            $pdf->titulo = "Listado de carreras";

            //Informacion del documento
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Jose Hernandez');
            $pdf->SetTitle('Listado de cursos');
            $pdf->SetSubject('Report generado usando Codeigniter y TCPDF');
            $pdf->SetKeywords('TCPDF, PDF, MySQL, Codeigniter');

            //Informacion por defecto del encabezado
            //Fuente de encabezado y pie de pagina
            $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            //Fuente por defecto Monospaced
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            //Margenes
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->setHeaderMargin(15);
            $pdf->setFooterMargin(PDF_MARGIN_FOOTER);

            //Quiebre de pagina automatico
            $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

            //Factor de escala de imagen
            $pdf->SetFont('Helvetica', '', 10);

            //----------------------------------------------
            //Generar la tabla y su informacion
            $template = array(
                'table_open' => '<table border="1" cellspacing="1" cellpadding="2">',
                'heading_cell_start' => '<th style="font-weight:bold; color:white; background-color:grey;">',
            );
            $this->table->set_template($template);
            
            $this->table->set_heading('Id Grupo', 'Num_Grupo', 'Año', 'Ciclo', 'Materia', 'Profesor');
            
            $this->load->model('Grupo_model');
            $grupos = $this->Grupo_model->getAll();
            
            foreach($grupos as $grupo):
                $this->table->add_row($grupo->idgrupo, $grupo->num_grupo, $grupo->anio, $grupo->ciclo, $grupo->materia, $grupo->profesor);
            endforeach;
            
            $html = $this->table->generate();

            //Generar la informacion de la tabla
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