<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   14/02/2020
 */

namespace App\Accounting\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class ExpenseLineFileUploader
 *
 * @package App\Accounting\Service
 *
 */
class ExpenseLineFileUploader {
    private $targetDirectory;
    
    /**
     * ExpenseLineFileUploader constructor.
     *
     * @param $targetDirectory
     */
    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }
    
    /**
     * @param UploadedFile $file
     *
     * @return string
     */
    public function upload(UploadedFile $file)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
        
        try {
            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {
            throw new FileException($e->getMessage());
        }
        
        return $fileName;
    }
    
    /**
     * @return mixed
     */
    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}