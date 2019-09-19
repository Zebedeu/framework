<?php

namespace Ballybran\Helpers\Images;

class UploadTool
{
    /**
     * @var arr => = infos sobre os arquivos enviados
     */
    private $upload_info = array();

    /**
     * @param string => $input_name     = nome do input
     * @param string => $folder_to_move = nome da pasta em que o arquivo será salvo
     * @param arr =>    $mime_allowed   = mime types permitidos no processo de upload
     * @param bol =>    $return_json    = se true retorna um objeto json
     */
    public function manage_single_file(string $input_name , string $folder_to_move , array $mime_allowed = [] , bool $return_json = true)
    {
        $resultado = array();
        $count_mime_allowed = count($mime_allowed);
        if (is_uploaded_file($_FILES[$input_name]['tmp_name'])) {
            $new_name_file = bin2hex(random_bytes(64)) . '.' . pathinfo($_FILES[$input_name]['name'] , PATHINFO_EXTENSION);
            $this->upload_info = array(
                'name' => $new_name_file ,
                'size' => $_FILES[$input_name]['size'] ,
                'mime' => finfo_file(finfo_open(FILEINFO_MIME_TYPE) , $_FILES[$input_name]['tmp_name']) ,
                'extension' => pathinfo($_FILES[$input_name]['name'] , PATHINFO_EXTENSION) ,
                'check_mime' => true ,
                'folder_to_move' => $folder_to_move ,
                'error_code' => $_FILES[$input_name]['error'] ,
            );
            if ($count_mime_allowed > 0 && !in_array($this->upload_info['mime'] , $mime_allowed , true)) {
                $this->upload_info['check_mime'] = false;
            }
            if ($this->upload_info['error_code'] === 0 && $this->upload_info['check_mime'] === true) {
                move_uploaded_file($_FILES[$input_name]['tmp_name'] , $folder_to_move . $this->upload_info['name']);
            }
        }
        $resultado['upload_info'] = $this->upload_info;
        if ($return_json) {
            echo json_encode($resultado);
        }
        if (!$return_json) {
            return $resultado;
        }
    }

    /**
     * @param string => $input_name     = nome do input
     * @param string => $folder_to_move = nome da pasta em que o arquivo será salvo
     * @param arr =>    $mime_allowed   = mime types permitidos no processo de upload
     * @param bol =>    $return_json    = se true retorna um objeto json
     */
    public function manage_multiple_file(string $input_name , string $folder_to_move , array $mime_allowed = [] , bool $return_json = true)
    {
        $resultado = array();
        $count_mime_allowed = count($mime_allowed);
        $qtd_arquivos_enviados = count($_FILES[$input_name]['tmp_name']);
        for ($i = 0; $i < $qtd_arquivos_enviados; ++$i) {
            if (is_uploaded_file($_FILES[$input_name]['tmp_name'][$i])) {
                $new_name_file = bin2hex(random_bytes(64)) . '.' . pathinfo($_FILES[$input_name]['name'][$i] , PATHINFO_EXTENSION);
                $this->upload_info[] = array(
                    'name' => $new_name_file ,
                    'size' => $_FILES[$input_name]['size'][$i] ,
                    'mime' => finfo_file(finfo_open(FILEINFO_MIME_TYPE) , $_FILES[$input_name]['tmp_name'][$i]) ,
                    'extension' => pathinfo($_FILES[$input_name]['name'][$i] , PATHINFO_EXTENSION) ,
                    'check_mime' => true ,
                    'folder_to_move' => $folder_to_move ,
                    'error_code' => $_FILES[$input_name]['error'][$i] ,
                );
                if ($count_mime_allowed > 0 && !in_array($this->upload_info[$i]['mime'] , $mime_allowed , true)) {
                    $this->upload_info[$i]['check_mime'] = false;
                }
                if ($this->upload_info[$i]['error_code'] === 0 && $this->upload_info[$i]['check_mime'] === true) {
                    move_uploaded_file($_FILES[$input_name]['tmp_name'][$i] , $folder_to_move . $this->upload_info[$i]['name']);
                }
            }
        }
        $resultado['upload_info'] = $this->upload_info;
        if ($return_json) {
            echo json_encode($resultado);
        }
        if (!$return_json) {
            return $resultado;
        }
    }
}
