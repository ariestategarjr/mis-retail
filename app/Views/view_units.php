
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
                <table class="table table-bordered">
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
                    <?php foreach($satuan as $key => $value) { ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td><?= $value->id_satuan ?></td>
                      <td><?= $value->nama_satuan ?></td>
                      <td>
                        <button class="btn btn-warning btn-sm btn-flat"><i class="fas fa-pencil-alt"></i></button>
                        <button class="btn btn-danger btn-sm btn-flat"><i class="fas fa-trash"></i></button>
                      </td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->



    