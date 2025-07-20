<?php
class Table
{
    const OPEN_TABLE = "<table";
    const CLASS_TABLE = " class='";
    private $class_name; //class for for example table stripped from bootstrap
    const CLOSE_OPEN_TABLE = "'>";
    const CLOSE_TABLE = "</table>";
    const OPEN_THEAD = "<thead>";
    const CLOSE_THEAD = "</thead>";
    const OPEN_TH = "<th>";
    const OPEN_TR = "<tr>";
    const OPEN_TD = "<td>";
    const CLOSE_TH = "</th>";
    const CLOSE_TR = "</tr>";
    const CLOSE_TD = "</td>";
    const OPEN_TBODY = "<tbody>";
    const CLOSE_TBODY = "</tbody>";
    private $th_data;
    private $td_data;
    private $num_of_rows_excluding_th;
 


    public function __construct($class_name,  $th_data,  $td_data,  $num_of_rows_excluding_th)
    {
        $this->class_name = $class_name;
        $this->th_data = $th_data;
        $this->td_data = $td_data;
        $this->num_of_rows_excluding_th = $num_of_rows_excluding_th;

    }
    public function getClassName()
    {
        return $this->class_name;
    }

    public function getThData()
    {
        return $this->th_data;
    }

    public function getTdData()
    {
        return $this->td_data;
    }

    public function getNumOfRowsExcludingTh()
    {
        return $this->num_of_rows_excluding_th;
    }


    public function setClassName($class_name)
    {
        $this->class_name = $class_name;
    }

    public function setThData($th_data)
    {
        $this->th_data = $th_data;
    }

    public function setTdData($td_data)
    {
        $this->td_data = $td_data;
    }

    public function setNumOfRowsExcludingTh($num_of_rows_excluding_th)
    {
        $this->num_of_rows_excluding_th = $num_of_rows_excluding_th;
    }






    public function print_table()
    {
        $table = TABLE::OPEN_TABLE;
        $table .= Table::CLASS_TABLE;
        $table .= $this->getClassName();
        $table .= Table::CLOSE_OPEN_TABLE;
        //open thead first
        $table .= Table::OPEN_THEAD;
        $table .= Table::OPEN_TR;
        foreach ($this->getThData() as $value) {
            $table .= Table::OPEN_TH . $value . Table::CLOSE_TH;
        }
        $table .= Table::CLOSE_TR;
        $table .= Table::CLOSE_THEAD;
        $table .= Table::OPEN_TBODY;

        $data=array();
        $data=$this->add_tr_td_tags_to_each_element_in_array($this->getTdData());
    
        foreach ($data as $value) {
            $table .= $value;
        }
          
        $table .= Table::CLOSE_TBODY;
        $table .= Table::CLOSE_TABLE;
        echo $table;
    }
    //this will add td and </td> to each element of array
    public function add_tr_td_tags_to_each_element_in_array($array_data){
        $new_array=array();
        $index=0;
        $size_of_array=sizeof($array_data);
        foreach ($array_data as $value) {
            if($index==0){
                $new_array[]=TABLE::OPEN_TR.Table::OPEN_TD.$value.Table::CLOSE_TD;
            }else if($index%4==0){
                $new_array[]=TABLE::OPEN_TR.Table::OPEN_TD.$value.Table::CLOSE_TD;
            }else if($index==$size_of_array){
                $new_array[]=Table::OPEN_TD.$value.Table::CLOSE_TD.Table::CLOSE_TR;
            }
            else{
                $new_array[]=Table::OPEN_TD.$value.Table::CLOSE_TD;

            }
            $index++;
        }
         
        return $new_array;
    }


}
