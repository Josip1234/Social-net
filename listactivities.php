<?php

class ListNode{
	public $data=NULL;
	public $next=NULL;
	public function __construct(string $data=NULL){
	    $this->data=$data;
	}
}
class UndoneActivityLinkedList{
	private $firstNode=NULL;
	private $totalNodes=0;
	public function insert(string $data=NULL){
	    $newNode=new ListNode($data);
	    if($this->firstNode===NULL){
	        $this->firstNode=&$newNode;
	    }else{
	        $currentNode=$this->firstNode;
	        while ($currentNode->next!==NULL){
	            $currentNode=$currentNode->next;
	        }
	        $currentNode->next=$newNode;
	    }
	    $this->totalNodes++;
	    return true;
	}
	public function printList(){
	    
	    $currentNode=$this->firstNode;
	    while ($currentNode!==NULL){
	        echo $currentNode->data;
	        $currentNode=$currentNode->next;
	    }
	}
}
function ispisAktivnostiIzBaze(){
	include "dbconn.php";
	$listaNenapravljenihAktivnosti=new UndoneActivityLinkedList();
	$sql  = "SELECT kvaliteta.id,suggestion FROM `kvaliteta`,obavljeno WHERE kvaliteta.id = obavljeno.id_feedbacka AND obavljeno.obavljeno=0";
	$a=mysqli_query($dbc,$sql);
	while($ro=mysqli_fetch_array($a)){
		$listaNenapravljenihAktivnosti->insert($ro['suggestion']);
		
	}
	mysqli_close($dbc);
	return $listaNenapravljenihAktivnosti->printList();

}




?>