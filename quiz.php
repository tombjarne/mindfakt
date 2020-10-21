<?php
	require_once("./include/db.class.php");
	require_once("./include/functions.php");
	$db = new db();
	$count = null;
	$id_user = 10001;

	if ($_POST['count'] != null) $count = $_POST['count'];
	else $count = 0;

	if ($count == 0) {
		$quiz = $db->excSelect("mindfakt", "question", "*", "art = 0", "RAND()", 10);

		for ($i = 0; $i < sizeof($quiz); $i++) {
			$answers = array($quiz[$i]['answer_1'], $quiz[$i]['answer_2'], $quiz[$i]['answer_3'], $quiz[$i]['answer_4']);
			shuffle($answers);
			$quiz[$i]['answer_1'] = $answers[0];
			$quiz[$i]['answer_2'] = $answers[1];
			$quiz[$i]['answer_3'] = $answers[2];
			$quiz[$i]['answer_4'] = $answers[3];
		}
	}

	if ($_POST['quiz'] != null) $quiz = $_POST['quiz'];
	if ($_POST['answer'] != null) $_POST['user_answers'] .= $_POST['answer']."|";
?>

<!doctype html>
<html>
	<head>
		<?php generateHead("Mindfakt - Quiz"); ?>
	</head>
		
	<body>
		<header>
			<?php generateNavigation("quiz"); ?>
		</header>
		
		<main>
			<article id="quiz-site">
				<?php if ($count != 10) { ?>
				<form id="quiz" action='quiz.php' method='post'>

					<section id="question">
						<?php print $quiz[$count]['question'] ?>
					</section>

					<section class="block1">
						<input class="answer" type="submit" name="answer" value="<?php print $quiz[$count]['answer_1'] ?>">
						<input class="answer" type="submit" name="answer" value="<?php print $quiz[$count]['answer_2'] ?>">
					</section>

					<section class="block2">
						<input class="answer" type="submit" name="answer" value="<?php print $quiz[$count]['answer_3'] ?>">
						<input class="answer" type="submit" name="answer" value="<?php print $quiz[$count]['answer_4'] ?>">
					</section>
					<section id="timebar">
						<!-- Code für Zeitbalken-->
					</section>
					<input type="hidden" name="count" value="<?php print $count+1; ?>">
					<?php //print "<pre>".print_r($quiz, true).print"</pre>"; ?>
					<?php
						$index = 0;
						foreach ($quiz as $questions)
						{
							print '<input type="hidden" name="quiz['.$index.'][id_question]" value="' . $questions['id_question'] . '">';
							print '<input type="hidden" name="quiz['.$index.'][points]" value="' . $questions['points'] . '">';
							print '<input type="hidden" name="quiz['.$index.'][art]" value="' . $questions['art'] . '">';
							print '<input type="hidden" name="quiz['.$index.'][answer_1]" value="' . $questions['answer_1'] . '">';
							print '<input type="hidden" name="quiz['.$index.'][answer_2]" value="' . $questions['answer_2'] . '">';
							print '<input type="hidden" name="quiz['.$index.'][answer_3]" value="' . $questions['answer_3'] . '">';
							print '<input type="hidden" name="quiz['.$index.'][answer_4]" value="' . $questions['answer_4'] . '">';
							print '<input type="hidden" name="quiz['.$index.'][question]" value="' . $questions['question'] . '">';
							print '<input type="hidden" name="quiz['.$index.'][time]" value="' . $questions['time'] . '">';
							print '<input type="hidden" name="quiz['.$index.'][date]" value="' . $questions['date'] . '">';
							print '<input type="hidden" name="quiz['.$index.'][active]" value="' . $questions['active'] . '">';
							print '<input type="hidden" name="quiz['.$index.'][id_category]" value="' . $questions['id_category'] . '">';
							$index++;
						}
					?>
					<input type="hidden" name="user_answers" value="<?php print $_POST['user_answers'] ?>">
				</form>
				<?php } else {
					$questions = $quiz[0]['id_question'];
					for ($i = 1; $i < sizeof($quiz); $i++) { $questions .= "|".$quiz[$i]['id_question']; }
					$next_id = $db->getIndex("mindfakt", "quiz", "id_quiz");

					$data = array($next_id, $questions, time(), 1);
					$db->excInsert("mindfakt", "quiz", $data, "quiz");

					$data = array($id_user, $next_id, substr($_POST['user_answers'], 0, -1), time(), 1);
					$db->excInsert("mindfakt", "userquiz", $data, "userquiz");

					$result = checkAnswers($db, $next_id, $id_user);
					print "<article id='result'><p>Du hast " .$result['points']/10 . " von 10 Antworten richtig!</p></article>";
				} $points = ($result['points'] != 0 ? $result['points'] : '0'); ?>
				<article id="score"><p>Du hast <?php print $points ?> Punkte erreicht</p></article>
			</article>
		</main>
		
		<footer>
			
		</footer>
	</body>
</html>