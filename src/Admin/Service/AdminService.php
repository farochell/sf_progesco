<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   05/02/2020
 * @time  :   11:42
 */

namespace App\Admin\Service;


use App\Manager\Service\ManagerService;

/**
 * Class AdminService
 *
 * @package App\Admin\Service
 *
 */
class AdminService extends ManagerService {
    
    /**
     * @return false|float
     */
    public function getCacheSize() {
        $cache = $this->getContainer()->getParameter('cache_directory');
        
        return $this->repoSize($cache) / 1000000;
    }
    
    /**
     *
     */
    public function clearCache() {
        $cache = $this->getContainer()->getParameter('cache_directory');
        $this->delete_files($cache);
    }
    
    /**
     * @param $dirname
     *
     * @return bool
     */
    function delete_directory($dirname) {
        if (is_dir($dirname))
            $dir_handle = opendir($dirname);
        if (!$dir_handle)
            return false;
        while($file = readdir($dir_handle)) {
            if ($file != "." && $file != "..") {
                if (!is_dir($dirname."/".$file))
                    unlink($dirname."/".$file);
                else
                    $this->delete_directory($dirname.'/'.$file);
            }
        }
        closedir($dir_handle);
        //rmdir($dirname);
        return true;
    }
    
    function delete_files($target) {
        if(is_dir($target)){
            $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned
            
            foreach( $files as $file ){
                $this->delete_files( $file );
            }
            
            rmdir( $target );
        } elseif(is_file($target)) {
            unlink( $target );
        }
    }
    
    /**
     * @param $repository
     *
     * @return false|int
     */
    function repoSize($repository)
    {
        $root=opendir($repository);
        $size=0;
        while($folder = readdir($root))
        {
            if ( $folder != '..' And $folder !='.' )
            {
                //Ajoute la taille du sous dossier
                if(is_dir($repository.'/'.$folder)) $size += $this->repoSize($repository.'/'.
                    $folder);
                //Ajoute la taille du fichier
                else $size += filesize($repository.'/'.$folder);
                
            }
        }
        closedir($root);
        return $size;
    }
}