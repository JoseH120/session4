<?php
    defined('BASEPATH') or exit('No direct script access allowed');
    class Materias_controller extends CI_Controller{
        public function __construct(){
            parent::__construct();
            $this->load->helper('url');
            $this->load->library('session');
            $this->load->library('form_validation');
            if(!isset($this->session->userdata['logged_in'])){
                redirect("/");
            }
        }

        //================= FUNCIONES QUE CARGAN LAS VISTAS ============================ //

        public function index(){
            $this->load->model('Materia_model');
            $data = array(
                "records" => $this->Materia_model->getAll(),
                "title" => "Materias",
            );
            $this->load->view("shared/header", $data);
            $this->load->view("materias/index", $data);
            $this->load->view("shared/footer");
        }

        public function insertar(){
            $data = array(
                "title" => "Insertar carrera",
            );
            $this->load->view("shared/header", $data);
            $this->load->view("materias/add_edit", $data);
            $this->load->view("shared/footer");
        }

        public function modificar($id){
            $this->load->model('Materia_model');
            $materia = $this->Materia_model->getById($id);
            $data = array(
                "title" => "Modificar materia",
                "materia" => $materia,
            );

            $this->load->view("shared/header", $data);
            $this->load->view("materias/add_edit", $data);
            $this->load->view("shared/footer");
        }
        // ======================== FIN DE VISTAS ============================ //

        // ===================== FUNCIONES DE OPERACIONES ==================== //
        public function add(){
            // Reglas de validacion del formulario
            $this->form_validation->set_error_delimiters('','');
            // $this->form_validation->set_rules("idmateria","Id Materia","required|is_natural_no_zero|is_unique[materias.idmateria]");
            $this->form_validation->set_rules("materia", "Materia", "required|max_length[50]");
            
            // Modificando el mensaje de validacion para los errores
            // $this->form_validation->set_message('is_natural_no_zero','El campo %s debe ser numero entero mayor que cero');
            $this->form_validation->set_message('required', 'El campo %s es requerido');
            $this->form_validation->set_message('max_length', 'El campo %s debe tener como maximo %s caracteres');
            // $this->form_validation->set_message('is_unique', 'El campo %s debe ser unico');

            //Parametros de respuesta
            header('Content-type: application/json');
            $statusCode = 200;
            $msg = "";

            if($this->form_validation->run()){
                // si la validacion fue exitosa
                try{
                    $this->load->model('Materia_model');
                    $data = array(
                        // "idmateria" => $this->input->post("idmateria"),
                        "materia" => $this->input->post("materia"),
                    );
                    $rows = $this->Materia_model->insert($data);
                    if($rows > 0){
                        $msg = "Informacion guardada correctamente";
                    }else{
                        $statusCode = 500;
                        $msg = "No se pudo guardar la informacion";
                    }
                }catch(Exception $ex){
                    $msg = "Ocurrio un error." ;
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
            // $this->form_validation->set_rules("idmateria", "Id Materia", "required|is_natural_no_zero");
            $this->form_validation->set_rules("materia", "Materia", "required|max_length[50]");

            $this->form_validation->set_message('required', 'El campo %s es requerido');
            $this->form_validation->set_message('max_length', 'El campo %s debe tener como maximo %s caracteres');
            // $this->form_validation->set_message('is_natural_no_zero','El campo %s debe ser numero entero mayor que cero');
            // $this->form_validation->set_message('is_unique', 'El campo %s es unico');

            header('Content-type: application/json');
            $statusCode = 200;
            $msg = "";

            //Se ejecuta la validacion del formulario
            if($this->form_validation->run()){
                try{
                    $this->load->model("Materia_model");
                    $data = array(
                        "idmateria" => $this->input->post("idmateria"),
                        "materia" => $this->input->post("materia"),
                    );
                    $rows = $this->Materia_model->update($data, $this->input->post("PK_materia"));
                    $msg = "Informacion guardada correctamente.";
                }
                catch(Exception $ex){
                    $statusCode = 500;
                    $msg = "Ocurrio un error". $ex->getMessage();
                }
            }else{
                $statusCode = 400;
                $msg = "ocurrieron errores de validacion";
                $errors = array();
                foreach($this->input->post() as $key => $value){
                    $errors[$key]  = form_error($key);
                }
                $this->data['errors'] = $errors;
            }
            $this->data['msg'] = $msg;
            $this->output->set_status_header($statusCode);
            echo json_encode($this->data);
        }

        public function eliminar($id){
            $this->load->model('Materia_model');
            $result = $this->Materia_model->delete($id);
            if($result){
                $this->session->set_flashdata('success', "Registro borrado correctamente");
            }else{
                $this->session->set_flashdata('error', "No se pudo borrar el registro.");
            }
            redirect("Materias_controller");
        }

        //====================================================
        // FUFNCION QUE GENERA REPORTE
        public function report_todas_las_materias(){
            //Se carga la libreria para genera tablas
            $this->load->library('table');
            //Se carga la libreria para generar reportes
            $this->load->library('Report');

            $pdf = new Report(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true,'UTF-8', false);
            $pdf->titulo="Listado de materias";
            //Informacion del documento
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Jose Hernandez');
            $pdf->SetTitle('Listado de materias');
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
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

            //Fuente del contenido
            $pdf->SetFont('Helvetica', '', 10);

            //----------------------------------------------
            //Generar la tabla y su informacion
            $template = array(
                'table_open' => '<table border="1" cellpadding="2" cellspacing="1">',
                'heading_cell_start' => '<th style="font-weight:bold; color:white; background-color: grey">',
            );

            $this->table->set_template($template);

            $this->table->set_heading('Id Materia', 'Materia');

            $this->load->model('Materia_model');
            $materias = $this->Materia_model->getAll();

            foreach($materias as $materia):
                $this->table->add_row($materia->idmateria, $materia->materia);
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