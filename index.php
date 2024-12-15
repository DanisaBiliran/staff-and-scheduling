<?php
  include("chuchu.php");
  include 'conn.php';
?>
<?php session_start() ?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<?php require_once __DIR__ . "/classes/patients.class.php"; ?>
<?php require_once __DIR__ . "/classes/wards.class.php"; ?>
<?php require_once __DIR__ . "/classes/scheduling.class.php"; ?>
<?php require_once __DIR__ . "/includes/head.php"; ?>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
  canvas{
    width: 40%;
  }
</style>

<body>
  <div class="drawer lg:drawer-open">
    <input id="sidebar" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content bg-base-200">
      <?php require_once __DIR__ . "/includes/navbar.php"; ?>
      <div class="flex flex-wrap gap-4 justify-end p-5 bg-base-100 rounded shadow">
        <a href="patientDetailsForm.php">
          <button id="CreatePatient" onclick="modal.showModal()" class="btn btn-primary">
          <i data-lucide="plus-circle" class="h-5 w-5"></i>
          Register Patient
        </button>
        </a>
        <a href="staff.php">
          <button id="CreatePatient" onclick="modal.showModal()" class="btn btn-primary">
          <i data-lucide="plus-circle" class="h-5 w-5"></i>
          Register Staff
        </button>
        </a>
        <a href="vendorForm.php">
          <button id="CreateVendor" onclick="modal.showModal()" class="btn btn-primary">
          <i data-lucide="plus-circle" class="h-5 w-5"></i>
          Add Vendor
          </button>
        </a>
        <a href="physician.php">
          <button id="CreatePhysician" onclick="modal.showModal()" class="btn btn-primary">
          <i data-lucide="plus-circle" class="h-5 w-5"></i>
          Add Physician
          </button>
        </a>
        <a href="medicalorder.php">
          <button id="CreateMedicalOrder" onclick="modal.showModal()" class="btn btn-primary">
          <i data-lucide="plus-circle" class="h-5 w-5"></i>
          Place Order
          </button>
        </a>
        <a href="medicalSurgicalItem.php">
          <button id="CreateMedicalItem" onclick="modal.showModal()" class="btn btn-primary">
          <i data-lucide="plus-circle" class="h-5 w-5"></i>
          Add Item
        </button>
        </a>
</div>
<section class="px-5 pt-5 pb-5 container">
  <div class="grid grid-cols-1 m-5 sm:grid-cols-3 gap-3">
    <div class="border rounded bg-base-100 p-4">
      <?php $patients = new Patients(); ?>
      <h1>Total Patients</h1>
      <b></b>
      <h1 class="font-bold text-2xl"><?php echo $total_patients; ?></h1>
    </div>

    <div class="border rounded bg-base-100 p-4">
      <?php $scheduling = new Scheduling(); ?>
      <h1>Total number of Physician</h1>
      <h1 class="font-bold text-2xl"><?php echo $total_physicians; ?></h1>
    </div>

    <div class="border rounded bg-base-100 p-4">
      <?php $scheduling = new Scheduling(); ?>
      <h1>Available Staff</h1>
      <h1 class="font-bold text-2xl"><b><?php echo $available_staff; ?></b></h1>
    </div>

    <div class="border rounded bg-base-100 p-4">
      <?php $scheduling = new Scheduling(); ?>
      <h1>Patients by Gender</h1>
      <h1 class="font-bold text-2xl"><?= count(value: $scheduling->fetchAll()) ?></h1>
      <canvas id="genderPieChart" class="w-48 h-48 mx-auto"></canvas>
    </div>

    <?php
    // DATA for pie chart
    $medical_count = isset($inventory_by_type['Medical']) ? $inventory_by_type['Medical'] : 0;
    $surgical_count = isset($inventory_by_type['Surgical']) ? $inventory_by_type['Surgical'] : 0;
    $medicine_count = isset($inventory_by_type['Medicine']) ? $inventory_by_type['Medicine'] : 0;
    ?>

    <div class="border rounded bg-base-100 p-4">
      <h1>Inventory Stocks</h1>
      <p class="font-bold text-2">Medical: <h1><?= $medical_count; ?></h1></p>
      <p class="font-bold text-2">Surgical: <h1><?= $surgical_count; ?></h1></p>
      <p class="font-bold text-2">Medicine: <h1><?= $medicine_count; ?></h1></p>
      <canvas id="inventoryPieChart" class="w-48 h-48 mx-auto"></canvas>
    </div>

    <div class="border rounded bg-base-100 p-4">
      <?php $scheduling = new Scheduling(); ?>
      <h1>Patients by Status</h1>
      <h1 class="font-bold text-2xl"><?= count(value: $scheduling->fetchAll()) ?></h1>
      <canvas id="statusPieChart" class="w-48 h-48 mx-auto"></canvas>
    </div>
  </div>
</section>


<!--<div class="border rounded bg-base-100 p-4">
<?php $scheduling = new Scheduling(); ?>
            <h1>Patients by Status</h1>
            <h1 class="font-bold text-2xl"><?= count(value: $scheduling->fetchAll()) ?></h1>
            <canvas id="statusPieChart"></canvas>
          </div>
        </div>
      </section> -->

      <!-- <section class="px-4 pb-4 container mx-auto grid grid-cols-1 sm:grid-cols-2 gap-4">
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
      </section> -->
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
                labels: ['Medical', 'Surgical', 'Medicine'],
                datasets: [{
                    label: 'Inventory Distribution',
                    data: [<?php echo $medical_count; ?>, <?php echo $surgical_count; ?>, <?php echo $medicine_count?>],
                    backgroundColor: [
                        '#00D89E',
                        '#752BDF',
                        '#FF8B4F'

                    ],
                    borderColor: [
                        '#00D89E',
                        '#752BDF',
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

      // For the buttons
      
  </script>
  
</body>

</html>