<?php
    defined('BASEPATH') or exit('No direct script access allowed');

    class Carreras_controller extends CI_Controller{

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
        
        // ================================FUNCIONES QUE CARGAN LAS VISTAS==================================
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
        //============================== FIN DE VISTAS =========================================//
        //============================FUNCIONES DE OPERACIONES=====================================//
        public function add(){
            /* 
                REGLAS DE VALIDACION DEL FORMULARIO
                required: indica que el campo es obligatorio
                min_length: indica que la cadena debe tener al menos una cantidad determinada de caracteres
                max_length: indica que la cadena debe tener como maximo una cantidad determinada de caracteres
            */
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules("idcarrera", "Id Carrera", "required|min_length[3]|max_length[3]");
            $this->form_validation->set_rules("carrera", "Carrera", "required|min_length[3]|max_length[100]");

            //Modificando el mensaje de validacion para los errores, en este caso para 
            /* La regla required
                La regla min_length
                La regla max_length */
            $this->form_validation->set_message('required', 'El campo %s es requerido');
            $this->form_validation->set_message('min_length', 'El campo %s debe tener al menso %s caracteres.');
            $this->form_validation->set_message('max_length', 'El campo %s debe tener como maximo %s caracteres');

            // Parametros de respuesta
            header('Content-type: application/json');
            $statusCode = 200;
            $msg = "";
            // Se ejecuta la validacion del formulario
            if($this->form_validation->run()){
                // Si la validacion fue exitosa, entonces entra aca.
                try{
                    $this->load->model('Carrera_model');
                    $data = array(
                        "idcarrera" => $this->input->post("idcarrera"),
                        "carrera" => $this->input->post("carrera"),
                    );
                    $rows = $this->Carrera_model->insert($data);
                    if($rows > 0){
                        $msg = "Informacion guardada correctamente.";
                    }else{
                        //Si $rows entra aca es porque hubo un error al insertar
                        $statusCode = 500;
                        $msg = "No se pudo guardar la informacion";
                    }
                }catch(Exception $ex){
                    //Si aca es porque hubo un error al momento de ejecutar este metodo
                    $statusCode = 500;
                    $msg = "Ocurrio un error.";
                }
            }else{
                //Si hubo errores de validacion entra aca
                $statusCode  = 400;
                $msg = "Ocurrieron errores de validacion.";
                $errors = array();
                foreach($this->input->post() as $key => $value){
                    $errors[$key] = form_error($key);
                }
                $this->data['errors'] = $errors;
            }
            $this->data['msg'] = $msg;
            $this->output->set_status_header($statusCode);
            //Se devuelve el objeto json con la informacion 
            echo json_encode($this->data);
        }

        public function update(){
            // Reglas de validacion del formulario
            /*  required: indica que el campo es obligatorio
                min_length: indica que la cdena debe tener al menos una cantidad determinada de caracteres
                max_length: indica que la cadena debe tener como maximo una cantidad determinada de caracteres */
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules("idcarrera", "Id Carrera", "required|min_length[3]|max_length[3]");
            $this->form_validation->set_rules("carrera", "Carrera", "required|min_length[3]|max_length[100]");

            //Modificando el mensaje de validacion para los errores, en este caso para 
            /*  La regla required */
            $this->form_validation->set_message('required', 'El campo %s es requerido');
            $this->form_validation->set_message('min_length', 'El campo %s debe tener al menos %s caracteres.');
            $this->form_validation->set_message('max_length', 'El campo %s debe tener como maximo %s caracteres.');

            //Parametros de respuesta
            header('Content-type: application/json');
            $statusCode = 200;
            $msg = "";

            //Se ejecuta la validacion del formulario
            if($this->form_validation->run()){
                //si la validacion fue exitosa, entonces entra aca
                try{
                    $this->load->model('Carrera_model');
                    $data = array(
                        "idcarrera" => $this->input->post("idcarrera"),
                        "carrera" => $this->input->post("carrera"),
                    );
                    $rows = $this->Carrera_model->update($data, $this->input->post("PK_carrera"));
                    $msg = "Informacion guardada correctamente.";
                }catch(Exception $ex){
                    $statusCode = 500;
                    $msg = "Ocurrio un error.";
                }
            }else{
                $statusCode = 400;
                $msg = "Ocurrieron errores de validacion.";
                $errors = array();
                foreach($this->input->post() as $key => $value){
                    $errors[$key] = form_error($key);
                }
                $this->data['errors'] = $errors;
            }
            $this->data['msg'] = $msg;
            $this->output->set_status_header($statusCode);
            //Se devuelve el objeto Json con la informacion
            echo json_encode($this->data);
        }

        public function eliminar($id){
            $this->load->model('Carrera_model');
            $result = $this->Carrera_model->delete($id);
            if($result){
                $this->session->set_flashdata('success', "Registro borrado correctamente");
            }else{
                $this->session->set_flashdata('error', "No se pudo borrar el registro.");
            }
            redirect("Carreras_controller");
        }
        //============================FIN DE FUNCIONES ======================================= 
    
        public function report_todas_las_carreras(){
            //Se carga la libreria para generar tablas
            $this->load->library('table');
            //Carga la libreria Report que acabamos de crear
            $this->load->library('Report');

            $pdf = new Report(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->titulo="Listado de carreras";
            //Informacion del documento
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Jose Hernandez');
            $pdf->SetTitle('Listado de carreras');
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
            // Generar la tabla y su informacion
            $template = array(
                'table_open' => '<table border="1" cellpadding="2" cellspacing="1">',
                'heading_cell_start' => '<th style="font-weight: bold; color:white; background-color: grey">',
            );
            $this->table->set_template($template);

            $this->table->set_heading('Id Carrera', 'Carrera');

            $this->load->model('Carrera_model');
            $carreras = $this->Carrera_model->getAll();
            
            foreach($carreras as $carrera):
                $this->table->add_row($carrera->idcarrera, $carrera->carrera);
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