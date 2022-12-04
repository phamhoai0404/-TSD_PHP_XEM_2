<?php


namespace App\Services\Inf;


use Howtomakeaturn\PDFInfo\Exceptions\CommandNotFoundException;
use Howtomakeaturn\PDFInfo\Exceptions\OpenOutputException;
use Howtomakeaturn\PDFInfo\Exceptions\OpenPDFException;
use Howtomakeaturn\PDFInfo\Exceptions\OtherException;
use Howtomakeaturn\PDFInfo\Exceptions\PDFPermissionException;

class PDFInfoService
{
    protected $file;
    public $output;

    public $title;
    public $author;
    public $creator;
    public $producer;
    public $creationDate;
    public $modDate;
    public $tagged;
    public $form;
    public $pages;
    public $encrypted;
    public $pageSize;
    public $fileSize;
    public $optimized;
    public $PDFVersion;

    public static $bin;

    public function __construct($file)
    {
        $this->file = $file;

        $this->loadOutput();

        $this->parseOutput();
    }

    public function getBinary()
    {
        if (empty(static::$bin)) {
            static::$bin = env('PDFINFO_BIN', 'pdfinfo');
        }

        return static::$bin;
    }

    private function loadOutput()
    {
        $cmd = escapeshellarg($this->getBinary()); // escapeshellarg to work with Windows paths with spaces.

        $file = escapeshellarg($this->file);
        // Parse entire output
        // Surround with double quotes if file name has spaces
        exec("$cmd $file", $output, $returnVar);

        if ($returnVar == 1) {
            throw new OpenPDFException();
        } else if ($returnVar == 2) {
            throw new OpenOutputException();
        } else if ($returnVar == 3) {
            throw new PDFPermissionException();
        } else if ($returnVar == 99) {
            throw new OtherException();
        } else if ($returnVar == 127) {
            throw new CommandNotFoundException();
        }

        $this->output = $output;
    }

    private function parseOutput()
    {
        $this->title = $this->parse('Title');
        $this->author = $this->parse('Author');
        $this->creator = $this->parse('Creator');
        $this->producer = $this->parse('Producer');
        $this->creationDate = $this->parse('CreationDate');
        $this->modDate = $this->parse('ModDate');
        $this->tagged = $this->parse('Tagged');
        $this->form = $this->parse('Form');
        $this->pages = $this->parse('Pages');
        $this->encrypted = $this->parse('Encrypted');
        $this->pageSize = $this->parse('Page size');
        $this->fileSize = $this->parse('File size');
        $this->optimized = $this->parse('Optimized');
        $this->PDFVersion = $this->parse('PDF version');
        $this->pageRot = $this->parse('Page rot');
    }

    private function parse($attribute)
    {
        // Iterate through lines
        $result = null;
        foreach ($this->output as $op) {
            // Extract the number
            if (preg_match("/" . $attribute . ":\s*(.+)/i", $op, $matches) == 1) {
                $result = $matches[1];
                break;
            }
        }

        return $result;
    }
}
