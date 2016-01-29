<?php


require_once("Dbconnection.php");

class Scrapp{
    public $url;
    public $output;
    public $ch;
    public $newarray=[];
    public $paragraph;
    public $h__one;
    public $image;
    public $count;
    public $folder__name;
    public $time;
    
    public function __construct($https)
    { 
        $this->url=$https;
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_HEADER, 0);
        curl_setopt($this->ch, CURLOPT_URL, $this->url);
        //  url http://www.tert.am/am/news/2016/01/28/ohanyan9/1914512
        curl_setopt($this->ch, CURLOPT_POST, 1);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        $this->output = curl_exec($this->ch);
        curl_close($this->ch);
        
    }
    public function validate_general($gen__patern)
    {
        preg_match_all($gen__patern, $this->output, $this->newarray);
     
;
// gen __ patern  '{<div\s+id="item"\s*>((?:(?:(?!<div[^>]*>|</div>).)++|<div[^>]*>(?1)</div>)*)</div>}si';
    }
    public function connect_insert()
    {
       $this->time=time().'.png';
        foreach ($this->image['2'] as $item) {
            file_put_contents($this->folder__name .'/'. $this->time , file_get_contents($item));
           
        }
                   $con = new DbConnection();

        try {
            $con->connect->query("insert into scrapped__content (image__url,tiltle,content,image__name)
             values ('$this->time','$this->h__one','$this->paragraph','$item')");
            echo "Inserted";
        } catch (PDOException $ex) {
            echo $ex->getmessage();
        }
    }

    public function validate_content($header__pattern, $par__pattern, $image__finder)
    {
        foreach ($this->newarray as $value) {
          
            //$header__pattern '/<h1 ?.*>(.*)<\/h1>/'
            // $par__pattern  '{<p>((?:(?:(?!<div[^>]*>|</div>).)++|<div[^>]*>(?1)</p>)*)</div>}si'
            // find image by src /(<img[^>]*src *= *["']?)([^"']*)/i
            preg_match_all($header__pattern, $value['0'], $hone);
            preg_match_all($par__pattern, $value['0'], $parag);
            preg_match_all($image__finder, $value['0'], $this->image);
        }
        $this->paragraph .= $parag['0']['0'];
        $this->h__one .= $hone['0']['0'];
    }

    // public function increment()
    // {
    //     $_SESSION['count'] = !isset($_SESSION['count']) ? 0 : $_SESSION['count'];
    //     $_SESSION['count']++;
    //     return $_SESSION['count'];
    // }

   
    public function create_folder($folderName)
    {
        $this->folder__name=$folderName;
        if (!is_dir($folderName)) {
            mkdir($folderName, 0777);
        }
    }
//    function __destruct(){
//        session_destroy();
//    }
}
$er = new Scrapp('http://www.tert.am/am/news/2016/01/29/Foreign/1915128');

$er->create_folder("images");
$er->validate_general('{<div\s+id=\"item\"\s*>((?:(?:(?!<div[^>]*>|</div>).)++|<div[^>]*>(?1)</div>)*)</div>}si');
$er->validate_content('/<h1 ?.*>(.*)<\/h1>/', '{<p>((?:(?:(?!<div[^>]*>|</div>).)++|<div[^>]*>(?1)</p>)*)</div>}si', '/(<img[^>]*src *= *["\']?)([^"\']*)/i');
$er->connect_insert();
// if($con->connect->query("USE  users_db")) {
//       $con->connect->query("CREATE table if not exists user_info(
// id int(11) PRIMARY key not null AUTO_INCREMENT,
//     user_info_title text  ,
//     user_info_context mediumtext,
//     user_image text
// )");
// }


?>