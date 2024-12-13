<?php
  include("chuchu.php");
?>
<?php session_start() ?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<?php require_once __DIR__ . "/classes/patients.class.php"; ?>
<?php require_once __DIR__ . "/classes/wards.class.php"; ?>
<?php require_once __DIR__ . "/classes/scheduling.class.php"; ?>
<?php require_once __DIR__ . "/includes/head.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



<body>
  <div class="drawer lg:drawer-open">
    <input id="sidebar" type="checkbox" class="drawer-toggle" />

    <div class="drawer-content bg-base-200">
      <?php require_once __DIR__ . "/includes/navbar.php"; ?>

      <section class="px-4 pt-4 pb-4 container mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
          <div class="border rounded bg-base-100 p-4">
            <?php $patients = new Patients(); ?>
            <h1>Total Patients</h1>
            <b></b>
            <h1 class="font-bold text-2xl"><?php echo $total_patients; ?></h1>
            <img src="images/inpatient.png" alt="">
          </div>

          <?php
                // DATA for pie chart
                $medical_count = isset($inventory_by_type['Medical']) ? $inventory_by_type['Medical'] : 0;
                $surgical_count = isset($inventory_by_type['Surgical']) ? $inventory_by_type['Surgical'] : 0;
            ?>



          <div class="border rounded bg-base-100 p-4">
            <?php $wards = new Wards(); ?>
            <h1>Total Wards</h1>
            <h1 class="font-bold text-2xl"><?= count($wards->fetchAll()) ?></h1>
            <img src="images/material-symbols--ward-rounded.png" alt="">
          </div>
          <div class="border rounded bg-base-100 p-4">
            <?php $scheduling = new Scheduling(); ?>
            <h1>Inventory Stocks</h1>
            <h1 class="font-bold text-2xl"><?= count(value: $scheduling->fetchAll()) ?></h1>
            <canvas id="inventoryPieChart"></canvas>
          </div>
            <!-- WEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE -->
          <div class="border rounded bg-base-100 p-4">
            <?php $scheduling = new Scheduling(); ?>
            <h1>Total number of Physician</h1>
            <h1 class="font-bold text-2xl"><?php echo $total_physicians; ?></h1>
            <img src="images/staffs.png" alt="">
          </div>

          <?php
                //DATA for pie chart
                    $male_count = isset($patients_by_gender['M']) ? $patients_by_gender['M'] : 0;
                    $female_count = isset($patients_by_gender['F']) ? $patients_by_gender['F'] : 0;
                ?>

          <div class="border rounded bg-base-100 p-4">
            <?php $scheduling = new Scheduling(); ?>
            <h1>Patients by Gender</h1>
            <h1 class="font-bold text-2xl"><?= count(value: $scheduling->fetchAll()) ?></h1>
            <canvas id="genderPieChart"></canvas>
          </div>

          <div class="border rounded bg-base-100 p-4">
            <?php $scheduling = new Scheduling(); ?>
            <h1>Available Staff</h1>
            <h1 class="font-bold text-2xl"><b><?php echo $available_staff; ?></b></h1>
            <img src="images/staffs.png" alt="">
          </div>
            <!-- WEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE -->
          <div class="border rounded bg-base-100 p-4">
            <?php $scheduling = new Scheduling(); ?>
            <h1>Scheduled Patients</h1>
            <h1 class="font-bold text-2xl"><?= count(value: $scheduling->fetchAll()) ?></h1>
            <img src="images/ant-design--schedule-outlined.png" alt="">
          </div>

          <div class="border rounded bg-base-100 p-4">
            <?php $scheduling = new Scheduling(); ?>
            <h1>Patients by Status</h1>
            <h1 class="font-bold text-2xl"><?= count(value: $scheduling->fetchAll()) ?></h1>
            <canvas id="statusPieChart"></canvas>
          </div>
        </div>
      </section>
      <section class="px-4 pb-4 container mx-auto grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="border rounded bg-base-100 p-4 overflow-x-scroll">
          <?php $wards = new Wards(); ?>
          <h1 class="font-medium mb-4">Ward Availability</h1>
          <table id="data-table" style="width: 100%;" class="table table-auto ">
            <thead>
              <tr class="bg-base-200">
                <th class="rounded-s">Name</th>
                <th>Capacity</th>
                <th>Type</th>
                <th>Current Occupancy</th>
              </tr>
            </thead>
            <tbody>

              <?php foreach ($wards->fetchAll() as $ward):
                extract($ward); ?>
                <tr>
                  <td><?= $name ?></td>
                  <td><?= $capacity ?></td>
                  <td><?= $type ?></td>
                  <td><?= $available_capacity ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <div class="border rounded bg-base-100 p-4 overflow-x-scroll">
          <?php $patients = new Patients(); ?>
          <h1 class="font-medium mb-4">Recent Appointments</h1>
          <table id="data-table" style="width: 100%;" class="table table-auto ">
            <thead>
              <tr class="bg-base-200">
                <th class="rounded-s">Patient Name</th>
                <th>Ward Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th class="rounded-e">Actions</th>
              </tr>
            </thead>
            <tbody>
              

              <?php foreach ($scheduling->fetchAll() as $schedule):
                extract($schedule); ?>
                <tr>
                  <td><?= $patient_name ?></td>
                  <td><?= $ward_name ?></td>
                  <td><?= $start_date ?></td>
                  <td><?= $end_date ?></td>
                  <td>
                    <span class="badge badge-primary"><?= $status ?></span>
                  </td>
                  <td>
                    <div class="flex item-center gap-2">
                      <button data-id="<?= $schedule_id ?>" class="edit btn btn-square btn-sm btn-ghost">
                        <i data-lucide="edit" class="h-4 w-4"></i>
                      </button>
                      <button data-id="<?= $schedule_id ?>" class="delete btn btn-square btn-sm btn-ghost">
                        <i data-lucide="trash" class="h-4 w-4 text-red-500"></i>
                      </button>
                    </div>
                  </td>

                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </section>
    </div>

    

    <?php require_once __DIR__ . "/includes/sidebar.php"; ?>
  </div>

  <script>
    lucide.createIcons();



        // INVENTORY
        const ctxInventory = document.getElementById('inventoryPieChart').getContext('2d');
        const inventoryPieChart = new Chart(ctxInventory, {
            type: 'pie',
            data: {
                labels: ['Medical', 'Surgical'],
                datasets: [{
                    label: 'Inventory Distribution',
                    data: [<?php echo $medical_count; ?>, <?php echo $surgical_count; ?>],
                    backgroundColor: [
                        '#00D89E',
                        '#752BDF'
                    ],
                    borderColor: [
                        '#00D89E',
                        '#752BDF'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display:true,
                        text:'Inventory Stocks'
                     }
                 }
             }
         });

        // GENDER
        const ctx = document.getElementById('genderPieChart').getContext('2d');
        const genderPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Male', 'Female'],
                datasets: [{
                    label: 'Patients by Gender',
                    data: [<?php echo $male_count; ?>, <?php echo $female_count; ?>],
                    backgroundColor: [
                        '#00D89E',
                        '#752BDF'
                    ],
                    borderColor: [
                        '#00D89E',
                        '#752BDF'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Patients by Gender'
                    }
                }
            }
        });

        // PATIENT STATUS
        const ctxStatus = document.getElementById('statusPieChart').getContext('2d');
        const statusPieChart = new Chart(ctxStatus, {
            type: 'pie',
            data: {
                labels: ['Discharged', 'Admitted'],
                datasets: [{
                    label: 'Patient Status',
                    data: [<?php echo $discharged_count; ?>, <?php echo $admitted_count; ?>],
                    backgroundColor: [
                        '#00D89E',
                        '#FF8B4F'
                    ],
                    borderColor: [
                        '#00D89E',
                        '#FF8B4F'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            color: 'white'
                        }
                    },
                    title: {
                        display: true,
                        text: 'Patients by Status',
                        color: 'white'
                    }
                }
            }
        });
  </script>
</body>

</html>