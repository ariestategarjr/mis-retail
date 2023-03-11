
          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"><?= $subtitle ?></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#modal-add"><i class="fas fa-plus"></i>
                    Add Unit
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered" id="table">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Id Satuan</th>
                      <th>Nama Satuan</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                    <?php $no = 1 ?>
                    <?php foreach($satuan as $row) : ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td><?= $row->nama_satuan ?></td>
                      <td>
                        <button class="btn btn-warning btn-sm btn-flat"><i class="fas fa-pencil-alt"></i></button>
                        <button class="btn btn-danger btn-sm btn-flat"><i class="fas fa-trash"></i></button>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->

      <div class="modal fade" id="modal-add">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add <?= $subtitle ?></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <?php
            $action = 'unit/add';
            $attributes = array('id' => 'FormAddUnits', 'method' => 'post', 'autocomplete' => 'off', 'required' => true);
            
            echo form_open($action, $attributes)
            ?>
            <div class="modal-body">
              <div class="form-group">
                <label for="idAdd">Id Satuan</label>
                <input type="text" class="form-control" id="idAdd" name="id_satuan">
              </div>
              <div class="form-group">
                <label for="nameAdd">Nama Satuan</label>
                <input type="text" class="form-control" id="nameAdd" name="nama_satuan">            
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
            <?php echo form_close() ?>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <script>
      $(document).ready(function() {
        $('#table').DataTable({
          processing: true,
          serverSide: true,
          // ajax: 'https://codeigniter4-datatables.hermawan.dev/ajax-datatable/basic'
          ajax: 'https://codeigniter4-datatables.hermawan.dev/ajax-datatable/basic'
        });
      });
      </script>

    