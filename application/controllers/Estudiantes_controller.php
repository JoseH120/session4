<?php

    defined('BASEPATH') or exit('No direct script access allowed');

    class Estudiantes_controller extends CI_Controller{
        
        public function __construct(){
            parent::__construct();
            $this->load->helper('url');
            $this->load->library('session');
            $this->load->library('form_validation');
            if(!isset($this->session->userdata['logged_in'])){
                redirect("/");
            }
        }
        //funcion que cargan vistas 
        public function index(){
            $this->load->model('Estudiante_model');
            $data = array(
                "records"=>$this->Estudiante_model->getAll(),
                "title" => "Estudiantes",
            );
            $this->load->view("shared/header", $data);
            $this->load->view("estudiantes/index", $data);
            $this->load->view("shared/footer");
        }

        public function insertar(){
            $this->load->model('Carrera_model');
            // $this->load->model('Estudiante_model');
            $data = array(
                "carreras" => $this->Carrera_model->getAll(),
                "title" => "Insertar estudiante",
            );
            $this->load->view("shared/header", $data);
            $this->load->view("estudiantes/add_edit", $data);
            $this->load->view("shared/footer");
        }
      
        public function modificar($id){
            $this->load->model('Carrera_model');
            $this->load->model('Estudiante_model');
            $estudiante = $this->Estudiante_model->getById($id);
            $data = array(
                "carreras" => $this->Carrera_model->getAll(),
                "estudiante" => $estudiante,
                "title" => "Modificar estudiante",
            );
            $this->load->view("shared/header",$data);
            $this->load->view("estudiantes/add_edit", $data);
            $this->load->view("shared/footer");
        }

        // funciones operaciones
        public function add(){
            //reglas de validacion del formulario
            /* 
                required: indica que el campo es obligatorio
                min_length: indica la cantidad minima de caracteres
                max_length: indica la cantidad maxima de caracteres de la cadena
                valid_email: indica que el valor debe ser un correo con formato valido
            */
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules("idestudiante", "Id Estudiante", "required|min_length[12]|max_length[12]|is_unique[estudiantes.idestudiante]");
            $this->form_validation->set_rules("nombre","Nombre","required|max_length[50]");
            $this->form_validation->set_rules("apellido", "Apellido", "required|max_length[100]");
            $this->form_validation->set_rules("email", "Email", "required|max_length[100]|valid_email" );
            $this->form_validation->set_rules("usuario", "Usuario", "required|max_length[100]|is_unique[estudiantes.usuario]");
            $this->form_validation->set_rules("idcarrera", "Carrera", "required|max_length[3]");
            
            //Mensajes de validacion para lo errores
            $this->form_validation->set_message('required', 'El campo %s es requerido');
            $this->form_validation->set_message('min_length', 'El campo %s debe tener al menos %s caracteres');
            $this->form_validation->set_message('max_length', 'El campo %s debe tener como maximo %s caracteres');
            $this->form_validation->set_message('valid_email', 'El campo %s no es un correo valido');
            $this->form_validation->set_message('is_unique', 'El campo %s ya existe'); 

            //Parametros de respuesta
            header('Content-type: application/json');
            $statusCode = 200;
            $msg = "";
            //Se ejecuta la validacion del formulario
            if($this->form_validation->run()){
                //Si la validacion fue exitosa, entonces entra acá
                try{
                    $this->load->model("Estudiante_model");
                    //Se crea el objeto con los campos de la tabla de estudiantes
                    $data = array(
                        "idestudiante" => $this->input->post("idestudiante"),
                        "nombre" => $this->input->post("nombre"),
                        "apellido" => $this->input->post("apellido"),
                        "email" => $this->input->post("email"),
                        "usuario" => $this->input->post("usuario"),
                        "idcarrera" => $this->input->post("idcarrera"),
                    );
                    //se pasan los valores al metodo insert del modelo
                    $rows = $this->Estudiante_model->insert($data);
                    //Si $rows devuelve un valor mayor a 1, la inserccion fue exitosa
                    if($rows > 0){
                        $msg = "Información guardada correctamente";
                    }
                    else{
                        //Si rows entra acá es porque hubo un error al insertar
                        $statusCode = 500;
                        $msg = "No se pudo guardar la información";
                    }
                }catch (Exception $e){
                    //Si acá es porque hubo un error al momento de ejecutar este método 
                    $statusCode = 500;
                    $msg = "Ocurrio un error.". $e->getMessage();
                }
            }
            else{
                //Si hubo errores de validacion entra aca
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
            //Se devuelve el objeto json con la informacion
            echo json_encode($this->data);

            
        }

        public function update(){

            /* 
            Reglas de validacion del formulario
            required: indica que el campo es obligatorio
            min_length: inidica que la cadena debe tener al menos una cantidad determinada de caracteres.
            max_length: inidica que la cadena debe tener como máximo una cantidad determinada de caracteres.
            */
            $this->form_validation->set_error_delimiters('', '');
            
            $this->form_validation->set_rules("idestudiante", "Id Estudiante", "required|min_length[12]|max_length[12]");
            $this->form_validation->set_rules("nombre","Nombre","required|max_length[100]");
            $this->form_validation->set_rules("apellido", "Apellido", "required|max_length[100]");
            $this->form_validation->set_rules("email", "Email", "required|max_length[100]|valid_email" );
            $this->form_validation->set_rules("usuario", "Usuario", "required|max_length[100]");
            $this->form_validation->set_rules("idcarrera", "Carrera", "required|max_length[3]");
            
            //Mensajes de validacion para lo errores
            $this->form_validation->set_message('required', 'El campo %s es requerido');
            $this->form_validation->set_message('min_length', 'El campo %s debe tener al menos %s caracteres');
            $this->form_validation->set_message('max_length', 'El campo %s debe tener como maximo %s caracteres');
            $this->form_validation->set_message('valid_email', 'El campo %s no es un correo valido');
            $this->form_validation->set_message('is_unique', 'El campo %s ya existe'); 
            
            // Parametros de respuesta
            header('Content-type : application/json');
            $statusCode = 200;
            $msg = "";

            //Se ejecuta la validacion del formulario
            if($this->form_validation->run()){
               //Si la validacion fue exitosa, entonces entra acá
               try{
                $this->load->model('Estudiante_model');
                //Se crea el objeto con los campos de la tabla de carreras
                $data = array(
                    "idestudiante" => $this->input->post("idestudiante"),
                    "nombre" => $this->input->post("nombre"),
                    "apellido" => $this->input->post("apellido"),
                    "email" => $this->input->post("email"),
                    "usuario" => $this->input->post("usuario"),
                    "idcarrera" => $this->input->post("idcarrera"),
                );
                //Se pasan los valores al metodo update del modelo, junto con la llave primaria
                $rows = $this->Estudiante_model->update($data,$this->input->post("PK_estudiante"));
                $msg = "Informacion guardada correctamente";
               }catch(Exception $ex){
                    $statusCode = 500;
                    $msg = "Ocurrio un error.".$ex->getMessage();
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
            //Se devuelve el objeto json con la informacion
            echo json_encode($this->data);
            
        }

        public function eliminar($id){
            $this->load->model('Estudiante_model');
            $result = $this->Estudiante_model->delete($id);
            if($result){
                $this->session->set_flashdata('success', "Registro borrado correctamente.");
            }else{
                $this->session->set_flashdata('error',"No se pudo borrar el registro");
            }
            redirect("Estudiantes_controller");
        }

        //---------------FUNCION QUE GENERA REPORTE------------------------------
        public function report_todos_los_estudiantes(){
            //Se carga la libreria para generar tablas
            $this->load->library('table');
            //Carga la libreria Report que acabamos de crear
            $this->load->library('Report');

            $pdf = new Report(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->titulo="Listado de estudiantes";
            
            //Informacion del documento
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Jose Hernandez');
            $pdf->SetTitle('Listado de estudiantes');
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

            //------------------------------------------------
            //Generar la tabla y su informacion
            $template = array(
                'table_open' => '<table border="1" cellpadding="2" cellspacing="1">', 
                'heading_cell_start' => '<th style="font-weight: bold; color:white; background-color: grey">',
            );
            $this->table->set_template($template);
            
            $this->table->set_heading('Id Estudiante', 'Nombre', 'Carrera', 'Email');

            $this->load->model('Estudiante_model');

            $estudiantes = $this->Estudiante_model->getEstudiantes();
            
            foreach($estudiantes as $estudiante):
                $this->table->add_row($estudiante->idestudiante, $estudiante->nombre, $estudiante->carrera, $estudiante->email);
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