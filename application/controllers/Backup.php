<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backup extends CI_Controller {
    
public function backup(){
    $this->load->dbutil();
    $db_format=array('format'=>'sql','filename'=>'school.sql',
        'foreign_key_checks' => FALSE,
    );
    $backup=& $this->dbutil->backup($db_format);
    $encrypt_backup=$this->encrypt->encode($backup);
    $dbname='backup-on-'.date('Y-m-d').'.sql';
    $save='db/'.$dbname;
    write_file($save,$backup);
    force_download($dbname,$encrypt_backup);
}

}