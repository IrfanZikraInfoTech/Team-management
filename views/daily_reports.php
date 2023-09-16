<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); 

function convertSecondsToRoundedTime($seconds)
{
    $hours = floor($seconds / 3600);
    $minutes = round(($seconds % 3600) / 60);

    if ($hours > 0) {
        return "{$hours}h {$minutes}m";
    } else {
        return "{$minutes}m";
    }
}

function formatShift($shiftNumer)
{
    if($shiftNumer == "1")
        return "1st Shift";
    else if ($shiftNumer == "2")
        return "2nd Shift";
    else
        return "All Day";
}


?>

<style>

.no-scroll::-webkit-scrollbar {
  display: none;
}

</style>




<div id="wrapper" class="wrapper">

<div class="container mx-auto px-4 py-6">
    <div class="flex flex-row justify-between mb-6">
        <h1 class="text-3xl font-semibold">Daily Reports</h1>
        <div class="max-w-sm flex flex-row gap-2">
            <input type="date" id="date-input" class="block appearance-none w-full bg-white  border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline" value="<?= date("Y") . '-' .$thisMonth.'-'.$thisDay?>">
            <button onclick="changeReport();" class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Search</button>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6">
        <!-- Total Loggable Hours -->
        <div class="bg-gradient-to-br from-red-600 to-orange-600 shadow rounded p-4 text-white">
            <h2 class="text-xl font-semibold mb-2">Total Loggable Hours</h2>
            <p class="text-2xl"><?= convertSecondsToRoundedTime($report_data['total_loggable_hours']) ?></p>
        </div>

        <!-- Actual Total Logged in Time -->
        <div class="bg-gradient-to-br from-pink-600 to-purple-600 shadow rounded p-4 text-white">
            <h2 class="text-xl font-semibold mb-2">Actual Logged in Time</h2>
            <p class="text-2xl"><?= convertSecondsToRoundedTime($report_data['actual_total_logged_in_time']) ?> </p>
        </div>

        <!-- Total Present Staff -->
        <div class="bg-gradient-to-br from-blue-600 to-teal-600 shadow rounded p-4 text-white">
            <h2 class="text-xl font-semibold mb-2">Total Present Staff :: <?= $report_data['total_present_staff'] ?></h2>
            <div class="overflow-x-auto no-scroll">
            <div class="flex flex-row gap-2 w-max">
                <?php if (!empty($report_data['present_staff_list'])): ?>
                    <?php foreach ($report_data['present_staff_list'] as $staff): ?>
                        <div class="staff-div" title="<?= $staff['firstname'] ?>" data-toggle="tooltip" data-placement="top" data-staff-id="<?= $staff['staff_id'] ?>">
                            <?= staff_profile_image($staff['staff_id'], ['border-2 border-solid object-cover w-12 h-12 staff-profile-image-thumb'], 'thumb'); ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No staff member found</p>
                <?php endif; ?>
            </div>
            </div>

        </div>

        <!-- Total Absentees -->
        <div class="bg-gradient-to-br from-green-500 to-blue-600 shadow rounded p-4 text-white">
            <h2 class="text-xl font-semibold mb-2">Total Absentees :: <?= count($report_data['absentees']); ?></h2>
            <div class="overflow-x-auto no-scroll">
                <div class="flex flex-row gap-2 w-max">
                    <?php if (!empty($report_data['absentees'])): ?>
                        <?php foreach ($report_data['absentees'] as $absentee): ?>
                            <div class="staff-div" title="<?= $absentee['firstname'] ?>" data-toggle="tooltip" data-placement="top" data-staff-id="<?= $absentee['staffid'] ?>">
                                <?= staff_profile_image($absentee['staffid'], ['border-2 border-solid object-cover w-12 h-12 staff-profile-image-thumb'], 'thumb'); ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No absentees</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        


        <!-- On Timers -->
        <div class="bg-gradient-to-br from-yellow-500 to-orange-500 shadow rounded p-4 text-white">

            <h2 class="text-xl font-semibold mb-2">On Timers :: <?= count($report_data['on_timers']); ?></h2>
            <div class="overflow-x-auto no-scroll">
                <div class="flex flex-wrap gap-2 w-max">

                <?php if (!empty($report_data['on_timers'])): ?>
                    <?php foreach ($report_data['on_timers'] as $comer) : ?>
                        <div class="hoverDiv" data-staffid="<?= $comer->staffid ?>" title="<?= $comer->firstname ?><?php foreach ($comer->late_status['shifts'] as $shift): ?>Shift <?= $shift['shift'] ?>: <?= is_numeric($shift['difference']) ? convertSecondsToRoundedTime($shift['difference']) : $shift['difference']; ?>&#13;&#10;<?php endforeach; ?>" data-toggle="tooltip" data-placement="top">
                            <?= staff_profile_image($comer->staffid, ['border-2 border-solid object-cover w-12 h-12 staff-profile-image-thumb'], 'thumb'); ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No on-timers</p>
                <?php endif; ?>


                </div>
            </div>
        </div>

        <!-- Late Joiners -->
        <div class="bg-gradient-to-br from-orange-600 to-red-500 shadow rounded p-4 text-white">
            <h2 class="text-xl font-semibold mb-2">Late Joiners :: <?= count($report_data['late_joiners']); ?></h2>

            <div class="overflow-x-auto no-scroll">
                <div class="flex flex-row gap-2 w-max">

                <?php if (!empty($report_data['late_joiners'])): ?>
                    <?php foreach ($report_data['late_joiners'] as $late_joiner) : ?>
                        <div class="hoverDiv" data-staffid="<?= $late_joiner->staffid ?>" title="<?= $late_joiner->firstname; ?>&#13;&#10;<?php foreach ($late_joiner->late_status['shifts'] as $shift): ?>Shift <?= $shift['shift'] ?>: <?= is_numeric($shift['difference']) ? convertSecondsToRoundedTime($shift['difference']) : $shift['difference']; ?>&#13;&#10;<?php endforeach; ?>" data-toggle="tooltip" data-placement="top">
                            <?= staff_profile_image($late_joiner->staffid, ['border-2 border-solid object-cover w-12 h-12 staff-profile-image-thumb'], 'thumb'); ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No late comers</p>
                <?php endif; ?>

                </div>
            </div>
        </div>



        <!-- On Leave -->
        <div class="bg-gradient-to-br from-indigo-600 to-purple-500 shadow rounded p-4 text-white">
            <h2 class="text-xl font-semibold mb-2">On Leave</h2>
            <div class="flex flex-wrap gap-2">
            <?php if (!empty($report_data['staff_on_leave'])): ?>
                <?php foreach ($report_data['staff_on_leave'] as $comer) :;?>
                    
                    <div title="<?= $comer['firstname'] ?> | <?= formatShift($comer['shift']) ?>" data-toggle="tooltip" data-placement="top">
                        <?= staff_profile_image($comer['staff_id'], ['border-2 border-solid object-cover w-12 h-12 staff-profile-image-thumb'], 'thumb'); ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No staff on leave</p>
            <?php endif; ?>

            </div>
        </div>

        <!-- Task Completion Rate -->
        <div class="bg-gradient-to-br from-teal-600 to-green-500 shadow rounded p-4 text-white">
            <h2 class="text-xl font-semibold mb-2">Task Rates</h2>
            <div class="text-2xl">

                <?= $report_data['total_completed_tasks'] ?> / <?= $report_data['total_all_tasks'] ?> (<?= $report_data['total_tasks_rate'] ?>%)

            </div>
        </div>

        

        <!-- Most Clocked In Staff Member -->
        <div class="bg-gradient-to-br from-amber-500 to-yellow-500 shadow rounded p-4 text-white">

            <h2 class="text-xl font-semibold mb-2">Most Clocked In Staff Member</h2>

            <?php if (!empty($report_data['most_clocked_in_staff_member'])): ?>

                <div class="text-2xl flex align-center justify-between">
                    <div class="my-auto"><?= $report_data['most_clocked_in_staff_member']['firstname'] ?></div>
                    <?= staff_profile_image($report_data['most_clocked_in_staff_member']['staffid'], ['border-2 border-solid object-cover w-12 h-full staff-profile-image-thumb'], 'thumb'); ?>
                </div>

            <?php else: ?>
                <p>No staff member found</p>
            <?php endif; ?>

        </div>

        <!-- Most Efficient Staff Member -->
        <div class="bg-gradient-to-br from-pink-500 to-indigo-500 shadow rounded p-4 text-white">
            <h2 class="text-xl font-semibold mb-2">Most Efficient Staff Member</h2>
            <?php if (!empty($report_data['most_eff_staff_member']) && !empty($report_data['most_eff_staff_member']->firstname) && !empty($report_data['most_eff_staff_member']->staffid)): ?>

            <div class="text-2xl flex align-center justify-between">
                <div class="my-auto"><?= $report_data['most_eff_staff_member']->firstname ?></div>
                <?= staff_profile_image($report_data['most_eff_staff_member']->staffid, ['border-2 border-solid object-cover w-12 h-full staff-profile-image-thumb'], 'thumb'); ?>
            </div>

            <?php else: ?>
            <p>No staff member found</p>
            <?php endif; ?>
        </div>
    </div>


        <div class="w-full p-5 my-5 bg-white shadow rounded p-4 col-span-2">
            <h2 class="card-title ms-1 text-uppercase text-center mb-4" style="font-weight: bold; color: #343a40; letter-spacing: 1.5px;">Peak Hour</h2>
            <div class="d-flex justify-content-center">
                <canvas id="peakHoursChart" style="width: 100%; height: 400px;"></canvas>
            </div>
        </div>


        <!-- All Staff Members -->
        <div class="bg-white shadow rounded p-4 col-span-2">
            <h2 class="text-xl font-semibold mb-4">Staff Members</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-sm font-medium text-gray-700">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Shift Timings</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Times Clocked in</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                 Total Shift Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total Time Clocked in</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Task Rate</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200 text-sm text-gray-600">
                    
                    <?php foreach ($report_data['all_staff'] as $staff): 
                        ?>
                        <tr class="border-solid border-b border-gray-200">
                            <td class="border px-4 py-2 flex flex-row gap-2 items-center">
                                <?= $staff['firstname'] . ' ' . $staff['lastname'] ?>
                                <?= staff_profile_image($staff['staffid'], ['h-8', 'w-8', 'rounded-full'], 'thumb') ?>
                            </td>
                            <td class="border px-4 py-2">
                                <?php 
                                $staff_id = $staff['staffid'];
                                if (isset($shift_timings_daywise[$staff_id])) {
                                    $time_strings = [];
                                    foreach ($shift_timings_daywise[$staff_id] as $timing) {
                                        $start_time = date("g:i A", strtotime($timing['start_time']));
                                        $end_time = date("g:i A", strtotime($timing['end_time']));
                                        $time_strings[] = $start_time . ' - ' . $end_time;
                                    }
                                    echo implode('<br>', $time_strings);
                                } else {
                                    echo 'N/A';
                                }
                                ?>
                            </td>
                            <td class="border px-4 py-2">
                                <?php
                                $staff_id = $staff['staffid'];
                                if (isset($report_data['clock_times'][$staff_id])) {
                                    echo $report_data['clock_times'][$staff_id];
                                } else {
                                    echo 'N/A';
                                }
                                ?>
                            </td>

                            <td class="border px-4 py-2">
                                <?= convertSecondsToRoundedTime($staff['total_shift_timings']) ?>
                            </td>
                            <td class="border px-4 py-2">
                                <?= convertSecondsToRoundedTime($staff['total_logged_in_time']) ?>
                            </td>
                            <td class="border px-4 py-2">
                                <?=  $staff['task_rate'] ?>
                            </td>
                            <td class="border px-4 py-2">
                                <a href="#" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded" data-staffname="<?= $staff['firstname'] ?>" data-staffid="<?= $staff['staffid'] ?>" data-toggle="modal" data-target="#dailySummaryModal"><i class="fa fa-list-alt"></i></a>
                                <a href="#" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded" onclick="openModal(<?= $staff['staffid'] ?>)"><i class="fa fa-chart-bar"></i></a>


                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>

                </table>
            </div>
        </div>
 

        <!-- All Tasks Worked On -->
        <div class="bg-white shadow rounded p-4 col-span-2">
            <h2 class="text-xl font-semibold mb-4">All Tasks Worked On</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-sm font-medium text-gray-700">
                            <th class="px-4 py-2 border-b-2 border-gray-200">Name</th>
                            <th class="px-4 py-2 border-b-2 border-gray-200">Worked by:</th>
                            <th class="px-4 py-2 border-b-2 border-gray-200">Status</th>
                            <th class="px-4 py-2 border-b-2 border-gray-200">Total worked time:</th>
                            <th class="px-4 py-2 border-b-2 border-gray-200">Priority</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-sm text-gray-600">
                        <?php

                        foreach ($report_data['all_tasks_worked_on'] as $task): 
    
                        ?>
                            <tr class="border-solid border-b border-gray-200">

                            <td class="px-4 py-2 align-top" style="max-width:400px;">
                                <?php
                                $projectNameSpan = '';
                                if ($task['project_name'] !== null) {
                                    $projectNameSpan = '<a target="_blank" href="' . admin_url() . 'projects/view/' . $task['rel_id'] . '" style="font-size:12px;">' . $task['project_name'] . '</a>';
                                }
                                echo '<div class="flex flex-col"><a target="_blank" href="' . admin_url() . 'tasks/view/' . $task['id'] . '">' . $task['task_name'] . '</a>' . $projectNameSpan . '</div>';
                                ?>
                            </td>

                                <td class="px-4 py-2 flex flex-row gap-2">
                                <?php foreach ($task['staff'] as $staff): ?>
                                    <?= staff_profile_image($staff['staff_id'], ['w-10 h-full staff-profile-image-thumb'], 'thumb') ?>
                                <?php endforeach; ?>
                                </td>
                                <td class="px-4 py-2 align-top"><?= format_task_status($task['task_status']) ?></td>
                                <td class="px-4 py-2 align-top"><?= convertSecondsToRoundedTime($task['total_worked_time']) ?></td>
                                <td class="px-4 py-2 align-top"><?= task_priority($task['priority']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>


        <!-- Day Summary -->
        <div class="bg-white shadow rounded p-4 col-span-2">
            <h2 class="text-xl font-semibold mb-2">Day Summary</h2>
            <div id="todaySummary"><?=htmlspecialchars_decode($day_summary)?></div>
        </div>
        
        <?php if (has_permission('team_management', '', 'admin')) : ?>
        <div class="bg-white shadow rounded p-4 col-span-2">
            
            <!-- Day summary editor (hidden by default) -->
            <div id="day-summary-editor">
                <textarea id="summary-editor" name="summary"><?=htmlspecialchars($day_summary)?></textarea>
                <div class="flex flex-row gap-2">
                    <button id="generate-summary" class="font-semibold my-2 px-4 py-2 bg-gray-200 rounded" type="button">Generate</button>
                    <button id="save-summary-btn" class="font-semibold my-2 px-4 py-2 bg-gray-200 rounded" type="button">Save</button>
                </div>
            </div>

        </div>
        <?php  endif; ?>
    </div>
</div>


</div>


<!-- stats modal  -->


<div class="modal fade" id="statsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="stats_daily_title">Stats Per Day: None selected!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <!-- Stats cards -->
                    <div class="grid grid-cols-3 gap-6 mb-10">
                        <div class="bg-blue-100 rounded-lg p-4 shadow">
                        <h3 class="text-lg font-semibold mb-2">Total Clocked In Time</h3>
                        <p class="text-xl font-bold" id="total_clock_in_time_day"><!-- Total clocked in time value --></p>
                        </div>
                        <div class="bg-green-100 rounded-lg p-4 shadow">
                        <h3 class="text-lg font-semibold mb-2">Total Shift Durations</h3>
                        <p class="text-xl font-bold" id="total_shift_duration"><!-- Total shift durations value --></p>
                        </div>
                        <div class="bg-yellow-100 rounded-lg p-4 shadow">
                        <h3 class="text-lg font-semibold mb-2">Total Time on Tasks</h3>
                        <p class="text-xl font-bold" id="total_task_time"><!-- Total time on tasks value --></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-6 mb-10">
                        <div class="bg-pink-100 rounded-lg p-4 shadow">
                        <h3 class="text-lg font-semibold mb-2">Total:</h3>
                        <p class="text-xl font-bold" id="total_no_tasks_day"><!-- Total clocked in time value --></p>
                        </div>
                        <div class="bg-cyan-100 rounded-lg p-4 shadow">
                        <h3 class="text-lg font-semibold mb-2">Completed:</h3>
                        <p class="text-xl font-bold" id="total_completed_tasks_day"><!-- Total shift durations value --></p>
                        </div>
                        <div class="bg-orange-100 rounded-lg p-4 shadow">
                        <h3 class="text-lg font-semibold mb-2">Tasks Rate:</h3>
                        <p class="text-xl font-bold" id="tasks_rate_day"><!-- Total time on tasks value --></p>
                        </div>
                    </div>

                    <!-- Additional stats -->

                    <div class="mb-10">
                        <h3 class="text-lg font-semibold mb-2">All Tasks</h3>
                        <!-- Task timer activity table -->
                        <table class="min-w-full divide-y divide-gray-200 shadow-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Completed Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Time Taken</th>
                                
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">No. Days Late</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="tbl_all_tasks">
                            </tbody>
                        </table>
                    </div>

                    <div class="mb-10">
                        <h3 class="text-lg font-semibold mb-2">Task Timer Activity</h3>
                        <!-- Task timer activity table -->
                        <table class="min-w-full divide-y divide-gray-200 shadow-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Task</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Start Time</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">End Time</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Duration</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="tbl_tasks_activity">
                            </tbody>
                        </table>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mb-6">

                        <div>

                        <h3 class="text-lg font-semibold mb-2">AFK Time</h3>
                        <p class="text-xl font-bold"><!-- Total AFK time value --></p>
                        <!-- AFK time table -->
                        
                        <table class="min-w-full divide-y divide-gray-200 shadow-sm mb-6">
                            <thead class="bg-gray-50">
                                <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Start Time</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">End Time</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Duration</th>
                                </tr>
                            </thead>
                            <tbody id="afk_time_table" class="bg-white divide-y divide-gray-200">
                            </tbody>
                        </table>

                        </div>
                        
                        <div>

                        <h3 class="text-lg font-semibold mb-2">Offline Time</h3>
                        <p class="text-xl font-bold"><!-- Total offline time value --></p>
                        <!-- Offline time table -->
                        <!-- Add offline time table here -->
                        
                        <table class="min-w-full divide-y divide-gray-200 shadow-sm mb-6">
                            <thead class="bg-gray-50">
                                <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Start Time</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">End Time</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Duration</th>
                                </tr>
                            </thead>
                            <tbody id="offline_time_table" class="bg-white divide-y divide-gray-200">
                                <!-- Add offline time entries here -->
                            </tbody>
                        </table>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Leave Status</h3>
                        <p class="text-xl font-bold" id="on_leave"><!-- Leave status value --></p>
                    </div>
                    <div id="visualization" class="my-5"></div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

<script>
  const summaries = <?php echo json_encode($summaries); ?>;
</script>

<!-- Daily Summary Modal -->
<div class="modal fade" id="dailySummaryModal" tabindex="-1" role="dialog" aria-labelledby="dailySummaryModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="dailySummaryModalLabel">Daily Summary</h5>

      </div>
      <div class="modal-body" id="dailySummaryModalBody">
        <!-- Summary content will be updated here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<?php init_tail(); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/vis/4.21.0/vis.min.js"></script>

<script>
    
$(document).ready(function(){
    $('.staff-div').on('click', function(){
        var staffId = $(this).data('staff-id');  // Retrieve the staff_id from clicked element
        $('#modalContent').html("Staff ID: " + staffId);  // Populate the modal content
        $('#statsModal').data('staff-id', staffId);  // Set the staffId as a data attribute on the modal
        $('#statsModal').modal('show');  // Show the modal
    });
});

// Event listener for shown.bs.modal
$('#statsModal').on('shown.bs.modal', function () {
    var staffId = $(this).data('staff-id');  // Retrieve staffId from modal's data attribute
    fetchDailyInfo(staffId);  // Call fetchDailyInfo function
});

function openModal(staffId) {
    Swal.fire({
        title: 'Processing...',
        text: 'Please wait a moment.',
        icon: 'info',
        showConfirmButton: false,
        allowOutsideClick: false,
        allowEscapeKey: false,
        onOpen: () => {
            Swal.showLoading()
        }
    }).then((result) => {
        if (result.dismiss === Swal.DismissReason.timer) {
            console.log('Swal closed by timer');
        }
    })

    setTimeout(function() {
        // Close the Swal after 2 seconds
        Swal.close();

        // Populate the modal content and open the modal
        $('#modalContent').html("Staff ID: " + staffId);  
        $('#statsModal').data('staff-id', staffId);  
        $('#statsModal').modal('show');  
    }, 2000);
}


function fetchDailyInfo(staff_id) {
const currentDate = new Date();
const month = <?= $thisMonth; ?>;
const day = <?= $thisDay; ?>;
const year = currentDate.getFullYear();

const monthStr = month < 10 ? `0${month}` : `${month}`;
const dayStr = day < 10 ? `0${day}` : `${day}`;

const startDate = new Date(`${year}-${monthStr}-${dayStr}T00:00:00`);
const endDate = new Date(`${year}-${monthStr}-${dayStr}T23:59:59`);

// Setting the focus
// timeline.setWindow(startDate, endDate);


$.ajax({
    url: admin_url + 'team_management/fetch_daily_info/',
    type: 'POST',
    data: {
        staff_id: staff_id,
        day: day,
        month: month,
        year: year,
        [csrfData.token_name]: csrfData.hash,
    },
    dataType: 'json',
    success: function (data) {
        console.log(data);

        $("#stats_daily_title").html(" :: " + day + "/" + month + "/" + <?= date('Y') ?>);

        $('#total_clock_in_time_day').html(data.total_clocked_in_time);
        $('#total_shift_duration').html(data.total_shift_duration);
        $('#total_task_time').html(data.total_task_time);

        $('#total_no_tasks_day').html(data.total_no_tasks + " tasks");
        $('#total_completed_tasks_day').html(data.total_completed_tasks + " tasks");
        $('#tasks_rate_day').html(data.tasks_rate + "%");


        $('#on_leave').html(data.on_leave ? 'Yes' : 'No');

        const afk_entries = data.afk_and_offline.filter(entry => entry.status === 'AFK');
        const offline_entries = data.afk_and_offline.filter(entry => entry.status === 'Offline');

        const monthDigit = month.toLocaleString('en-US', {
            minimumIntegerDigits: 2,
            useGrouping: false
        });

        const afk_rows = generateStatusRows(afk_entries);
        const offline_rows = generateStatusRows(offline_entries);
        const tasks_rows = generateTasksRows(data.task_timers);
        const all_tasks_rows = generateAllTasksRows(data.all_tasks, year+"-"+monthDigit+"-"+day);

        (afk_rows != "") ? $('#afk_time_table').html(afk_rows) : $('#afk_time_table').html("<tr><td colspan='3' class='px-4 py-2'>No Data</td></tr>");
        
        (offline_rows != "") ? $('#offline_time_table').html(offline_rows) : $('#offline_time_table').html("<tr><td colspan='3' class='px-4 py-2'>No Data</td></tr>");

        (tasks_rows != "") ? $('#tbl_tasks_activity').html(tasks_rows) : $('#tbl_tasks_activity').html("<tr><td colspan='4' class='px-4 py-2'>No Data</td></tr>");

        (all_tasks_rows != "") ? $('#tbl_all_tasks').html(all_tasks_rows) : $('#tbl_all_tasks').html("<tr><td colspan='4' class='px-4 py-2'>No Data</td></tr>");

        
        var targetDiv = $('#stats-per-day'); // Replace 'your-target-div-id' with the actual div id
        $('html, body').animate({
            scrollTop: targetDiv.offset().top
        }, 1000);

    },
    error: function (jqXHR, textStatus, errorThrown) {
        console.error('Error fetching daily stats:', textStatus, errorThrown);
    }
});
}


function generateStatusRows(entries) {
    let rows = '';
    entries.forEach(entry => {
        rows += `
        <tr>
            <td class="px-4 py-2">${entry.start_time}</td>
            <td class="px-4 py-2">${entry.end_time}</td>
            <td class="px-4 py-2">${(entry.duration)}</td>
        </tr>`;
    });
    return rows;
}

function generateTasksRows(entries) {
    let rows = '';
    entries.forEach(entry => {
 

        if(entry.project_id != null){
            rows += `
            <tr>
                <td class="px-4 py-2 flex flex-col">
                    <a target="_blank" onclick="init_task_modal(${entry.task_id}); return false" href="#" class="text-sm">${entry.task_name}</a>
                    <a target="_blank" href="<?= admin_url(); ?>projects/view/${entry.project_id}" class="text-xs">${entry.project_name}</a>
                </td>
                <td class="px-4 py-2">${entry.start_time}</td>
                <td class="px-4 py-2">${entry.end_time}</td>
                <td class="px-4 py-2">${(entry.duration)}</td>
            </tr>
            `;
        }else{
            rows += `
            <tr>
                <td class="px-4 py-2 flex flex-col">
                    <a target="_blank" href="#" onclick="init_task_modal(${entry.task_id}); return false" class="text-sm">${entry.task_name}</a>
                </td>
                <td class="px-4 py-2">${entry.start_time}</td>
                <td class="px-4 py-2">${entry.end_time}</td>
                <td class="px-4 py-2">${(entry.duration)}</td>
            </tr>
            `;
        }
        
    });
    return rows;
}

function generateAllTasksRows(entries, date) {
    let rows = '';

    let today = new Date();
    today = new Date(today.getFullYear(), today.getMonth(), today.getDate());


    entries.forEach(entry => {

        let taskBG = "";

        let assignedDate = new Date(entry.Assigned_Date);
        assignedDate = new Date(assignedDate.getFullYear(), assignedDate.getMonth(), assignedDate.getDate());

        let dueDate = new Date(entry.duedate);
        //dueDate = new Date(dueDate.getFullYear(), dueDate.getMonth(), dueDate.getDate());

        if(entry.Completed_Date){
            let completedDate = new Date(entry.Completed_Date);
            completedDate = new Date(completedDate.getFullYear(), completedDate.getMonth(), completedDate.getDate());
            console.log("dueDate",dueDate.getTime());
            console.log("completedDate",completedDate.getTime());
            if(dueDate.getTime() >= completedDate.getTime()){
                taskBG = "bg-emerald-100/70";
            } else {
                taskBG = "bg-red-100/70";
            }
        } else {
            if(dueDate.getTime() >= today.getTime()){
                taskBG = "bg-gray-100/70";
            } else {
                taskBG = "bg-red-100/70";
            }
        }
        

        if(entry.project_id != null){
            rows += `
            <tr class="transition-all hover:`+taskBG+`">
                <td class="px-4 py-2">${(entry.task_id)}</td>
                <td class="px-4 py-2 flex flex-col">
                    <a target="_blank" href="#" onclick="init_task_modal(${entry.task_id}); return false" class="text-sm">${entry.task_name}</a>
                    <a target="_blank" href="<?= admin_url(); ?>projects/view/${entry.project_id}" class="text-xs">${entry.project_name}</a>
                </td>
                <td class="px-4 py-2">${(entry.Assigned_Date)}</td>
                <td class="px-4 py-2">${(entry.duedate)}</td>
                <td class="px-4 py-2">${(entry.Completed_Date)}</td>
                <td class="px-4 py-2">${(entry.Total_Time_Taken)}</td>
                <td class="px-4 py-2">${(entry.Days_Offset)}</td>
            </tr>
            `;
        }else{
            rows += `
            <tr class="transition-all hover:`+hoverColor+`">
                <td class="px-4 py-2">${(entry.task_id)}</td>
                <td class="px-4 py-2 flex flex-col">
                    <a target="_blank" href="#" onclick="init_task_modal(${entry.task_id}); return false" class="text-sm">${entry.task_name}</a>
                </td>
                <td class="px-4 py-2">${(entry.Assigned_Date)}</td>
                <td class="px-4 py-2">${(entry.duedate)}</td>
                <td class="px-4 py-2">${(entry.Completed_Date)}</td>
                <td class="px-4 py-2">${(entry.Total_Time_Taken)}</td>
                <td class="px-4 py-2">${(entry.Days_Offset)}</td>
            </tr>
            `;
        }
        
    });
    return rows;
}


</script>

<script>


    $('#dailySummaryModal').on('show.bs.modal', function (event) {
      const button = $(event.relatedTarget);
      const staffId = button.data('staffid');
      const staffName = button.data('staffname');

      let summary = 'No summary available';

      for (const staffSummary of Object.values(summaries)) {
          if (staffSummary.staffid == staffId) {
          summary = staffSummary.summary;

          break;
          }
      }

      $('#dailySummaryModalBody').html(summary);
      $('#dailySummaryModalLabel').html(staffName + "'s Summary");

    });

    $('#generate-summary').on('click', function () {
    alert_float("info", "Generating summary...");

    <?php
    
    $most_clock = ($report_data['most_clocked_in_staff_member']) ? ($report_data['most_clocked_in_staff_member']['firstname'] . ' ' . $report_data['most_clocked_in_staff_member']['lastname']) : 'None';
    $most_eff = ($report_data['most_eff_staff_member']) ? $report_data['most_eff_staff_member']->firstname . ' ' . $report_data['most_eff_staff_member']->lastname : 'None';

    $on_timers = $report_data['on_timers'];
    $on_timers_names = array_map(function($timer) { return $timer->firstname.' '.$timer->lastname; }, $on_timers);
    $on_timers_string = implode(', ', $on_timers_names);

    $late_timers = $report_data['late_joiners'];
    $late_joiners_names = array_map(function($joiner) { return $joiner->firstname.' '.$joiner->lastname; }, $late_timers);
    $late_joiners_string = implode(', ', $late_joiners_names);
    ?>

    $.ajax({
        url: admin_url + 'team_management/generate_daily_summary',
        method: 'POST',
        data: {
            date: '<?=$date?>',
            total_loggable_hours: '<?= convertSecondsToRoundedTime($report_data['total_loggable_hours']) ?>',
            actual_total_logged_in_time: '<?= convertSecondsToRoundedTime($report_data['actual_total_logged_in_time']) ?>',
            total_completed_tasks: '<?= $report_data['total_completed_tasks'] ?>',
            total_all_tasks: '<?= $report_data['total_all_tasks'] ?>',
            on_timers: '<?= $on_timers_string ?>',
            late_joiners: '<?= $late_joiners_string ?>',
            most_clocked_in_staff_member: '<?= $most_clock ?>',
            most_eff_staff_member: '<?= $most_eff ?>'
        },
        success: function (response) {
            alert_float("success", "Generated!");
            // Set the value of the active TinyMCE editor to the fetched summary
            tinymce.activeEditor.setContent(response);
        },
        error: function (xhr, status, error) {
            console.error('Error fetching summary:', error);
        },
    });

});

</script>

<script>
$(document).ready(function() {
    // Initialize Summernote
    tinymce.init({
        selector: '#summary-editor',
        // Add any additional TinyMCE options you may need
    });

        // Save day summary on button click
        $('#save-summary-btn').click(function() {
            var summary = tinyMCE.activeEditor.getContent();
            alert_float("info", "Mailing summary...");
            $.post("<?=admin_url('team_management/save_day_summary')?>", {date: "<?=$date?>", summary: summary}, function() {
                $('#todaySummary').html(summary);
                alert_float("success", "Success!");
            });
        });

        //const dateInput = document.getElementById("date-input");
        //const today = new Date();
        //
        //const month = ("0" + (today.getMonth() + 1)).slice(-2);
        //const day = ("0" + today.getDate()).slice(-2);
        //const formattedDate = `${today.getFullYear()}-${month}-${day}`;
        //
        //dateInput.value = formattedDate;

    });

    function changeReport() {
        var date = document.getElementById("date-input").value;

        const selectedDate = new Date(date);
        const selectedMonth = ("0" + (selectedDate.getMonth() + 1)).slice(-2);
        const selectedDay = ("0" + selectedDate.getDate()).slice(-2);

        window.location.href = "<?=admin_url('team_management/daily_reports')?>/" + selectedMonth + "/" + selectedDay;

    }
</script>
</body>
</html>