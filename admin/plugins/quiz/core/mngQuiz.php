<?php


##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

require '../vendor/autoload.php';		// If installed via composer
$debug = new \bdk\Debug(array(
	'collect' => true,
	'output' => true,
));

spl_autoload_register('autoloader');

function autoloader($class){
	include("../class/$class.php");
}

$database = new Database();
$db = $database->getConnection();

include "../inc/class_initialize.php";

$setting->name="lang" ;
$stmt = $setting->showByName();
$lang = $stmt['value'];

$operation = filter_input(INPUT_POST,"operation");

foreach (glob("../locale/$lang/*.php") as $row){
    require "$row";
}

if(filter_input(INPUT_GET,'idToDel')){

	$id_quiz = filter_input(INPUT_GET,'idToDel') ;
	$quiz->table = 'quiz' ;
	$quiz->id = $id_quiz ;

	if($quiz->delete('id')){
		
		$quiz->table = 'quiz_relation' ;
		$quiz->quiz_id = $id_quiz ;

		if($quiz->delete('quiz_id')){
			header("Location: ../index.php?p=allQuiz&msg=quizDeleted") ;
			exit;
		}else{
			header("Location: ../index.php?p=allQuiz&err=quizNotDeleted") ;
			exit;
		}
	}

}

if($operation=="add"){

	$counter = $_POST['counter'] ;

	$name = $_POST['name'];
	$name = str_replace(" ","_",$name);
	$name = strtolower($name);

	$text="<?php ".PHP_EOL;
	$text .= '$quiz = ['.PHP_EOL ;

	for( $i=1; $i<=$counter; $i++ ){
		
		$q = $_POST["q_$i"] ;

		$o_var = 'o_'.$i.'';

		for($idx=0; $idx<4; $idx++ ){
			
			$var = $o_var.'_'.$idx.'';
			
			$_POST["o_$i"][$idx] ? $$var=$_POST["o_$i"][$idx] : $$var = "null" ;
			
		}

		$a = $_POST["a_$i"][0];

		$o_var_0 = $o_var.'_0' ;
		$o_var_1 = $o_var.'_1' ;
		$o_var_2 = $o_var.'_2' ;
		$o_var_3 = $o_var.'_3' ;

		$text .= "  [". PHP_EOL;
		$text .= "     \"q\" => \"$q\",". PHP_EOL;
		$text .= '     "o" => ["'.$$o_var_0.'", "'.$$o_var_1.'"';
		if($$o_var_2!='null'||!$$o_var_2){
			$text .= ', "'.$$o_var_2.'"';
		}
		if($$o_var_3!='null'||!$$o_var_3){
			$text .= ', "'.$$o_var_3.'"';
		}
		$text .= '],'. PHP_EOL ;
		$text .= "     \"a\" => $a". PHP_EOL;

		$i == $counter ? $text .= "  ]". PHP_EOL : $text .= "  ],". PHP_EOL;
	
	}
	$text .= "];";
			
	$quiz->table = "quiz" ;
	$quiz->quiz_name = $name ;
	$quiz->counter = $counter ;
	if($quiz->insert(['quiz_name','counter'])){
		
		$quiz->table = "quiz" ;
		$quiz->quiz_name = $name ;
		$stmt = $quiz->showAllWhere('id',['quiz_name']);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		extract($row);

		$quiz_dir = '../../quiz/q_'.$row['id'] ;
		$oldmask = umask(0);
		mkdir($quiz_dir, 0777, true);
		umask($oldmask);

		$score_dir = '../../quiz/q_'.$row['id'].'/score' ;
		$oldmask = umask(0);
		mkdir($score_dir, 0777, true);
		umask($oldmask);

		$file= $quiz_dir.'/qna.php';
		
		if(!file_put_contents($file, $text, FILE_APPEND)){
			
			$quiz->table = "quiz" ;
			$quiz->id = $row['id'] ;
			
			$quiz->delete('id');

			header("Location:  ../index.php?p=allQuiz&err=quizFailFile");
			exit;

		}else{

			chmod($file,0777);

			$quiz->relation_id = $_POST['relation'];
			$quiz->quiz_id = $row['id'];
			$quiz->table = "quiz_relation" ;
			
			if($quiz->insert(['quiz_id','relation_id'])){

				header("Location:  ../index.php?p=allQuiz&msg=quizOk");
				exit;

			}else{
				
				header("Location:  ../index.php?p=allQuiz&err=quizFailRelation");
				exit;

			}
		}

	}else{
						
		header("Location:  ../index.php?p=allQuiz&err=quizFailDb");
		exit;

	}
		

}else if($operation=="edit"){

	$counter = $_POST['counter'] ;

	$name = $_POST['name'];
	$name = str_replace(" ","_",$name);
	$name = strtolower($name);

	$quiz_id = $_POST['quiz_id'];

	$text="<?php ".PHP_EOL;
	$text .= '$quiz = ['.PHP_EOL ;

	for( $i=1; $i<=$counter; $i++ ){

		if(isset($_POST['check_'.$i.'']) || !isset($_POST['q_'.$i.''])){
			continue;
		}
		
		$q = $_POST["q_$i"] ;

		$o_var = 'o_'.$i.'';

		for($idx=0; $idx<4; $idx++ ){
			
			$var = $o_var.'_'.$idx.'';
			
			$_POST["o_$i"][$idx] ? $$var=$_POST["o_$i"][$idx] : $$var = "null" ;
			
		}

		$a = $_POST["a_$i"][0];

		$o_var_0 = $o_var.'_0' ;
		$o_var_1 = $o_var.'_1' ;
		$o_var_2 = $o_var.'_2' ;
		$o_var_3 = $o_var.'_3' ;
	
		$text .= "  [". PHP_EOL;
		$text .= "     \"q\" => \"$q\",". PHP_EOL;
		$text .= '     "o" => ["'.$$o_var_0.'", "'.$$o_var_1.'"';
		if($o_var_2!=null){
			$text .= ', "'.$$o_var_2.'"';
		}
		if($o_var_3!=null){
			$text .= ', "'.$$o_var_3.'"';
		}
		$text .= '],'. PHP_EOL ;
		$text .= "     \"a\" => $a". PHP_EOL;

		$i == $counter ? $text .= "  ]". PHP_EOL : $text .= "  ],". PHP_EOL;

		// $questions[]=$single;
		
	}
	$text .= "];";
	
	rename('../../quiz/q_'.$quiz_id.'/qna.php','../../quiz/q_'.$quiz_id.'/qna_tmp.php');
	
	$file='../../quiz/q_'.$quiz_id.'/qna.php';
	if(file_put_contents($file, $text, FILE_APPEND)){
		
		unlink('../../quiz/q_'.$quiz_id.'/qna_tmp.php');
		chmod($file,0777);

		
		$quiz->table = "quiz" ;
		$quiz->id = $quiz_id ;
		$quiz->quiz_name = $name ;
		$quiz->counter = $counter ;
		if($quiz->update(['quiz_name','counter'],'id')){
			
			$quiz->table = "quiz" ;
			$quiz->quiz_name = $name ;
			$stmt = $quiz->showAllWhere('id',['quiz_name']);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			extract($row);

			$quiz->relation_id = $_POST['relation'];
			$quiz->quiz_id = $row['id'];
			$quiz->table = "quiz_relation" ;
			
			if($quiz->update(['quiz_id','relation_id'],'quiz_id')){

				header("Location:  ../index.php?p=allQuiz&msg=quizEditOk");
				exit;

			}else{
				
				header("Location:  ../index.php?p=allQuiz&err=quizEditFailRelation");
				exit;

			}

		}else{
							
			header("Location:  ../index.php?p=allQuiz&err=quizEditFailDb");
			exit;

		}
		
	}else{

		rename('../../quiz/q_'.$quiz_id.'/qna_tmp.php','../../quiz/q_'.$quiz_id.'/qna.php');			
		
		header("Location:  ../index.php?p=allQuiz&err=quizEditFailFile");
		exit;

	}
}else if($operation=="editActive"){


	$idQuiz=filter_input(INPUT_POST,'idToMod');
	$active=filter_input(INPUT_POST,"activeQuiz");

	$quiz->id=$idQuiz;

	if($active){
		$quiz->active=1;
	}else{
		$quiz->active=0;
		$quiz->quiz_id = $idQuiz ;
		$winner = $quiz->checkScore();
		
		if($winner)
		{
			$quiz->winner_id = $winner ;
			$quiz->table = 'quiz_scores' ;
			if(!$quiz->insert(['quiz_id','winner_id'])){
				header("Location: ../index.php?p=editQuiz&idToMod=$id&err=scoreQuizErr");
				exit;
			}else{
				if($quiz->updateTable(['active'],'id','quiz')){
					header("Location: ../index.php?p=allQuiz&msg=activeScoreQuizSucc");
					exit;
				}else{
					header("Location: ../index.php?p=allQuiz&err=activeScoreQuizErr");
					exit;
				}
			}
		}
	}

	if($quiz->updateTable(['active'],'id','quiz')){
		header("Location: ../index.php?p=editQuiz&idToMod=$idQuiz&msg=activeQuizSucc");
		exit;
	}else{
		header("Location: ../index.php?p=editQuiz&idToMod=$idQuiz&err=activeQuizErr");
		exit;
	}

}
?>
