<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper">
  <div class="content">

  <div class="container mx-auto px-4 py-6">
    <div class="flex flex-row justify-between mb-6">
        <h1 class="text-3xl font-semibold">Dashboard</h1>
        <div class="max-w-sm flex flex-row gap-2">
        <input type="date" id="date-input" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline" value="<?= isset($selected_date) ? $selected_date : date('Y-m-d') ?>">
            <button id="searchBtn" class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Search</button>
        </div>
    </div>


      <!-- Create the container for the stats -->
      <div class="flex justify-between items-center p-4 gap-4">


      
         <!-- Present Card -->
         <div data-type="present" class="bg-white border-solid border-gray-200 hover:border-green-500 border-2 p-6 rounded-lg w-full shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all ease-in-out duration-300 cursor-pointer ">
            <div class="flex justify-between">
                  <div>
                     <h2 class="text-2xl font-semibold">Present</h2>
                     <p class="text-4xl font-bold"><?php echo $flash_stats['present']; ?></p>
                  </div>
                  <i class="fas fa-check text-green-500 hover:text-green-600"></i>
            </div>
         </div>
         
         <!-- Absent Card -->
         <div data-type="absent" class="bg-white border-solid border-gray-200 hover:border-red-500 border-2 p-6 rounded-lg w-full shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all ease-in-out duration-300 cursor-pointer">
            <div class="flex justify-between">
                  <div>
                     <h2 class="text-2xl font-semibold">Absent</h2>
                     <p class="text-4xl font-bold"><?php echo $flash_stats['absent']; ?></p>
                  </div>
                  <i class="fas fa-bed text-red-500 hover:text-red-600"></i>
            </div>
         </div>
         
         <!-- Late Card -->
         <div data-type="late" class="bg-white border-solid border-gray-200 hover:border-yellow-500 border-2 p-6 rounded-lg w-full shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all ease-in-out duration-300 cursor-pointer">
            <div class="flex justify-between">
                  <div>
                     <h2 class="text-2xl font-semibold">Late</h2>
                     <p class="text-4xl font-bold"><?php echo $flash_stats['late']; ?></p>
                  </div>
                  <i class="fas fa-clock text-yellow-500 hover:text-yellow-600"></i>
            </div>
         </div>

         <!-- Leave Card -->
         <div data-type="leave" class="bg-white border-solid border-gray-200 hover:border-blue-500 border-2 p-6 rounded-lg w-full shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all ease-in-out duration-300">
            <div class="flex justify-between">
                  <div>
                     <h2 class="text-2xl font-semibold">On Leave</h2>
                     <p class="text-4xl font-bold"><?php echo $flash_stats['leave']; ?></p>
                  </div>
                  <i class="fas fa-plane-departure text-blue-500 hover:text-blue-600"></i>
            </div>
         </div>
      </div>


      <div class="flex flex-row p-4 gap-8">
         <div class="flex flex-col justify-center gap-20 mt-8 w-1/3">
            <div class="text-2xl text-gray-800 font-semibold text-center relative">
               <h3 class="mb-8">Task Goal</h3>
               <div class="w-full h-[200px]">
                  <canvas id="taskGoalChart"></canvas>
                  <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                     <span class="font-bold"><?= $report_data['total_tasks_rate'] ?>%</span>
                  </div>
               </div>
            </div>

            <div class="text-2xl text-gray-800 font-semibold text-center relative">
               <h3 class="mb-8">Clock In Goal</h3>
               <div class="w-full h-[200px]">
                  <canvas id="clockInGoalChart"></canvas>
                  <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                     <span class="font-bold"><?= round(($report_data['actual_total_logged_in_time']) / ($report_data['total_loggable_hours'])*100) ?>%</span>
                  </div>
               </div>
            </div>

            <div class="text-2xl text-gray-800 font-semibold text-center relative">
               <h3 class="mb-8">Summary Ratio</h3>
               <div class="w-full h-[200px]">
                  <canvas id="summaryRatioChart"></canvas>
                  <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                     <span class="font-bold"><?= round(($summary_ratio['staff_with_summaries'] / $summary_ratio['total_staff'])*100) ?>%</span>
                  </div>
               </div>
            </div>

         </div>

         <div class="w-2/3 bg-white p-4 rounded-lg flex flex-col gap-10">

            <div class="w-full h-[400px]">
               <canvas id="monthlyAttendanceChart"></canvas>
            </div>

            <div class="w-full h-[400px]">
               <canvas id="taskKPIChart"></canvas>
            </div>

         </div>

      </div>
  </div>

</div>


<!-- modal code  -->
<div class="modal fade" id="staffModal" tabindex="-1" role="dialog" aria-labelledby="staffModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-white rounded-lg shadow-xl">
      <div class="modal-header bg-gray-200 p-4 flex justify-between items-center">
        <div></div> <!-- Empty div for flex justification -->
        <h5 class="modal-title text-2xl font-semibold text-gray-700 mx-auto" id="staffModalLabel"></h5>
        <button type="button" class="close text-gray-600 hover:text-gray-800 text-2xl" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="hover:text-red-500">&times;</span>
        </button>
      </div>
      <div class="modal-body p-6 text-lg">
        <!-- Staff names will go here -->
      </div>
    </div>
  </div>
</div>





<!-- modal code  -->
<div class="modal fade" id="staffModal" tabindex="-1" role="dialog" aria-labelledby="staffModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-white rounded-lg shadow-xl">
      <div class="modal-header bg-gray-200 p-4 flex justify-between items-center">
        <div></div> <!-- Empty div for flex justification -->
        <h5 class="modal-title text-2xl font-semibold text-gray-700 mx-auto" id="staffModalLabel"></h5>
        <button type="button" class="close text-gray-600 hover:text-gray-800 text-2xl" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="hover:text-red-500">&times;</span>
        </button>
      </div>
      <div class="modal-body p-6 text-lg">
        <!-- Staff names will go here -->
      </div>
    </div>
  </div>
</div>





<?php init_tail(); ?>

<script>
  

  var staffNames = <?php echo json_encode($flash_staff_names); ?>;

$(document).ready(function() {
  $("div[data-type]").click(function() {
    const cardType = $(this).data("type");
    
    let staffNamesForType = staffNames[cardType] || [];
    let content = "";

    if (staffNamesForType.length === 0) {
      content = "<p>No Staff Available</p>"; // Message when no staff are available
    } else {
      content = "<ul>"; // Initialize as an unordered list
      
      for(let i = 0; i < staffNamesForType.length; i++) {
        content += "<li><strong>" + staffNamesForType[i] + "</strong></li>"; // Add list items with strong tags for bold text
      }
  
      content += "</ul>"; // Close the unordered list
    }
    
    $("#staffModal .modal-body").html(content);
    $("#staffModalLabel").text(cardType.charAt(0).toUpperCase() + cardType.slice(1) + " Staff");
    $("#staffModal").modal("show");
  });
});





const commonConfig = {
  type: 'doughnut',
  options: {
    rotation: 1 * Math.PI,
    circumference: 1 * Math.PI,
    legend: {
      display: false
    },
    maintainAspectRatio: false,
  }
};

new Chart(document.getElementById('taskGoalChart'), {
  ...commonConfig,
  data: {
    labels: ['Completed' , 'Due'],
    datasets: [{
      data: [<?= $report_data['total_completed_tasks'] ?>, <?= $report_data['total_all_tasks'] ?> - <?= $report_data['total_completed_tasks'] ?>],
      backgroundColor: ['rgb(12, 186, 186, 0.3)', 'rgba(249, 57, 67,0.3)'],
      borderColor: ['rgb(12, 186, 186)', 'rgb(249, 57, 67)'],
      borderWidth: 1,
      cutout: '80%',
    }]
  }
});

new Chart(document.getElementById('clockInGoalChart'), {
  ...commonConfig,
  data: {
    labels: ['Clocked in Hours', 'Left Hours'],
    datasets: [{
      data: [<?= floor($report_data['actual_total_logged_in_time'] / 3600) ?>, <?=  floor($report_data['total_loggable_hours'] / 3600) ?>  - <?=  floor($report_data['actual_total_logged_in_time'] / 3600) ?>],
      backgroundColor: ['rgb(12, 186, 186, 0.3)', 'rgba(249, 57, 67,0.3)'],
      borderColor: ['rgb(12, 186, 186)', 'rgb(249, 57, 67)'],
      borderWidth: 1,
      cutout: '80%',
    }]
  }
});

new Chart(document.getElementById('summaryRatioChart'), {
  ...commonConfig,
  data: {
    labels: ['Submitted', 'Not Submitted'],
    datasets: [{
      data: [<?= $summary_ratio['staff_with_summaries'] ?>, <?= $summary_ratio['total_staff'] ?> - <?= $summary_ratio['staff_with_summaries'] ?>],
      backgroundColor: ['rgb(12, 186, 186, 0.3)', 'rgba(249, 57, 67,0.3)'],
      borderColor: ['rgb(12, 186, 186)', 'rgb(249, 57, 67)'],
      cutout: '80%',
    }]
  }
});


// Preparing your dataset from PHP associative array to JavaScript object
const monthlyStats = <?= json_encode($monthly_stats); ?>;

// Extract data for individual labels
const labels = Object.keys(monthlyStats.present);
const presentData = Object.values(monthlyStats.present);
const absentData = Object.values(monthlyStats.absent);
const lateData = Object.values(monthlyStats.late);
const leaveData = Object.values(monthlyStats.leave);

// Line chart configuration
const lineConfig = {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Present',
            data: presentData,
            borderColor: 'rgba(75, 192, 192, 1)',
            fill: false
        }, {
            label: 'Absent',
            data: absentData,
            borderColor: 'rgba(255, 99, 132, 1)',
            fill: false
        }, {
            label: 'Late',
            data: lateData,
            borderColor: 'rgba(255, 159, 64, 1)',
            fill: false
        }, {
            label: 'Leave',
            data: leaveData,
            borderColor: 'rgba(153, 102, 255, 1)',
            fill: false
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
};

// Create chart
const ctx = document.getElementById('monthlyAttendanceChart').getContext('2d');
new Chart(ctx, lineConfig);

const tasksLabels = <?php echo json_encode(array_keys($staff_task_stats)); ?>;
const totalTasks = <?php echo json_encode(array_column($staff_task_stats, 'total_tasks')); ?>;
const completedTasks = <?php echo json_encode(array_column($staff_task_stats, 'completed_tasks')); ?>;

const tasksCtx = document.getElementById('taskKPIChart').getContext('2d');

// Define the chart
const taskKPIChart = new Chart(tasksCtx, {
    type: 'line',
    data: {
        labels: tasksLabels,
        datasets: [{
            label: 'Total Tasks',
            borderColor: 'rgb(75, 192, 192)',
            data: totalTasks,
        },
        {
            label: 'Completed Tasks',
            borderColor: 'rgb(255, 99, 132)',
            data: completedTasks,
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

document.addEventListener('DOMContentLoaded', (event) => {
        document.getElementById('searchBtn').addEventListener('click', changeReport);
    });

    function changeReport() {
        var date = document.getElementById('date-input').value;
        const selectedDate = new Date(date);
        const selectedMonth = ("0" + (selectedDate.getMonth() + 1)).slice(-2);
        const selectedDay = ("0" + selectedDate.getDate()).slice(-2);
        // Change this URL if the controller method for this view is different.
        window.location.href = "<?= admin_url('team_management/dashboard') ?>/" + selectedMonth + "/" + selectedDay;
    }

</script>



</body>
</html>
