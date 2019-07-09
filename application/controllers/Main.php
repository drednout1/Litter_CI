<?php
class Main extends CI_Controller
{
    public function start()
    {
                ini_set('display_errors', false);
                ini_set('display_startup_errors', false);
                error_reporting(E_ALL);

                $allowedExt = ['jpg', 'jpeg', 'GIF', 'BMP', 'PNG', 'Exif', 'TIFF', 'jfif',];

                if(isset($_FILES)){
                    $upload = $_FILES;
                };
            
                echo $filename = md5(time() . rand(1, 999999) . $upload['userFile']['name']);

                $this->load->database();

                $query = $this->db
                            ->from('files')
                            ->select ('*')
                            ->get();

                            echo '<pre>';
                            foreach ($query->result() as $row)
                            {
                                $row->userName;                   
                                $row->hashName;
                            
                        $userExt = explode('.', $row->hashName);
                        $userExt = $userExt[count($userExt) - 1];
                
                        $path = 'http://litterci/uploads/' . 
                        $row->userName[0] . '/' . 
                        $row->userName[1] . '/' . 
                        $row->userName; 
                        echo '<br>','<br>';
                        echo '<img src="' .$path . '.' .  $userExt. '" width="30%" height="20%" alt="Error">';
                        echo '<a href="http://litterci/main/download?name=' . $row->userName . '">Download</a>';
                    
                        echo '</pre>';
                            };
            
                $ext = explode('.', $upload['userFile']['name']);
                $ext = $ext[count($ext) - 1];
            
                if (!in_array($ext, $allowedExt)) {                
                };
            
                $subdirName = $filename[0];
                $subdirName2 = $filename[1];
            
                if (!file_exists('http://litterci/uploads/' .
                    $subdirName . '/' .
                    $subdirName2)) (mkdir('http://litterci/uploads/' .
                    $subdirName . '/' .
                    $subdirName2, 0777, true));
            
                move_uploaded_file(
                    $upload['userFile']['tmp_name'],
                    'http://litterci/uploads/' .
                        $subdirName . '/' .
                        $subdirName2 . '/' .
                        $filename . '.' . $ext
                );
                $this->load->view('templates/header');
                $this->load->view('pages/main');
                $this->load->view('templates/footer'); 
    }
         
    public function download(){
                if(isset($_GET['name'])){
                    $name = $_GET['name'];
                };
            
                if($name){
                    $this->load->database();
                };
                   
                $query = $this->db
                            ->from('files')
                            ->select ('*')
                            ->where('userName' , $name)
                            ->get();

                foreach ($query->result() as $row)
                {                   
                    $row->hashName;
                };
            
                $userExt = explode('.', $row->hashName);
                $userExt = $userExt[count($userExt) - 1];
            
                $path = 'http://litterci/uploads/' . 
                    $name[0] . '/' . 
                    $name[1] . '/' . 
                    $name . '.' . $userExt; 
            
                if ($path) {
                    header("Content-Disposition: attachment; filename=". $row->hashName. '.' . $userExt .'"');
                    header("Content-Type: octet-stream");
                    readfile($path);
            };   
            
    }

    public function upload(){
                    // header("Location: /main/start"); 
                    // require_once 'main.php';
                    if(isset($_FILES)){
                        $upload = $_FILES;
                    };
                
                    echo "<pre>";
                    print_r($upload);
                    echo " </pre> ";
                
                    if($upload){

                        $this->load->database();

                        $data = array(
                            'userName' => $filename,
                            'hashName' => $upload['userFile']['name']
                        );
                        $this->db->insert('files', $data);
                        
                };
    }
}

?>