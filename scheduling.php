<?php require_once __DIR__ . "/classes/scheduling.class.php"; ?>
<?php require_once __DIR__ . "/classes/wards.class.php"; ?>
<?php require_once __DIR__ . "/classes/patients.class.php"; ?>
<?php session_start() ?>

<?php $scheduling = new Scheduling() ?>


<!DOCTYPE html>
<html lang="en" data-theme="light">

<?php require_once __DIR__ . "/includes/head.php"; ?>


<body>
  <div class="drawer lg:drawer-open">
    <input id="sidebar" type="checkbox" class="drawer-toggle" />

    <div class="drawer-content bg-base-200">
      <?php require_once __DIR__ . "/includes/navbar.php"; ?>

      <section class="p-4">
        <div class="border rounded w-full bg-base-100 p-4 overflow-x-scroll">
          <div class="flex items-center justify-between mb-4">
            <div class="flex">
              <label class="input input-bordered flex items-center gap-2">
                <input id="search-table" type="text" class="grow" placeholder="Search" />
                <i data-lucide="search" class="h-4 w-4 opacity-70"></i>
              </label>
            </div>
            <button onclick="modal.showModal()" class="btn btn-primary">
              <i data-lucide="plus-circle" class="h-5 w-5"></i>
              Create Schedule
            </button>

          </div>
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

      <dialog id="modal" class="modal">
        <div class="modal-box max-w-sm rounded-lg">
          <h3 class="text-lg font-bold">Schedule Ward</h3>
          <form action="./api/scheduling.php" method="POST">
            <input type="hidden" name="schedule_id">
            <label class="form-control w-full">
              <div class="label">
                <span class="label-text">Patient</span>
              </div>
              <select name="patient_id" id="patient_id" class="select select-bordered">
                <option disabled selected>Select Patient</option>
                <?php $patients = new Patients(); ?>
                <?php foreach ($patients->fetchAll() as $patient): ?>
                  <option value="<?= $patient["patient_id"] ?>"><?= $patient["name"] ?></option>
                <?php endforeach; ?>
              </select>
            </label>
            <label class="form-control w-full">
              <div class="label">
                <span class="label-text">Ward</span>
              </div>
              <select name="ward_id" id="ward_id" class="select select-bordered">
                <option disabled selected>Select Ward</option>
                <?php $wards = new Wards(); ?>
                <?php foreach ($wards->fetchAll() as $ward): ?>
                  <option value="<?= $ward["ward_id"] ?>"><?= $ward["name"] ?></option>
                <?php endforeach; ?>
              </select>
            </label>
            <label class="form-control w-full">
              <div class="label">
                <span class="label-text">Start Date</span>
              </div>
              <input type="date" name="start_date" class="input input-bordered w-full" />
            </label>
            <label class="form-control w-full">
              <div class="label">
                <span class="label-text">End Date</span>
              </div>
              <input type="date" name="end_date" class="input input-bordered w-full" />
            </label>
            <label class="form-control w-full" id="status-group">
              <div class="label">
                <span class="label-text">Status</span>
              </div>
              <select name="status" id="status" class="select select-bordered">
                <option disabled selected>Select Status</option>
                <option value="Scheduled">Scheduled</option>
                <option value="Completed">Completed</option>
                <option value="Cancelled">Cancelled</option>
              </select>
            </label>
          </form>
          <div class="modal-action">
            <form method="dialog">
              <button id="close-modal" class="btn">Close</button>
              <button onclick="javascript:$('form').submit();" type="button" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>
      </dialog>
    </div>


    <?php require_once __DIR__ . "/includes/sidebar.php"; ?>
  </div>

  <script>
    lucide.createIcons();
  </script>

  <script>
    $(`#status-group`).hide();

    (function () {
      const table = new DataTable('#data-table', {
        responsive: true,
        language: {
          paginate: {
            previous: '&lt;',
            next: '&gt;'
          }
        },
      });

      $("#search-table").on("keypress", function () {
        table.search(this.value).draw();
      })
    })()

    $("#close-modal").click(function () {
      $("input[name='schedule_id']").val("");
      $(`#status-group`).hide()
    })


    $(".edit").click(function () {
      $.ajax({
        url: `./api/scheduling.php?schedule_id=${$(this).attr("data-id")}`,
        method: "GET",
        dataType: "json",
        success(data) {
          console.log(data);
          for (const [key, value] of Object.entries(data)) {
            console.log(key, value)
            $(`input[name='${key}']`).val(value)
            $(`select[name='${key}']`).val(value)
            $(`textarea[name='${key}']`).val(value)
          }

          $(`#patient_id`).val(data["patient_id"])
          $(`#ward_id`).val(data["ward_id"])
          $(`#status`).val(data["status"])
          $(`#status-group`).show()

          modal.showModal();
        },
      })
    })

    $(".delete").click(function () {
      console.log("clicked")
      $.ajax({
        url: `./api/scheduling.php?schedule_id=${$(this).attr("data-id")}`,
        method: "DELETE",
        dataType: "json",
        error() {
          window.location.reload();
        }
      }).then(() => {
        window.location.reload();
      })
    });
  </script>

  <script></script>
</body>

</html>