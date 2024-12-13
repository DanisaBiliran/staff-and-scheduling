<?php require_once __DIR__ . "/classes/wards.class.php"; ?>
<?php session_start() ?>

<?php $wards = new Wards() ?>


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
              Create Ward
            </button>

          </div>
          <table id="data-table" style="width: 100%;" class="table table-auto ">
            <thead>
              <tr class="bg-base-200">
                <th class="rounded-s">Name</th>
                <th>Capacity</th>
                <th>Type</th>
                <th>Current Occupancy</th>
                <th class="rounded-e">Actions</th>
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
                  <td>
                    <div class="flex item-center gap-2">
                      <button data-id="<?= $ward_id ?>" class="edit btn btn-square btn-sm btn-ghost">
                        <i data-lucide="edit" class="h-4 w-4"></i>
                      </button>
                      <button data-id="<?= $ward_id ?>" class="delete btn btn-square btn-sm btn-ghost">
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
          <h3 class="text-lg font-bold">Register Ward</h3>
          <form action="./api/wards.php" method="POST">
            <input type="hidden" name="ward_id">
            <label class="form-control w-full">
              <div class="label">
                <span class="label-text">Ward Name</span>
              </div>
              <input type="text" name="name" placeholder="Type name" class="input input-bordered w-full" />
            </label>
            <label class="form-control w-full">
              <div class="label">
                <span class="label-text">Capacity</span>
              </div>
              <input type="number" name="capacity" class="input input-bordered w-full" />
            </label>
            <label class="form-control w-full">
              <div class="label">
                <span class="label-text">Type</span>
              </div>
              <select name="type" class="select select-bordered">
                <option disabled selected>Select Type</option>
                <option>General Ward</option>
                <option>Intensive Care Unit (ICU)</option>
                <option>Emergency Ward</option>
                <option>Maternity Ward</option>
                <option>Pediatric Ward</option>
                <option>Oncology Ward</option>
                <option>Orthopedic Ward</option>
                <option>Cardiac Care Unit (CCU)</option>
                <option>Palliative Care Ward</option>
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
      $("input[name='ward_id']").val("");
    })


    $(".edit").click(function () {
      $.ajax({
        url: `./api/wards.php?ward_id=${$(this).attr("data-id")}`,
        method: "GET",
        dataType: "json",
        success(data) {
          for (const [key, value] of Object.entries(data)) {
            $(`input[name='${key}']`).val(value)
            $(`select[name='${key}']`).val(value)
            $(`textarea[name='${key}']`).val(value)
          }

          modal.showModal();
        },
      })
    })

    $(".delete").click(function () {
      $.ajax({
        url: `./api/wards.php?ward_id=${$(this).attr("data-id")}`,
        method: "DELETE",
        dataType: "json",
        success(data) {
          window.location.reload();
        },
        error() {
          window.location.reload();
        }
      })
    }).then(() => {
      window.location.reload();
    });
  </script>

  <script></script>
</body>

</html>