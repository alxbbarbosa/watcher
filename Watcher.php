<?php
/**
 * ==============================================================================================================
 *
 * Watcher: Classe para assistir todas mudanças em arquivos via browser 
 *
 * ----------------------------------------------------
 *
 * @author Alexandre Bezerra Barbosa <alxbbarbosa@yahoo.com.br>
 * @copyright (c) 2018, Alexandre Bezerra Barbosa
 * @version 1.00
 * ==============================================================================================================
 */
class Watcher
{
    protected $file;
    protected $pattern;

    public function __construct($filename, $pattern = null)
    {
        if (file_exists($filename)) {
            $this->file = popen("tail -f {$filename} 2>&1", "r");
        } else {
            throw new \Exception("File not found");
        }
        if (!is_null($pattern) && (@preg_match($pattern, '') !== FALSE)) {
            $this->pattern = $pattern;
        }
    }

    public function __destruct()
    {
        pclose($this->file);
    }

    public function getNext()
    {
        ob_flush();
        flush();
        $buffer = fgets($this->file);
        if (!is_null($this->pattern)) {
            if (!preg_match($this->pattern, $buffer)) {
                return;
            }
        }
        return $buffer;
    }

    public function end()
    {
        return feof($this->file);
    }
}