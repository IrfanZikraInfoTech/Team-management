<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); 
//function secondsToReadableTime($seconds) {
//    $hours = floor($seconds / 3600);
//    $minutes = floor(($seconds % 3600) / 60);
//
//    return "{$hours}h {$minutes}m";
//}
?>

<div id="wrapper" class="wrapper">
    <div class="content flex flex-col">

        <div class="flex flex-col gap-4 rounded">
        
            <div class="bg-white rounded-lg shadow p-6 mb-8">
                <div class="flex flex-row justify-between">
                    <h2 class="text-2xl font-semibold mb-4">Stats of <?= date("F", mktime(0, 0, 0, $month_this, 1)); ?> of <?= $staff_name_this ?></h2>

                    <div class="">
                        <select onchange="location = this.value;" class="block appearance-none w-full bg-white  border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                            <option value="#">Select Month</option>
                            <option value="<?= admin_url().'team_management/staff_stats/'.$staff_id_this;?>/1">January</option>
                            <option value="<?= admin_url().'team_management/staff_stats/'.$staff_id_this;?>/2">February</option>
                            <option value="<?= admin_url().'team_management/staff_stats/'.$staff_id_this;?>/3">March</option>
                            <option value="<?= admin_url().'team_management/staff_stats/'.$staff_id_this;?>/4">April</option>
                            <option value="<?= admin_url().'team_management/staff_stats/'.$staff_id_this;?>/5">May</option>
                            <option value="<?= admin_url().'team_management/staff_stats/'.$staff_id_this;?>/6">June</option>
                            <option value="<?= admin_url().'team_management/staff_stats/'.$staff_id_this;?>/7">July</option>
                            <option value="<?= admin_url().'team_management/staff_stats/'.$staff_id_this;?>/8">August</option>
                            <option value="<?= admin_url().'team_management/staff_stats/'.$staff_id_this;?>/9">September</option>
                            <option value="<?= admin_url().'team_management/staff_stats/'.$staff_id_this;?>/10">October</option>
                            <option value="<?= admin_url().'team_management/staff_stats/'.$staff_id_this;?>/11">November</option>
                            <option value="<?= admin_url().'team_management/staff_stats/'.$staff_id_this;?>/12">December</option>
                        </select>
                    </div>
                </div>

                


                <div class="flex flex-col space-y-4">
                    <!-- Summed up stats -->
                    <div class="grid grid-cols-3 gap-6 mb-6">
                        <div class="bg-blue-100 rounded-lg p-4 shadow">
                            <h3 class="text-lg font-semibold mb-2">Total Clocked In Time</h3>
                            <p class="text-xl font-bold"><?= secondsToReadableTime($monthly_total_clocked_time) ?></p>
                        </div>
                        <div class="bg-green-100 rounded-lg p-4 shadow">
                            <h3 class="text-lg font-semibold mb-2">Total Shift Durations</h3>
                            <p class="text-xl font-bold"><?= secondsToReadableTime($monthly_shift_duration) ?></p>
                        </div>
                        <div class="bg-yellow-100 rounded-lg p-4 shadow">
                            <h3 class="text-lg font-semibold mb-2">Punctuality Rate</h3>
                            <p class="text-xl font-bold"><?= $punctuality_rate; ?></p>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-6 mb-6">
                        <div class="bg-pink-100 rounded-lg p-4 shadow">
                            <h3 class="text-lg font-semibold mb-2">Total Days:</h3>
                            <p class="text-xl font-bold"><?= $days_data['total_days'] ?> Days</p>
                        </div>
                        <div class="bg-cyan-100 rounded-lg p-4 shadow">
                            <h3 class="text-lg font-semibold mb-2">Worked for:</h3>
                            <p class="text-xl font-bold"><?= $days_data['worked_days'] ?> Days</p>
                        </div>
                        <div class="bg-orange-100 rounded-lg p-4 shadow">
                            <h3 class="text-lg font-semibold mb-2">Absent Days</h3>
                            <div class="text-lg font-semibold flex xl:flex-row flex-col justify-between"><div>Paid: <?= $days_data['paid_leaves'] ?></div><div>Unpaid: <?= $days_data['unpaid_leaves'] ?></div><div>Ghosted: <?= $days_data['ghosted'] ?></div></div>
                            
                        </div>
                    </div>

                    <!-- Monthly table -->
                    <div class="overflow-auto">
                    <table class="min-w-full divide-y divide-gray-200 shadow-lg">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Day</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Shift Timings</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Times Clocked In</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Time Clocked In</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Shift Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Time on Tasks</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($monthly_stats as $stat): ?>
                                <tr class="hover:bg-gray-100 transition-all">
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500"><?= $stat['day_date'] ?></td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500"><?= $stat['shift_timings'] ?></td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500"><?= $stat['clock_times'] ?></td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500"><?= $stat['total_clock_in_time'] ?></td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500"><?= $stat['total_shift_duration'] ?></td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500"><?= $stat['total_task_time'] ?></td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 flex flex-row gap-2">
                                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded" onclick="fetchDailyInfo(<?= $stat['day'] ?>)"><i class="fa fa-chart-bar"></i></button>
                                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded" onclick="fetchSummary(<?= $stat['day'] ?>)"><i class="fa fa-list-alt"></i></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6 mb-8" id="stats-per-day">
                <div class="flex flex-col space-y-4">
                    
                    <!-- Stats per day section -->
                    <div class="bg-white p-6 rounded-lg">
                    <h2 class="text-2xl font-semibold mb-8">Stats Per Day <span id="stats_daily_title">:: none selected!</span></h2>

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
                    </div>

                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex flex-col space-y-4">
                    <div class="bg-white p-6 rounded-lg">
                        <h2 class="text-2xl font-semibold mb-8">Monthly Tasks Data</span></h2>

                        <!-- Stats cards -->
                        <div class="grid grid-cols-3 gap-6 mb-10">

                            <div class="bg-blue-100 rounded-lg p-4 shadow">
                                <h3 class="text-lg font-semibold mb-2">Total:</h3>
                                <p class="text-xl font-bold"><?= $all_months_tasks_data['total_no_tasks']?> tasks</p>
                            </div>

                            <div class="bg-green-100 rounded-lg p-4 shadow">
                                <h3 class="text-lg font-semibold mb-2">Completed on time:</h3>
                                <p class="text-xl font-bold"><?= $all_months_tasks_data['total_completed_tasks']?> tasks</p>
                            </div>

                            <div class="bg-yellow-100 rounded-lg p-4 shadow">
                                <h3 class="text-lg font-semibold mb-2">Tasks Rate On Time:</h3>
                                <p class="text-xl font-bold"><?= $all_months_tasks_data['tasks_rate']?>%</p>
                            </div>


                        </div>
                        
                        <div class="overflow-auto">
                        <table class="min-w-full divide-y divide-gray-200 shadow-lg">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Completed Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Time Taken</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Of. Days Late</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">

                            <?php foreach ($all_months_tasks as $task): ?>

                                <?php
                                if($task['Completed_Date']){
                                    if(strtotime($task['duedate']) >= strtotime($task['Completed_Date']))
                                    {
                                        $taskBG = 'bg-emerald-100/70';
                                    }else{
                                        $taskBG = 'bg-red-100/70';
                                    }
                                }else{
                                    if(strtotime($task['duedate']) >= strtotime(date("Y-m-d")))
                                    {
                                        $taskBG = 'bg-white';
                                    }else{
                                        $taskBG = 'bg-red-100/70';
                                    }
                                }
                                
                                ?>

                                <tr class="hover:bg-gray-100 transition-all <?= $taskBG?>">

                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500"><?= $task['task_id'] ?></td>
                                    

                                    <td class="px-4 py-2 flex flex-col">
                                        <a target="_blank" href="#" onclick="init_task_modal(<?= $task['task_id'] ?>); return false" class="text-sm"><?= $task["Title"] ?></a>
                                        
                                        <?php if($task['Project_Id']){ ?><a target="_blank" href="<?= admin_url(); ?>view/<?= $task['Project_Id'] ?>" class="text-xs"><?= $task["Project_Name"] ?></a><?php } ?>
                                    </td>

                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500"><?= $task['Assigned_Date'] ?></td>

                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500"><?= $task['duedate'] ?></td>

                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500"><?= $task['Completed_Date'] ?></td>

                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500"><?= $task['Total_Time_Taken'] ?></td>

                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500"><?= $task['Days_Offset'] ?></td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    </div>

                    </div>
                </div>
            </div>
                
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex flex-col space-y-4">
                    <div class="bg-white p-6 rounded-lg">
                        <h2 class="text-2xl font-semibold mb-8">Monthly Leave Data</span></h2>

                        <!-- Stats cards -->
                        <div class="grid grid-cols-3 gap-6 mb-10">

                            <div class="bg-blue-100 rounded-lg p-4 shadow">

                                <h3 class="text-xl font-bold mb-2">Paid Leaves:</h3>
                                <div class="text-lg font-semibold flex xl:flex-row flex-col justify-between"><div>Pending: <?= $mo_pen_paid_no ?></div><div>Approved: <?= $mo_app_paid_no ?></div><div>Disapproved: <?= $mo_dis_paid_no ?></div></div>

                            </div>
                            <div class="bg-green-100 rounded-lg p-4 shadow">
                                <h3 class="text-xl font-bold mb-2">Unpaid Leaves:</h3>
                                <div class="text-lg font-semibold flex xl:flex-row flex-col justify-between"><div>Pending: <?= $mo_pen_unpaid_no ?></div><div>Approved: <?= $mo_app_unpaid_no ?></div><div>Disapproved: <?= $mo_dis_unpaid_no ?></div></div>
                            </div>
                            <div class="bg-yellow-100 rounded-lg p-4 shadow">
                                <h3 class="text-xl font-bold mb-2">Gazetted Leaves:</h3>
                                <div class="text-lg font-semibold flex xl:flex-row flex-col justify-between"><div>Pending: <?= $mo_pen_gaz_no ?></div><div>Approved: <?= $mo_app_gaz_no ?></div><div>Disapproved: <?= $mo_dis_gaz_no ?></div></div>
                            </div>
                        </div>
                        
                        <div class="overflow-auto">
                        <table class="min-w-full divide-y divide-gray-200 shadow-lg">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reason</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted At</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($mo_all_applications as $stat): ?>
                                
                                <tr class="hover:bg-gray-100 transition-all">
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500"><?= $stat->id ?></td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500"><?= $stat->application_type ?></td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500"><?= $stat->status ?></td>
                                    <td class="text-center px-4 py-2 whitespace-nowrap text-sm text-gray-500"><?= $stat->start_date.'<br> to <br>'.$stat->end_date ?></td>
                                    <td class="max-w-[35%]  px-4 py-2 whitespace text-sm text-gray-500"><?= $stat->reason ?></td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500"><?= $stat->created_at ?></td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    </div>

                    </div>
                </div>
            </div>
            

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex flex-col space-y-4">
                    <div class="bg-white p-6 rounded-lg">
                        <h2 class="text-2xl font-semibold mb-8">Yearly Leave Data</span></h2>

                        <!-- Stats cards -->
                        <div class="grid grid-cols-3 gap-6 mb-10">

                            <div class="bg-blue-100 rounded-lg p-4 shadow">

                                <h3 class="text-xl font-bold mb-2">Paid Leaves:</h3>
                                <div class="text-lg font-semibold flex xl:flex-row flex-col justify-between"><div>Pending: <?= $pen_paid_no ?></div><div>Approved: <?= $app_paid_no ?></div><div>Disapproved: <?= $dis_paid_no ?></div></div>

                            </div>
                            <div class="bg-green-100 rounded-lg p-4 shadow">
                                <h3 class="text-xl font-bold mb-2">Unpaid Leaves:</h3>
                                <div class="text-lg font-semibold flex xl:flex-row flex-col justify-between"><div>Pending: <?= $pen_unpaid_no ?></div><div>Approved: <?= $app_unpaid_no ?></div><div>Disapproved: <?= $dis_unpaid_no ?></div></div>
                            </div>
                            <div class="bg-yellow-100 rounded-lg p-4 shadow">
                                <h3 class="text-xl font-bold mb-2">Gazetted Leaves:</h3>
                                <div class="text-lg font-semibold flex xl:flex-row flex-col justify-between"><div>Pending: <?= $pen_gaz_no ?></div><div>Approved: <?= $app_gaz_no ?></div><div>Disapproved: <?= $dis_gaz_no ?></div></div>
                            </div>
                        </div>
                        
                        <div class="overflow-auto">
                        <table class="min-w-full divide-y divide-gray-200 shadow-lg">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reason</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted At</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($all_applications as $stat): ?>
                                
                                <tr class="hover:bg-gray-100 transition-all">
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500"><?= $stat->id ?></td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500"><?= $stat->application_type ?></td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500"><?= $stat->status ?></td>
                                    <td class="text-center px-4 py-2 whitespace-nowrap text-sm text-gray-500"><?= $stat->start_date.'<br> to <br>'.$stat->end_date ?></td>
                                    <td class="max-w-[35%]  px-4 py-2 whitespace text-sm text-gray-500"><?= $stat->reason ?></td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500"><?= $stat->created_at ?></td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
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

<script>

function fetchSummary(day){

  const currentDate = new Date();
  const month = <?= $month_this; ?>;
  const year = currentDate.getFullYear();

  alert_float("info","Loading...");

  $.ajax({
        url: admin_url + 'team_management/fetch_staff_day_summaries/',
        type: 'POST',
        data: {
            staff_id: <?= $staff_id_this ?>,
            day: day,
            month: month,
            year: year,
            [csrfData.token_name]: csrfData.hash,
        },
        dataType: 'json',
        success: function (data) {

            if(data.success){

                $('#dailySummaryModalBody').html(data.summary);
                $('#dailySummaryModalLabel').html(day+'/'+month+'/'+year + " Summary");
                $("#dailySummaryModal").modal("show");
            }else{
                alert_float("danger","No summary there!");
            }

        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert_float("danger","Error");
        }
    });
  
  
  

}


</script>

<script>
function fetchDailyInfo(day) {
    const staff_id = <?= $staff_id_this; ?> // Replace with the actual staff ID
    const currentDate = new Date();
    const month = <?= $month_this; ?>;
    const year = currentDate.getFullYear();
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
</body>
</html>