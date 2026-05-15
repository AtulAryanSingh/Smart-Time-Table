<?php require_once __DIR__ . '/../../app/bootstrap.php';
$config = require APP_ROOT . '/app/config.php';
$base = $config['app']['base_url'];
$user = current_user();
if (!$user) { header('Location: ' . $base . '/auth/login.php'); exit; }
if ($user['role'] !== 'admin') { http_response_code(403); echo 'Forbidden'; exit; }
?><!doctype html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Manage Rooms</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 m-0">Rooms</h1>
    <a class="btn btn-outline-secondary btn-sm" href="<?= htmlspecialchars($base) ?>/admin/dashboard.php">Back</a>
  </div>

  <div class="card shadow-sm mb-3">
    <div class="card-body">
      <form id="createForm" class="row g-2">
        <div class="col-md-6">
          <input name="name" class="form-control" placeholder="Room name (e.g., A-103)" required>
        </div>
        <div class="col-md-3">
          <input name="capacity" type="number" class="form-control" placeholder="Capacity" min="1" required>
        </div>
        <div class="col-md-3">
          <button class="btn btn-primary w-100" type="submit">Add room</button>
        </div>
      </form>
      <div id="alert" class="mt-3"></div>
    </div>
  </div>

  <div class="card shadow-sm">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-sm" id="roomsTable">
          <thead><tr><th>ID</th><th>Name</th><th>Capacity</th><th>Actions</th></tr></thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
const tableBody = document.querySelector('#roomsTable tbody');
const alertBox = document.getElementById('alert');
const createForm = document.getElementById('createForm');

function showAlert(type, msg){
  alertBox.innerHTML = `<div class="alert alert-${type}">${msg}</div>`;
}

async function loadRooms(){
  tableBody.innerHTML = '';
  const res = await fetch('../api/rooms/list.php');
  const json = await res.json();
  if(!json.success){ showAlert('danger', json.error); return; }
  for(const r of json.data){
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${r.id}</td>
      <td><input class="form-control form-control-sm" value="${r.name}" data-field="name"></td>
      <td><input class="form-control form-control-sm" type="number" min="1" value="${r.capacity}" data-field="capacity"></td>
      <td class="text-nowrap">
        <button class="btn btn-sm btn-outline-primary" data-action="save">Save</button>
        <button class="btn btn-sm btn-outline-danger" data-action="delete">Delete</button>
      </td>
    `;
    tr.querySelector('[data-action="save"]').addEventListener('click', async () => {
      const name = tr.querySelector('[data-field="name"]').value;
      const capacity = tr.querySelector('[data-field="capacity"]').value;
      const fd = new FormData();
      fd.append('id', r.id);
      fd.append('name', name);
      fd.append('capacity', capacity);
      const rs = await fetch('../api/rooms/update.php', {method:'POST', body: fd});
      const j = await rs.json();
      if(!j.success){ showAlert('danger', j.error); return; }
      showAlert('success', 'Updated');
      loadRooms();
    });
    tr.querySelector('[data-action="delete"]').addEventListener('click', async () => {
      if(!confirm('Delete this room?')) return;
      const fd = new FormData();
      fd.append('id', r.id);
      const rs = await fetch('../api/rooms/delete.php', {method:'POST', body: fd});
      const j = await rs.json();
      if(!j.success){ showAlert('danger', j.error); return; }
      showAlert('success', 'Deleted');
      loadRooms();
    });

    tableBody.appendChild(tr);
  }
}

createForm.addEventListener('submit', async (e)=>{
  e.preventDefault();
  const fd = new FormData(createForm);
  const res = await fetch('../api/rooms/create.php', {method:'POST', body: fd});
  const json = await res.json();
  if(!json.success){ showAlert('danger', json.error); return; }
  createForm.reset();
  showAlert('success', 'Room added');
  loadRooms();
});

loadRooms();
</script>
</body>
</html>
