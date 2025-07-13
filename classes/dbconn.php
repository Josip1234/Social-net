<?php 
class DatabaseConnection{
    private $host;
    private $user;
    private $pass;
    private $db;
    private $charset;
    public $dbconn;
    private $num_of_records;


    function __construct($host,$user,$pass,$db,$charset)
    {
        $this->host=$host;
        $this->user=$user;
        $this->$pass=$pass;
        $this->db=$db;
        $this->charset=$charset;
    }


    public function setDbconn( $dbconn) {$this->dbconn = $dbconn;}

    function connectToDatabase(){
           $dbconn=mysqli_connect($this->host,$this->user,$this->pass,$this->db);
           mysqli_set_charset($dbconn,$this->charset);
           $this->setDbconn($dbconn);
    }
    public function getHost() {return $this->host;}

	public function getUser() {return $this->user;}

	public function getPass() {return $this->pass;}

	public function getDb() {return $this->db;}

	public function getCharset() {return $this->charset;}

	public function getDbconn() {return $this->dbconn;}

	public function setHost( $host) {$this->host = $host;}

	public function setUser( $user) {$this->user = $user;}

	public function setPass( $pass) {$this->pass = $pass;}

	public function setDb( $db) {$this->db = $db;}

	public function setCharset( $charset) {$this->charset = $charset;}

    public function setNumOfRecords($num_of_records){
        $this->num_of_records=$num_of_records;
    }
    public function getNumOfRecords(){
        return $this->num_of_records;
    }
	
    public function close_database(){
        mysqli_close($this->dbconn);
    }

    public function get_num_of_records_from_table($table){
        $query="SELECT COUNT(*) FROM $table";
        $execute_query=mysqli_query($this->getDbconn(),$query);
        $result=$execute_query->fetch_column();
        $this->setNumOfRecords($result);
        return $this->num_of_records;
    }

        public function select_last_record_from_database($what_to_select,$table){
        $query="SELECT $what_to_select FROM $table WHERE id=(SELECT max(id) FROM $table)";
        $execute_query=mysqli_query($this->getDbconn(),$query);
        $result=$execute_query->fetch_column();
        return $result;
    }
    //return array of results as a result
    public function select_number_of_records_desc_sort($what_to_select,$table,$order_by,$limit){
        $array_result=array();
        $sql_query="SELECT ";
        //for any of the value of given array concatinate to sql query 
        //they are values from tables which we want to get
        //need to check last element in the field 
        //we need a index to increase it if index equal end of array do not concatinate ,
        $size_of_array=sizeof($what_to_select);
        $index=1;
        foreach ($what_to_select as $value) {
            if($index==$size_of_array){
                $sql_query .= "".$value."";
            }else if($index<$size_of_array){
                $sql_query .= "".$value.",";
            }
            $index++;
        }
        $sql_query .= " FROM $table ORDER BY $order_by DESC LIMIT $limit;";
        $exe=mysqli_query($this->getDbconn(),$sql_query);
        while($res=mysqli_fetch_array($exe)){
            for($i=0;$i<$size_of_array;$i++){
                $array_result[]=$res[$i];
            }
        }
        return $array_result;
    }
	
   
    //template for printing datafrom database
    //return array of fields as result
    public function print_all_data_from_database($table_name,$what_data_to_print){
        $result_arr=array();
        $query="SELECT * FROM $table_name";
        $statement=$this->getDbconn()->prepare($query);

        if($statement->execute()){
             $fetch_data=$statement->get_result();
            while($result=mysqli_fetch_array($fetch_data)){
               
                foreach ($what_data_to_print as  $value) {
                    $result_arr[]=$result[$value];
                }
            }
        }
      return $result_arr;

    }
    //this is template for checking unique values in tables 
    //wgat values can be sql function like count(*)
    public function check_for_unique($what_table,$what_values, $compare_field,$value_in_database){
        //if this value is 1 then value already exists in database 
        //if it is 0 value does not exists in database.
        $exists=0;

    $sql_part1 = "SELECT ";
    $sql_part2 ="";

    //ako postoji samo jedna vrijednost kao string spoji to sa stringom ako ne spoji polja
     if(gettype($what_values)=="string"){
           $sql_part2 .= $what_values;
     }else{
  foreach ($what_values as $value) {
        $sql_part2 .= $value;
    }
     }
  
    $sql_part3=" FROM ";
    $sql_part4=" ".$what_table." ";
    $sql_part5=" WHERE ";

    $sql_part6="  ".$compare_field."  ";
    $sql_part7="=?";
     
    $full_sql_query=$sql_part1.$sql_part2.$sql_part3.$sql_part4.$sql_part5.$sql_part6.$sql_part7;
    $stat = $this->getDbconn()->prepare($full_sql_query);
    $stat->bind_param("s", $value_in_database);
    $stat->execute();
    $result = $stat->get_result()->fetch_column();
    $this->setNumOfRecords($result);
     
    if($this->getNumOfRecords()>0){
          $exists=1;
    }else if($this->getNumOfRecords()==0){
        $exists=0;
    }

    return $exists;
    }
	

}



?>