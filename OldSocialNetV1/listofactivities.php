
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
	global $dbc;
	$listaNenapravljenihAktivnosti=new UndoneActivityLinkedList();
	$sql  = "select k.id,k.suggestion from kvaliteta k left join obavljeno o on k.id=o.kvaliteta_id where o.id is null";
	$a=mysqli_query($dbc,$sql);
	while($ro=mysqli_fetch_array($a)){
		$listaNenapravljenihAktivnosti->insert($ro['suggestion']);
		
	}
	mysqli_close($dbc);
	return $listaNenapravljenihAktivnosti->printList();

}




?>