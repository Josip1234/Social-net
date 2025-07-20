<?php
class Table
{
    const OPEN_TABLE = "<table";
    const CLASS_TABLE = "class='";
    private $class_name; //class for for example table stripped from bootstrap
    const CLOSE_OPEN_TABLE = "'>";
    private $header; //true if user wants a table header false if he does not
    private $footer; //same as header
    const CLOSE_TABLE = "</table>";
    private $how_many_rows; //how many rows table could have
    private $how_many_cols; //how many cols table could have
    private $dynamic_cols_rows; //if true, table will automaticly add rows and cols
    //will be usefull for making a table which prints data from database
    private $data_rows; //class will recieve what data will be in th or first row 
    //if user does not want table header
    private $data_cols; //data which will be as table data per row 
    const OPEN_TH = "<th>";
    const OPEN_TR = "<tr>";
    const OPEN_TD = "<td>";
    const CLOSE_TH = "</th>";
    const CLOSE_TR = "</tr>";
    const CLOSE_TD = "</td>";

    public function __construct($class_name,  $header,  $footer,  $how_many_rows,  $how_many_cols,  $dynamic_cols_rows,  $data_rows,  $data_cols)
    {
        $this->class_name = $class_name;
        $this->header = $header;
        $this->footer = $footer;
        $this->how_many_rows = $how_many_rows;
        $this->how_many_cols = $how_many_cols;
        $this->dynamic_cols_rows = $dynamic_cols_rows;
        $this->data_rows = $data_rows;
        $this->data_cols = $data_cols;
    }

    public function getClassName()
    {
        return $this->class_name;
    }

    public function getHeader()
    {
        return $this->header;
    }

    public function getFooter()
    {
        return $this->footer;
    }

    public function getHowManyRows()
    {
        return $this->how_many_rows;
    }

    public function getHowManyCols()
    {
        return $this->how_many_cols;
    }

    public function getDynamicColsRows()
    {
        return $this->dynamic_cols_rows;
    }

    public function getDataRows()
    {
        return $this->data_rows;
    }

    public function getDataCols()
    {
        return $this->data_cols;
    }

    public function setClassName($class_name)
    {
        $this->class_name = $class_name;
    }

    public function setHeader($header)
    {
        $this->header = $header;
    }

    public function setFooter($footer)
    {
        $this->footer = $footer;
    }

    public function setHowManyRows($how_many_rows)
    {
        $this->how_many_rows = $how_many_rows;
    }

    public function setHowManyCols($how_many_cols)
    {
        $this->how_many_cols = $how_many_cols;
    }

    public function setDynamicColsRows($dynamic_cols_rows)
    {
        $this->dynamic_cols_rows = $dynamic_cols_rows;
    }

    public function setDataRows($data_rows)
    {
        $this->data_rows = $data_rows;
    }

    public function setDataCols($data_cols)
    {
        $this->data_cols = $data_cols;
    }
}
