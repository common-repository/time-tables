<?php 
$time_slots = explode(',', $time_table_time_slots2);
$day_slots = explode(',', $time_table_day_slots2);
$room_slots = explode(',', $time_table_room_slots2);
$classes = explode(',', $time_table_classes2);
$classes_courses = explode(',', $time_table_classes_courses2);

$double_classes_courses = array();
foreach ($classes_courses as $key => $value) {
	if($time_table_nofclassesperweek > 1){
		for ($i=0; $i < $time_table_nofclassesperweek; $i++) { 
			$double_classes_courses[] = $value;
		}
	}else{
		$double_classes_courses[] = $value;
	}
}

$classes_courses = $double_classes_courses;

//var_dump($classes_courses);


$total_classes = sizeof($classes);

$available_slots = array();
$available_class_slots = array();
foreach ($room_slots as $key1 => $value1) {
	foreach ($day_slots as $key2 => $value2) {
		foreach ($time_slots as $key3 => $value3) {
			$available_slots[] = $value2. '-->' . $value3 . '-->' . $value1;
		}
	}
}

shuffle($available_slots);



?>
<style>
.widefat td, .widefat th {
    border: 1px solid;
}
</style>

<?php
//new logic
$classes_sem = $classes;
$all_classes_courses = $classes_courses;
$slots_for_each_class = intval(sizeof($available_slots)/$total_classes);
$all_courses = sizeof($all_classes_courses);
$all_slots = sizeof($available_slots);

$all_courses_assign = array();
$all_final_assign = array();
$classes_courses_assign = array();
$empty_slots = array();

for ($l=0; $l < $all_slots; $l++) {
	if (array_key_exists($l, $available_slots)){
		$slot_det = $available_slots[$l];
		$slot_det = explode('-->', $slot_det);
		$slot_day = $slot_det[0];
		$slot_time = $slot_det[1];
		$slot_room = $slot_det[2];
		if (array_key_exists($l, $all_classes_courses)){
			$course_output = $all_classes_courses[$l];
		}
		$all_final_assign[] = $slot_day . '-->' . $slot_time . '-->'. $slot_room. '-->' . $course_output;
		if (array_key_exists($l, $all_classes_courses)){
			$classes_courses_assign[$l] = $slot_day . '-->' . $slot_time . '-->'. $slot_room. '-->' . $course_output;
		}else{
			$classes_courses_assign[$l] = $slot_day . '-->' . $slot_time . '-->'. $slot_room;
			$empty_slots[] = $slot_day . '-->' . $slot_time . '-->'. $slot_room;
		}

	} 
	
}

//checking for duplication of courses at same day and time
$i = 1;
$check_array_cs = array();
foreach ($classes_courses_assign as $key => $value) {
	$value = explode('-->', $value);
	$day = $value[0];
	$time = $value[1];
	$room = $value[2];
	if (array_key_exists(3, $value) && array_key_exists(4, $value) && array_key_exists(5, $value)){
    	$class = $value[3];
    	//$sem = $value[4];
    	$title = $value[4];
    	$teacher = $value[5];
    	
    	for ($i=0; $i < sizeof($classes_sem); $i++) {
    		if($class == $classes_sem[$i]){
        		$string = $day.$time.$room;
        		if(in_array($string, $check_array_cs)){
        			foreach ($classes_courses_assign as $key1 => $value1) {
								
						$course_to_output = explode('-->', $value1);
						$check_day = $course_to_output[0];
						$check_time = $course_to_output[1];
						if (array_key_exists(3, $course_to_output) && array_key_exists(4, $course_to_output) && array_key_exists(5, $course_to_output)){
							
						}else{
							$new_value = $value1;
							$new_value = explode("-->", $new_value);
							$new_value_day = $new_value[0];
							$new_value_time = $new_value[1];
							$new_string = $new_value_day.$new_value_time.$new_value[2];
							//$new_string = $new_value_day.$new_value_time.$class.$sem;
							if(in_array($new_string, $check_array_cs) || $new_string == $string){

							}else{
								$classes_courses_assign[$key] = $new_value_day. '-->'. $new_value_time. '-->' . $new_value[2] . '-->' . $class.'-->'. $title . '-->' . $teacher;
								//echo $classes_courses_assign[$key1];
								$check_array_cs[] = $new_string;
								break;	
							}
							
						}
					}
        		}else{
        			$check_array_cs[] = $string;
        		}
        	}
        	//break;
    	}
    	
	}
}

shuffle($classes_courses_assign);

//combining assigned slots for each class
$all_class_slots = array();
$duplicate_classes_courses = array();
$check_duplication = array();
$initial_duplication = 0;
if(!empty($classes)){
	foreach ($classes as $class_key => $class_value):
		$class_title_semester = $class_value;
		foreach ($day_slots as $key7 => $value7) {
	
			foreach ($time_slots as $key8 => $value8) {
				
				foreach ($classes_courses_assign as $key => $value) {
					
					$course_to_output = explode('-->', $value);
					$check_day = $course_to_output[0];
					$check_time = $course_to_output[1];
					$check_room = $course_to_output[2];
					if (array_key_exists(3, $course_to_output) && array_key_exists(4, $course_to_output) && array_key_exists(5, $course_to_output)){
						$check_class = $course_to_output[3];
						//$check_sem = $course_to_output[4];
						$check_course_title = $course_to_output[4];
						$course_teacher = $course_to_output[5];
						if($check_day == $value7 && $check_time == $value8 && $check_class == $class_title_semester){
							$string5 = $check_day.$check_time.$check_class;
							if(in_array($string5, $check_duplication)){
								$initial_duplication += 1;
								$duplicate_classes_courses[$check_class][] = $check_day.'-->'.$check_time.'-->'.$check_room.'-->'.$check_class.'-->'.$check_course_title.'-->'.$course_teacher;
								$all_class_slots[$check_class][] = $check_day.'-->'.$check_time.'-->'.$check_room.'-->'.$check_class.'-->'.$check_course_title.'-->'.$course_teacher;
							}else{
								$all_class_slots[$check_class][] = $check_day.'-->'.$check_time.'-->'.$check_room.'-->'.$check_class.'-->'.$check_course_title.'-->'.$course_teacher;
								$check_duplication[] = $string5;
							}
							
						}
					}
					
				}
			}
		
		}
	endforeach;
}

?>
<h2>New Time Table is generated, please update it to save this time table or refresh this page to randomly generate a new time table.</h2>
<input type="submit" class="codott_timetable_data_submit" value="Save" />
<h3>Total available slots = <?php echo sizeof($available_slots);?></h3>
<h3>Total courses = <?php echo sizeof($classes_courses);?></h3>
<h3>Total empty slots = <?php echo sizeof($empty_slots);?></h3>
<h3>Max Courses for any class = 
	<?php 
		$largeArraySize = 0;
		foreach($all_class_slots as $array) {
		   if(count($array) > $largeArraySize) {
		     $largeArray = $array;
		     $max_class_courses = count($array);
		     $largeArraySize = $max_class_courses;
		   }
		}
		echo $max_class_courses;
	?>
</h3>
<?php 
if(sizeof($available_slots) <= sizeof($classes_courses)){
?>
<div class="notice notice-error">
	<?php _e('No of Class Courses are greater than or equal to 
	number of available slots which may result in overlapping of courses at same time and day. 
	So increase number of time slots, day slots or room slots to get valid time table.', 'codott');?>
</div>
<?php
//exit();
goto codott_end_table_script;
}

if($max_class_courses > sizeof($time_slots)*sizeof($day_slots)){
?>
<div class="notice notice-error">
	<?php _e('One or more classes have greater courses per week than number of available slots 
		per week which may result in overlapping of courses at same time and day. So increase 
		number of time slots or day slots to get valid time table.', 'codott');?>
</div>
<?php
//exit();
goto codott_end_table_script;
}
?>

<?php
//To avoid overlapping of classes at same time and day 

if(!empty($classes)){
	$i = 0;
	do{
		$other_duplicate_classes = 0;
		$check_other_repeating_classes = array();
		foreach ($classes as $class_key => $class_value):
			$class_title_semester = $class_value;
			foreach ($day_slots as $key7 => $value7) {
				foreach ($time_slots as $key8 => $value8) {
					if(array_key_exists($class_title_semester, $all_class_slots)){
						foreach ($all_class_slots[$class_title_semester] as $key => $value) {
							$course_to_output = explode('-->', $value);
							$check_day = $course_to_output[0];
							$check_time = $course_to_output[1];
							$check_room = $course_to_output[2];
							if (array_key_exists(3, $course_to_output) && array_key_exists(4, $course_to_output) && array_key_exists(5, $course_to_output)){
								$check_class = $course_to_output[3];
								//$check_sem = $course_to_output[4];
								$check_course_title = $course_to_output[4];
								$course_teacher = $course_to_output[5];
								if($check_day == $value7 && $check_time == $value8 && $check_class == $class_title_semester){

									if(array_key_exists($class_title_semester, $duplicate_classes_courses)){
										if(in_array($value, $duplicate_classes_courses[$class_title_semester])){
											
											foreach ($empty_slots as $key6 => $value6) {
												foreach ($all_class_slots[$class_title_semester] as $key4 => $value4) {
													$emptying = explode('-->', $value6);
													//echo 'testing empty slot: '. $value6;
													$empty_day = $emptying[0];
													$empty_time = $emptying[1];
													$existing = explode('-->', $value4);
													$new_day = $existing[0];
													$new_time = $existing[1];
													
													if($empty_day == $new_day && $empty_time == $new_time){
														$matched = 'true';
														break;
													}else{
														$matched = 'false';		
													}

												}
												if($matched == 'false'){
													//$empty_slots[] = $all_class_slots[$class_title.$class_semester][$key];
													$empty_slots[] = $check_day.'-->'.$check_time.'-->'.$check_room;
													$all_class_slots[$class_title_semester][$key] = $value6.'-->'.$class_title_semester.'-->'.$check_course_title.'-->'.$course_teacher;	
													//echo 'empty slot day time: '. $empty_day. $empty_time. '</br>existing slot day time: '. $new_day. $new_time;
													if(array_key_exists($key6, $empty_slots)){
														unset($empty_slots[$key6]);
													} 
													break;	
												}
												
											}
											
										}
									}
									
								}
							}
							
						}
					}else{
						//echo 'this class does not have any courses';
					}
				}
			
			}
		endforeach;


		$check_other_repeating_classes = array();
		$other_duplicate_classes = 0;
		if(!empty($classes)){
			foreach ($classes as $class_key => $class_value):
				$class_title_semester = $class_value;
				foreach ($day_slots as $key7 => $value7) {
					foreach ($time_slots as $key8 => $value8) {
						if(array_key_exists($class_title_semester, $all_class_slots)){
							foreach ($all_class_slots[$class_title_semester] as $key3 => $value3) {
								
								$course_to_output = explode('-->', $value3);
								$check_day = $course_to_output[0];
								$check_time = $course_to_output[1];
								$check_room = $course_to_output[2];
								if (array_key_exists(3, $course_to_output) && array_key_exists(4, $course_to_output) && array_key_exists(5, $course_to_output)){
									$check_class = $course_to_output[3];
									//$check_sem = $course_to_output[4];
									$check_course_title = $course_to_output[4];
									$course_teacher = $course_to_output[5];
									if($check_day == $value7 && $check_time == $value8 && $check_class == $class_title_semester){
										$string4 = $check_class.$check_day.$check_time;
										if(in_array($string4, $check_other_repeating_classes)){
											$other_duplicate_classes +=1;
											
										}else{
											$check_other_repeating_classes[] = $string4;
										}
										
									}
								}
							}
						}
					}
				}
			endforeach;
			$i++;
		}
		//echo 'duplication in this phase: '. $other_duplicate_classes. '</br>';
	}while($other_duplicate_classes > 0 || $i < 5);
}


//To avoid overlapping of teacher 
for ($i=0; $i < 4 ; $i++) { 
	$duplicate_teachers = 0;
	$repeating_teacher_slots = array();
	$check_repeating_teacher = array();
	$teacher_slots = array();
	do{
	if(!empty($classes)){
		foreach ($classes as $class_key => $class_value) {
			$class_title_semester = $class_value;
			foreach ($day_slots as $key7 => $value7) {
				foreach ($time_slots as $key8 => $value8) {	
					if(array_key_exists($class_title_semester, $all_class_slots)){
						foreach ($all_class_slots[$class_title_semester] as $key => $value) {
							$course_to_output = explode('-->', $value);
							$check_day = $course_to_output[0];
							$check_time = $course_to_output[1];
							$check_room = $course_to_output[2];
							if (array_key_exists(3, $course_to_output) && array_key_exists(4, $course_to_output) && array_key_exists(5, $course_to_output)){
								$check_class = $course_to_output[3];
								//$check_sem = $course_to_output[4];
								$check_course_title = $course_to_output[4];
								$course_teacher = $course_to_output[5];
								if($check_day == $value7 && $check_time == $value8 && $check_class == $class_title_semester){
									$string200 = $check_day.$check_time.$course_teacher;
									if(in_array($string200, $teacher_slots)){

									}else{
										$teacher_slots[]=$string200;
									}
									$string10 = $course_teacher.$check_day.$check_time;
									if(in_array($string10, $check_repeating_teacher)){
										$duplicate_teachers += 1;
										$repeating_teacher_slots[] = $value;
										//echo 'repeating slot: '. $value . '</br>';
										foreach ($empty_slots as $key6 => $value6) {
											$empty_slot = explode('-->', $value6);
											$empty_day = $empty_slot[0];
											$empty_time = $empty_slot[1];
											$empty_room = $empty_slot[2];
											$string11 = $course_teacher.$empty_day.$empty_time;
											if(in_array($string11, $check_repeating_teacher)){

											}else{
												$check_class_duplication = array();
												foreach ($all_class_slots[$class_title_semester] as $key5 => $value5) {
													$class_slot = explode('-->', $value5);
													$class_day = $class_slot[0];
													$class_time = $class_slot[1];
													$class_check_title = $class_slot[3];
													//$class_check_sem = $class_slot[4];
													if($empty_day != $class_day && $empty_time != $class_time){
														$empty_slots[] = $check_day.'-->'.$check_time.'-->'.$check_room;
														$all_class_slots[$class_title_semester][$key] = $value6.'-->'.$class_title_semester.'-->'.$check_course_title.'-->'.$course_teacher;	
														//echo 'empty slot day time: '. $empty_day. $empty_time. '</br>existing slot day time: '. $new_day. $new_time;
														if(array_key_exists($key6, $empty_slots)){
															unset($empty_slots[$key6]);
														} 
														break 2;
													}
												}
												$check_repeating_teacher[] = $string11;
											}
										}
									}else{
										$check_repeating_teacher[] = $string10;
									}

								}
							}
							
						}
					}
					//echo 'total teacher duplications: '. $duplicate_teachers;
				}
					
			}
		}
	}
	} while( $duplicate_teachers = 0);

	//To avoid overlapping of classes at same time and day again

	$duplicate_classes_courses = array();
	$check_duplication = array();
	if(!empty($classes)){
		foreach ($classes as $class_key => $class_value) {
			$class_title_semester = $class_value;
			foreach ($day_slots as $key7 => $value7) {
		
				foreach ($time_slots as $key8 => $value8) {
					if(array_key_exists($class_title_semester, $all_class_slots)){
						foreach ($all_class_slots[$class_title_semester] as $key => $value) {
						
							$course_to_output = explode('-->', $value);
							$check_day = $course_to_output[0];
							$check_time = $course_to_output[1];
							$check_room = $course_to_output[2];
							if (array_key_exists(3, $course_to_output) && array_key_exists(4, $course_to_output) && array_key_exists(5, $course_to_output)){
								$check_class = $course_to_output[3];
								//$check_sem = $course_to_output[4];
								$check_course_title = $course_to_output[4];
								$course_teacher = $course_to_output[5];
								if($check_day == $value7 && $check_time == $value8 && $check_class == $class_title_semester){
									$string5 = $check_day.$check_time.$check_class;
									if(in_array($string5, $check_duplication)){
										$duplicate_classes_courses[$check_class][] = $check_day.'-->'.$check_time.'-->'.$check_room.'-->'.$check_class.'-->'.$check_course_title.'-->'.$course_teacher;
										//$all_class_slots[$check_class.$check_sem][] = $check_day.'-->'.$check_time.'-->'.$check_room.'-->'.$check_class.'-->'.$check_sem.'-->'.$check_course_title.'-->'.$course_teacher;
									}else{
										//$all_class_slots[$check_class.$check_sem][] = $check_day.'-->'.$check_time.'-->'.$check_room.'-->'.$check_class.'-->'.$check_sem.'-->'.$check_course_title.'-->'.$course_teacher;
										$check_duplication[] = $string5;
									}
									
								}
							}
							
						}
					}
				}
			
			}
		}
	}

	//var_dump($duplicate_classes_courses);

	$check_repeating_teacher = array();
	$duplicate_teachers = 0;
	if(!empty($classes)){
		foreach ($classes as $class_key => $class_value) {
			$class_title_semester = $class_value;
			foreach ($day_slots as $key7 => $value7) {
				foreach ($time_slots as $key8 => $value8) {
					if(array_key_exists($class_title_semester, $all_class_slots)){
						foreach ($all_class_slots[$class_title_semester] as $key => $value) {
							$course_to_output = explode('-->', $value);
							$check_day = $course_to_output[0];
							$check_time = $course_to_output[1];
							$check_room = $course_to_output[2];
							if (array_key_exists(3, $course_to_output) && array_key_exists(4, $course_to_output) && array_key_exists(5, $course_to_output)){
								$check_class = $course_to_output[3];
								//$check_sem = $course_to_output[4];
								$check_course_title = $course_to_output[4];
								$course_teacher = $course_to_output[5];
								if($check_day == $value7 && $check_time == $value8 && $check_class == $class_title_semester){
									//echo 'live';
									$string11 = $course_teacher.$check_day.$check_time;
									if(in_array($string11, $check_repeating_teacher)){
										$duplicate_teachers += 1;
									}else{
										$check_repeating_teacher[] = $string11;
									}
									if(array_key_exists($class_title_semester, $duplicate_classes_courses)){
										if(in_array($value, $duplicate_classes_courses[$class_title_semester])){
											//echo 'overlap found for: '. $value;
											foreach ($empty_slots as $key6 => $value6) {
												foreach ($all_class_slots[$class_title_semester] as $key4 => $value4) {
													$emptying = explode('-->', $value6);
													//echo 'testing empty slot: '. $value6;
													$empty_day = $emptying[0];
													$empty_time = $emptying[1];
													$existing = explode('-->', $value4);
													$new_day = $existing[0];
													$new_time = $existing[1];
													
													if($empty_day == $new_day && $empty_time == $new_time){
														$matched = 'true';
														break;
													}else{
														$matched = 'false';		
													}

												}
												if($matched == 'false'){
													$new_comp = $empty_day.$empty_time.$course_teacher;
													if(in_array($new_comp, $teacher_slots)){

													}else{
														$empty_slots[] = $check_day.'-->'.$check_time.'-->'.$check_room;
														$all_class_slots[$class_title_semester][$key] = $value6.'-->'.$class_title_semester.'-->'.$check_course_title.'-->'.$course_teacher;	
														//echo 'empty slot day time: '. $empty_day. $empty_time. '</br>existing slot day time: '. $new_day. $new_time;
														if(array_key_exists($key6, $empty_slots)){
															unset($empty_slots[$key6]);
														} 
														break;	
													}
														
												}
												
											}
											
										}
									}
									
								}
							}
							
						}
					}
				}
			
			}
		}
	}

//echo $duplicate_teachers;
if($duplicate_teachers == 0){
	break;
}

}

?>
<h3><?php _e('Complete Time Table (Class & Semester Wise):', 'codott');?></h3>
<table class="widefat">
    <thead>
	    <tr>
	        <th><strong><?php _e('Class', 'codott');?></strong></th>
	        <th><strong><?php _e('Day', 'codott');?></strong></th>
	        <?php 
	        foreach ($time_slots as $key => $value) {
	        ?>
	        <th><strong><?php echo esc_html($value);?></strong></th>
	        <?php
	        }
	        ?>
	    </tr>
	</thead>
	<tbody>
		<?php 
			$check_repeating_classes = array();
			$duplicate_rooms = 0;
			$duplicate_classes = 0;
			$check_repeating_rooms = array();
			if(!empty($classes)){
				foreach ($classes as $class_key => $class_value):
					$class_title_semester = $class_value;
					foreach ($day_slots as $key7 => $value7) {
				?>
						<tr>
							<td><?php echo esc_html($class_title_semester);?></td>
							<td><?php echo strtoupper($value7);?></td>
							<?php
								foreach ($time_slots as $key8 => $value8) {
									?>
									<td>
									<?php
									if(array_key_exists($class_title_semester, $all_class_slots)){
										foreach ($all_class_slots[$class_title_semester] as $key3 => $value3) {
											
											$course_to_output = explode('-->', $value3);
											$check_day = $course_to_output[0];
											$check_time = $course_to_output[1];
											$check_room = $course_to_output[2];
											if (array_key_exists(3, $course_to_output) && array_key_exists(4, $course_to_output) && array_key_exists(5, $course_to_output)){
												$check_class = $course_to_output[3];
												//$check_sem = $course_to_output[4];
												$check_course_title = $course_to_output[4];
												$course_teacher = $course_to_output[5];
												if($check_day == $value7 && $check_time == $value8 && $check_class == $class_title_semester){
													$string9 = $check_class.$check_day.$check_time;
													if(in_array($string9, $check_repeating_classes)){
														$duplicate_classes +=1;
														
													}else{
														$check_repeating_classes[] = $string9;
													}
													$string10 = $course_to_output[2].$check_day.$check_time;
													if(in_array($string10, $check_repeating_rooms)){
														$duplicate_rooms += 1;
													}else{
														$check_repeating_rooms[] = $string10;
													}
													echo esc_html($check_course_title . ' Room: ' . $check_room . ' '. $course_teacher) .'</br>';
													//echo $duplicate_classes;
												}
											}
											
										}
									}else{
										//echo 'no course defined for this class';
									}
									?>
									</td>
									<?php
								}
							?>
							
						</tr>
				<?php
					}
				endforeach;
			}

			if($duplicate_classes > 0){
			?>
			<div class="notice notice-error"><?php echo esc_html($duplicate_classes);?>
			 <?php printf(__('courses are overlapping at same time and day. So in order to get correct time table,
			  try to increase available slots by %s by increasing
			   either day slots, time slots or room slots.', 'codott'), esc_html($duplicate_classes));?></div>
			<?php
			}
		?>
		<tr>
			<td colspan="8">
			Duplicate Classes at same time and day: <?php echo esc_html($duplicate_classes);?>
			</br>
			Duplicate Rooms for same class at same day and same time.<?php echo esc_html($duplicate_rooms);?>
			</br>Overlapping of teacher day & time slots = <?php echo esc_html($duplicate_teachers);?>
			</td>
		</tr>
	</tbody>
</table>


<h2><?php _e('Another Version: (Compressed)', 'codott');?></h2>
<table class="widefat">
    <thead>
	    <tr>
	        <th><strong><?php _e('Day', 'codott');?></strong></th>
	        <?php 
	        foreach ($time_slots as $key => $value) {
	        ?>
	        <th><strong><?php echo esc_html($value);?></strong></th>
	        <?php
	        }
	        ?>
	    </tr>
	</thead>
	<tbody>
		<?php 
			
			foreach ($day_slots as $key7 => $value7) {
		?>
				<tr>
					<td><?php echo strtoupper($value7);?></td>
					<?php
						foreach ($time_slots as $key8 => $value8) {
							?>
							<td>
							<?php
							foreach ($classes_sem as $key5 => $value5):
								$class_title_semester = $value5;
								if(array_key_exists($class_title_semester, $all_class_slots)){
									foreach ($all_class_slots[$class_title_semester] as $key => $value) {
										
										$course_to_output = explode('-->', $value);
										$check_day = $course_to_output[0];
										$check_time = $course_to_output[1];
										if (array_key_exists(3, $course_to_output) && array_key_exists(4, $course_to_output) && array_key_exists(5, $course_to_output)){
											$check_class = $course_to_output[3];
											//$check_sem = $course_to_output[4];
											$check_course_title = $course_to_output[4];
											$course_teacher = $course_to_output[5];
											if($check_day == $value7 && $check_time == $value8){
												echo $check_class.': '. $check_course_title . ' Room: <strong style="font-size: 22px;">' . $course_to_output[2] . '</strong> '. $course_teacher . '</br>';
											}
										}
									}
								}
							endforeach;
							?>
							</td>
							<?php
						}
					?>
					
				</tr>
		<?php
			}
		?>
	</tbody>
</table>


<h2><?php _e('Empty Slots:', 'codott');?></h2>
<table class="widefat">
    <thead>
	    <tr>
	        <th><strong><?php _e('Day', 'codott');?></strong></th>
	        <?php 
	        foreach ($time_slots as $key => $value) {
	        ?>
	        <th><strong><?php echo esc_html($value);?></strong></th>
	        <?php
	        }
	        ?>
	    </tr>
	</thead>
	<tbody>
		<?php 
			foreach ($day_slots as $key7 => $value7) {
		?>
				<tr>
					<td><?php echo strtoupper($value7);?></td>
					<?php
						foreach ($time_slots as $key8 => $value8) {
							?>
							<td>
							<?php
							foreach ($empty_slots as $key => $value) {
								
								$course_to_output = explode('-->', $value);
								$check_day = $course_to_output[0];
								$check_time = $course_to_output[1];
								if (array_key_exists(3, $course_to_output) && array_key_exists(4, $course_to_output)){
									
								}else{
									if($check_day == $value7 && $check_time == $value8){
										echo esc_html(' Room: ' . $course_to_output[2]) . '</br>';
									}
								}
							}
							?>
							</td>
							<?php
						}
					?>
					
				</tr>
		<?php
			}
		?>
	</tbody>
</table>
<?php
function codott_collapse($path, $collapse, &$result)
{
  foreach($collapse AS $key => $value)
  {
    if(is_array($value))
    {
      codott_collapse($path . $key . "/", $value, $result);
      continue;
    }
    $result[] = $path . $value;
  }
}

$result = array();
$toCollapse = $all_class_slots;
codott_collapse("", $toCollapse, $result);

if(isset($codott_time_tables) && $codott_time_tables->post_type == 'codott_time_tables'){
	$array_string_class_slots = implode("**>",$result);
	$array_string_empty = implode("**>", $empty_slots);
	$array_string_classes_sem = implode("**>", $classes_sem);
?>
    <input name='codott_time_tables_cust_classes_sem' size='40' type='hidden' value='<?php echo esc_attr($array_string_classes_sem);?>' />
    <input name='codott_time_tables_cust_classes_courses_assign' size='40' type='hidden' value='<?php echo esc_attr($array_string_class_slots);?>' />
    <input name='codott_time_tables_cust_empty_slots' size='40' type='hidden' value='<?php echo esc_attr($array_string_empty);?>' />
<?php
}

codott_end_table_script:
?>