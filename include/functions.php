<?php
	function generateHead($title) {
		print "
			<meta charset='utf-8'>
        	<meta description='Quizze und Dominiere deine Freunde auf Mindfakt, der Online-Quiz Plattform'>
        	<link rel='shortcut icon' type='image/x-icon' href='./include/pictures/favicon.ico'>
        	<link rel='stylesheet' href='./include/css/main.css'>
        	<script src='./include/js/main.js'></script>
			<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js'></script>
        	<title>$title</title>";
	}

	function generateNavigation($site) {
		print "
			<a href='./index.php'><img id='logo' src='./include/pictures/logo.png' alt='Mindfakt Logo'></a>
            <nav>
                <ul>
                    <li><a href='#'>Home</a></li>
                    <li><a href='./quiz.php'>Quiz</a></li>
                    <li><a href=''./contact.php'>Kontakt</a></li>
                </ul>
                <a href='./profile.php'><img id='profile-img' src='./include/pictures/user-profile-image.png' alt='Mindfakt Benutzer'></a>
            </nav>";
		
		print "
			<script>
			
			</script>";
	}
	
	function generateQuiz($idCategory) {
		
	}

	function checkAnswers($db, $idQuiz, $id_user) {
		$points = 0;
		$counter = 0;
		$quiz = $db->excSelect("mindfakt", "quiz", "id_list_questions", "`id_quiz` = ".$idQuiz);
		$userQuiz = $db->excSelect("mindfakt", "userquiz", "answers", "id_quiz =".$idQuiz." AND id_user =".$id_user);
		$id_questions = explode("|", $quiz['id_list_questions']);
		$answers = explode("|", $userQuiz['answers']);
		
		foreach ($id_questions as $id_question) {
			$question = $db->excSelect("mindfakt", "question", "`points`, `answer_1`", "`id_question` =".$id_question);
			
			// types = "mc" - multiple choice, "tof" - true or false
			if ($question['answer_1'] === $answers[$counter]) {
				$result[$id_question]['correct'] = "true";
				$result['points'] += $question['points'];
			}
			else {
				$result[$id_question]['correct'] = "false";
			}
			$counter++;
		}
		return $result;
	}


?>