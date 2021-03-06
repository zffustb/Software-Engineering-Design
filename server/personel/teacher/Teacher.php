<?php
require_once("../Personel.php");
require_once("../../db/DbFun.php");
require_once("../../topic/Topic.php");
class Teacher extends Personel {
    private $teaId; 
    // 用于存放教师拥有的选题的数组。
    private $topicArr=array();

    public function getTeaId() {
        return $this->teaId;
    } 
    public function setTeaId($teaId) {
        $this->teaId = $teaId;
    } 
    public function getTopicArr() {
        return $this->topicArr;
    } 
    public function setTopicArr($topicArr) {
        $this->topicArr = $topicArr;
    } 
    // ***************************************
    //初始化教师信息
    public function initSinglePersonel(){
    	$teaInfo=array("tea_id"=>$this->getTeaId(),"name"=>$this->getName(),"password"=>$this->getTeaId());
		insert("teacher",$teaInfo);
    }
	public function updateName(){
		update("teacher","tea_id",$this->getTeaId(),$this->getName());
	}
	//更新数据表中的人员的邮箱。
	public function updateEmail(){
		update("teacher","tea_id",$this->getTeaId(),$this->getEmail());
	}
	//更新数据表中的人员的电话号码。
	public function updatePhoneNumber(){
		update("teacher","tea_id",$this->getTeaId(),$this->getEmail());
	}
	//更新数据表中的人员的专长。
	public function updateExpertise(){
		update("teacher","tea_id",$this->getTeaId(),$this->getExpertise());
	}
	//更新数据表中的人员的密码。
	public function updatePassword(){
		update("teacher","tea_id",$this->getTeaId(),$this->getExpertise());
	} 
    //在$TopicArr数组中存放教师所拥有的选题。
	//这个函数执行完了之后，$TopicArr数组中的选题的对象中只有选题的题号，其他属性还没有初始化。
	public function setTeacherTopic() {
		$topicArr=array();
		$TeacherTopIdArr=$this->getTeacherTopId();
		// echo "在Teacher的setTeacherTopic中：<br>";
		// echo '$TeacherTopIdArr：<br>';
		// print_r($TeacherTopIdArr);
		
		//到这，$TeacherTopIdArr是正确的。
		// echo '在Teacher的setTeacherTopic的foreach中：<br>';
		foreach($TeacherTopIdArr as $topId){
			$teacherSingleTopic= new Topic();
			$teacherSingleTopic->setTopId($topId);
			$teacherSingleTopic->getTopicInfoFromDb();
			// echo '$teacherSingleTopic->getName()为：'.$teacherSingleTopic->getName().'<br>';
			array_push($topicArr,$teacherSingleTopic);
		}
		$this->setTopicArr($topicArr);
    } 
    // 该函数返回教师拥有的所有选题的选题号。
	//返回的$topIdArr是一个数组，是正确的。
    private function getTeacherTopId() {
		//注意下面的函数的参数里面的keyName和keyValue部分不是topic表中的key和相应的value。
		// echo "在Teacher的getTeacherTopId中：<br>";
        $topIdStmt=queryListCondition("topic", "top_id", "tea_id", $this->getTeaId());
		$topIdArr=array();
		foreach ($topIdStmt as $row){
			array_push($topIdArr,$row['top_id']);
		}
		// echo '$topIdArr为：<br>';
		// print_r($topIdArr);
		// echo "<br>";
		// echo "<br>";
		return $topIdArr;
    } 
    // TODO
    public function updateSinglePersonel() {
    } //ENDTODO
    public function releaseTopic($name, $background, $requirement) {
        $releaseTop->createTop($this->getTeaId(), $name, $background, $requirement);
    } 
    public function updateBackgrond($topic) {
        $topic->updateBackgrond();
    } 
    public function updateReqirement($topic) {
        $topic->updateRqirement();
    } 
    public function deleteTopic($topic) {
        $topic->deleteTopic();
    } 
    // Top是选题的对象，taskBookUrl是存放的路径。
    public function writeTaskBook($taskBookUrl, $top) {
        $taskBook = array('top_id' => $top->getTopId(), 'task_book_name' => $taskBookUrl);
        insert("task_book", $taskBook);
    } 
    public function selectteacher($stuId, $topId) {
        $selectStu = array('stu_id' => $stuId, 'top_id' => $topId);
        insert("successful_apply", $selectStu);
    } 
    public function viewTopicSelectionReport($stuId) {
        return querySingle('topic_selection_report', 'stu_id', $stuId, 'topic_selection_report_url');
    } 
	// 不是的，存放的是内容。
	//这里修改增加了一个name变量用来存放路径信息
    public function writeGuidingOpinion($stuId, $url, $guidingOpinionContent) {
        $guidingOpinion = array('stu_id' => $stuId, 'topic_selection_report_url'=>$url, 'guiding_opinion' => $guidingOpinionContent);
        insert("topic_selection_report", $guidingOpinion);
    } 
    public function writeAmendment($stuId,$url,$amendment) {
        $amendments = array('stu_id' => $stuId, 'paper_url' => $url, 'amendment' => $amendment);
        insert("editing_paper", $amendments);
    } 
    public function writeTutorOpinion($stuId,$modifyingOpinion) {
        $tutorOpinion = array('stu_id' => $stuId, 'instructor_opinion_sheet_url' => $modifyingOpinion);
        insert("teacher", $modifyingOpinion);
    } 
    public function selectAppraiser($Appraiser) {
        $chooseAppraiser = array('tea_id' => $Appraiser);
        insert("appraiser", $chooseAppraiser);
    } 
    public function viewFinalPaper($stuId) {
        return querySingle('final_paper', 'stu_id', $stuId, 'paper_name');
    } 
} 
