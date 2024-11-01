<?php 
$time_slots = explode(",", $time_table_time_slots2);
$day_slots = explode(",", $time_table_day_slots2);
$room_slots = explode(",", $time_table_room_slots2);
$classes = explode(',', $time_table_classes2);
$classes_courses = explode(',', $time_table_classes_courses2);


?>
<style>
.widefat.codott_table td, .widefat.codott_table th {
    border: 1px solid;
}
</style>

<?php

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
?>

<h2><?php _e('Class Time Table', 'codott');?></h2>
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
												if($check_class == $current_class){
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
