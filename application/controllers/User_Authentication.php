<?php
    class User_Authentication extends CI_Controller{
        public function __construct()
        {
            parent::__construct();
            //Se carga la ayuda del direccionamiento de carpeta del proyecto
            $this->load->helper('url');

            //Se carga la libreria de validacion de formularios
            $this->load->library('form_validation');

            //Se carga la libreria para sesiones
            $this->load->library('session');

            //Se carga el modelo de login para la base de datos
            $this->load->model('Login_Database');

        }

        public function index(){
            $this->load->view('login_form');
        }

        public function user_registration_show(){
            $this->load->view('registration_form');
        }

        //valida y almacena la informacion de registro en la base de datos
        public function new_user_registration(){
            //validacion de la informacion de registro
            $this->form_validation->set_rules('username', 'Usuario', 'trim|required|is_unique[user_login.user_name]');
            $this->form_validation->set_rules('email_value', 'Email', 'trim|required|is_unique[user_login.user_email]');
            $this->form_validation->set_rules('password', 'Contraseña', 'trim|required');

            //Modificando el mensaje de validacion para los errores
            $this->form_validation->set_message('required', 'El campo %s es requerido');
            $this->form_validation->set_message('valid_email', 'El campo %s no es un correo valido');
            $this->form_validation->set_message('is_unique', 'El valor de %s ya esta asociado a otra cuenta');

            if($this->form_validation->run() == false){
                $this->load->view('registration_form');
            }
            else{
                // $this->load->model('Login_Database');
                $data = array(
                    'user_name' => $this->input->post('username'),
                    'user_email' => $this->input->post('email_value'),
                    //Agregamos el hash de la contraseña
                    'user_password' => sha1($this->input->post('password')),
                );
                $result = $this->Login_Database->registration_insert($data);
                if($result){
                    $this->session->set_flashdata('message_display', 'Usuario registrado correctamente!');
                    redirect('/');
                }
                else{
                    $data['message_error'] = 'No se pudo registrar el usuario.';
                    redirect('/user_authentication/user_registration_show', $data);
                }
            }
        }

        public function user_login_process(){
            $this->form_validation->set_rules('username', 'Usuario', 'trim|required');
            $this->form_validation->set_rules('password', 'Contraseña', 'trim|required');
            $this->form_validation->set_message('required', 'El campo %s es requerido');

            if($this->form_validation->run() == false){
                if(isset($this->session->userdata['logged_in'])){
                    redirect("/estudiantes");
                }
                else{
                    $this->load->view('login_form');
                }
            }else{
                $data = array(
                    'username' => $this->input->post('username'),
                    //Se encripta la contraseña para poder compararla
                    'password' => sha1($this->input->post('password')),
                );
                $result = $this->Login_Database->login($data);
                //Si result es true si las credenciales del usuario son correctas
                if($result == true){
                    $username = $this->input->post('username');
                    $result = $this->Login_Database->read_user_information($username);
                    if($result != false){
                        $session_data = array(
                            'username' => $result[0]->user_name,
                            'email' => $result[0]->user_email,
                        );
                        //Guardando la informacion del usuario en la sesion
                        $this->session->set_userdata('logged_in', $session_data);
                        redirect("/Estudiantes_controller");
                        // echo base_url('Estudiantes_controller');
                    }
                }else{
                    $this->session->set_flashdata('message_error', 'Usuario  o contraseña incorrectos.');
                    redirect("/");
                }
            }
        }

        public function logout(){
            $sess_array = array(
                'username' => '',
            );

            //Eliminando informacion de la sesion
            $this->session->unset_userdata('logged_in', $sess_array);
            $this->session->set_flashdata('message_display', 'Sesion cerrada correctamente, !vuelve pronto!.');
            redirect("/");
        }

    }
?>