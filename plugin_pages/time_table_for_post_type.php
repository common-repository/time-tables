<?php 
$time_slots = explode(',', $time_table_time_slots2);
$day_slots = explode(',', $time_table_day_slots2);
$room_slots = explode(',', $time_table_room_slots2);
$classes = explode(',', $time_table_classes2);
$classes_courses = explode(',', $time_table_classes_courses2);

$double_classes_courses = array();
foreach ($classes_courses as $key => $value) {
	$double_classes_courses[] = $value;
	$double_classes_courses[] = $value;
}

$classes_courses = $double_classes_courses;

	$all_class_slots = array();
	$classes_courses_assign_string = explode("**>", $time_table_classes_courses_assign);
	foreach ($classes_courses_assign_string as $key5 => $value5) {
		$new_classes_courses_assign = explode('/', $value5);
		$class_semester = $new_classes_courses_assign[0];
		$class_course = $new_classes_courses_assign[1];
		$all_class_slots[$class_semester][] = $class_course;
	}

	$classes_sem = array();
	$classes_sem_string = explode("**>", $time_table_classes_sem);
	foreach ($classes_sem_string as $key6 => $value6) {
		$classes_sem[] = $value6;
	}

	$empty_slots = array();
	$empty_slots_string = explode("**>", $time_table_empty_slots);
	foreach ($empty_slots_string as $key7 => $value7) {
		$empty_slots[] = $value7;
	}
//}
?>
<h3><?php _e('Complete Time Table :', 'codott');?></h3>
<h3><?php _e('Max Courses for any class', 'codott');?> = 
	<?php 
		$largeArraySize = 0;
		foreach($all_class_slots as $array) {
		   if(count($array) > $largeArraySize) {
		     $largeArray = $array;
		     $max_class_courses = count($array);
		     $largeArraySize = $max_class_courses;
		   }
		}
		echo esc_html($max_class_courses);
	?>
</h3>
<div class="responsive-table">
<table class="widefat codott_table">
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
			if(!empty($classes_sem)){
				foreach ($classes_sem as $class_key => $class_value):
				 
					$class_title_semester = $class_value;
					foreach ($day_slots as $key7 => $value7) {
				?>
						<tr>
							<td><?php echo esc_html($class_title_semester);?></td>
							<td><?php echo strtoupper($value7);?></td>
							<?php
								foreach ($time_slots as $key8 => $value8) {
									?>
									<td class="codott-col-pad">
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
													?>
													<span class="codott-timetable-content" style="background-color: <?php echo esc_attr($time_table_filledslotcolor);?>; color: <?php echo esc_attr($time_table_emptyslotcolor);?>;">
													<?php echo esc_html($check_course_title . ' Room: ' . $check_room . ' '. $course_teacher) .'</br>';?>
													</span>
													<span class="codott-timetable-content-mob">
													<?php echo 'Day: '.$value7.'</br>Time: '.$value8.'</br>Class: '.$check_class.'</br>Course: '.esc_html($check_course_title) . '</br> Room: ' . esc_html($check_room) . ' </br>Teacher: '. esc_html($course_teacher) .'</br>';?>
													</span>
													<?php
												}
											}	
										}
										
									}else{

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
		<tr><td colspan="8">Duplicate Classes at same time and day: <?php echo esc_html($duplicate_classes);?></br>
			Duplicate Rooms for same class at same day and same time.<?php echo esc_html($duplicate_rooms);?></td></tr>
	</tbody>
</table>
</div>


<h2><?php _e('Another Version: (Compressed)', 'codott');?></h2>
<div class="responsive-table">
<table class="widefat codott_table">
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
				<tr class="codott-timetable-row">
					<td class="codott-timetable-col-day"><?php echo strtoupper($value7);?></td>
					<?php
						foreach ($time_slots as $key8 => $value8) {
							?>
							<td class="codott-timetable-col-course codott-col-pad">
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
											$check_course_title = $course_to_output[4];
											$course_teacher = $course_to_output[5];
											if($check_day == $value7 && $check_time == $value8){
												?>
												<span class="codott-timetable-content" style="background-color: <?php echo esc_attr($time_table_filledslotcolor);?>; color: <?php echo esc_attr($time_table_emptyslotcolor);?>;">
												<?php echo esc_html($check_class .': '. $check_course_title) . ' Room: <strong style="font-size: 22px;">' . esc_html($course_to_output[2]) . '</strong> '. esc_html($course_teacher) . '</br>';?>
												</span>
												<span class="codott-timetable-content-mob">
												<?php echo 'Day: '.$value7.'</br>'.'Time: '.$value8.'</br>'.'Class: '. $check_class. '</br>' .'Course: '. $check_course_title. '</br>' . ' Room: ' . esc_html($course_to_output[2]) . '</br> Teacher: '. esc_html($course_teacher) . '</br>';?>
												</span>
												<?php
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
</div>


<h2><?php _e('Empty Slots:', 'codott');?></h2>
<div class="responsive-table">
<table class="widefat codott_table">
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
							<td class="codott-col-pad">
							<?php
							foreach ($empty_slots as $key => $value) {
								
								$course_to_output = explode('-->', $value);
								$check_day = $course_to_output[0];
								$check_time = $course_to_output[1];
								if (array_key_exists(3, $course_to_output) && array_key_exists(4, $course_to_output)){
									
								}else{
									if($check_day == $value7 && $check_time == $value8){
										?>
										<span class="codott-timetable-content" style="background-color: <?php echo esc_attr($time_table_filledslotcolor);?>; color: <?php echo esc_attr($time_table_emptyslotcolor);?>;">
										<?php echo esc_html(' Room: ' . $course_to_output[2]) . '</br>';?>
										</span>
										<span class="codott-timetable-content-mob">
										<?php echo 'Day: '.$value7.'</br>Time: '.$value8.'</br>'.esc_html(' Room: ' . $course_to_output[2]) . '</br>';?>
										</span>
										<?php
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
</div>